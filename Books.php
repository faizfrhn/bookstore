<?php

include_once('DBHelper.php');

class Books
{
    const BOOKS_PATH = __DIR__.'/books';
    const QUERY = [
        'GET_ALL_BOOKS' => "SELECT author_name, book_name FROM books join authors on book_author = author_id order by book_id",
        'GET_BOOKS_BYAUTHOR' => "SELECT author_name, book_name FROM books join authors on book_author = author_id where author_name = ? order by book_id",
        'GET_AUTHOR' => "SELECT * FROM authors where author_id = ?",
        'GET_AUTHOR_BYNAME' => "SELECT author_id FROM authors where author_name = ?",
        'GET_BOOK' => "SELECT * FROM books where book_id = ?",
        'INSERT_AUTHOR' => "INSERT INTO authors (author_name) values (?) returning author_id",
        'INSERT_BOOK' => "INSERT INTO books values (?, ?, ?) returning book_id",
        'UPDATE_AUTHOR_NAME' => "UPDATE authors set author_name = ? where author_id = ? returning author_id",
        'UPDATE_BOOK_NAME' => "UPDATE books set book_name = ? where book_id = ? returning book_id",
        'UPDATE_BOOK_AUTHOR' => "UPDATE books set book_author = ? where book_id = ? returning book_id",
    ];
    
    var $dbHelper;


    function __construct(DBHelper $dbHelper = null)
    {
        $this->dbHelper = $dbHelper ?? new DBHelper();
        $this->processBooksXMLContent();
    }

    public function getAllBooks()
    {
        $result = $this->dbHelper->getAll(self::QUERY['GET_ALL_BOOKS']);

        return $result;
    }

    public function getBooksByAuthor($author){
        $result = $this->dbHelper->getAll(self::QUERY['GET_BOOKS_BYAUTHOR'], [$author]);

        return $result;
    }

    private function processBooksXMLContent()
    {
        $files = $this->getAllBooksXML(self::BOOKS_PATH, '/\.xml$/');
        
        foreach ($files as $file){
            $xml = simplexml_load_file($file);

            foreach ($xml->book as $book){
                $bookDetails = $this->dbHelper->getRow(self::QUERY['GET_BOOK'], [$book->attributes()->id]);

                if(!$bookDetails){
                    $author_id = $this->dbHelper->getOne(self::QUERY['GET_AUTHOR_BYNAME'], [$book->author]);         
                    if(!$author_id){
                        $author_id = $this->dbHelper->execute(self::QUERY['INSERT_AUTHOR'], [$book->author]);
                    }

                    $this->dbHelper->execute(self::QUERY['INSERT_BOOK'], [$book->attributes()->id, $book->name, $author_id]);
                } else {
                    // update book name if xml different than db
                    if($bookDetails['book_name'] !== (string) $book->name) {
                        $this->dbHelper->execute(self::QUERY['UPDATE_BOOK_NAME'], [$book->name, $book->attributes()->id]);
                    }
    
                    // update author name if xml different than db
                    $author = $this->dbHelper->getRow(self::QUERY['GET_AUTHOR'], [$bookDetails['book_author']]);

                    if($author['author_name'] !== (string) $book->author) {
                        $author_id = $this->dbHelper->getOne(self::QUERY['GET_AUTHOR_BYNAME'], [$book->author]);      
                        if(!$author_id){
                            $author_id = $this->dbHelper->execute(self::QUERY['INSERT_AUTHOR'], [$book->author]);
                        }
                        $this->dbHelper->execute(self::QUERY['UPDATE_BOOK_AUTHOR'], [$author_id, $book->attributes()->id]);
                    }
                }
                
            }
            
        }
    }

    private function getAllBooksXML($dir, $filter = '', &$results = array()) {
        $files = scandir($dir);
    
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value); 
    
            if(!is_dir($path)) {
                if(empty($filter) || preg_match($filter, $path)) $results[] = $path;
            } elseif($value != "." && $value != "..") {
                $this->getAllBooksXML($path, $filter, $results);
            }
        }
    
        return $results;
    } 
    
}
