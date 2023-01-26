<?php
include_once('../Books.php');

$books = new Books();
$allbooks = isset($_POST['author']) && !empty($_POST['author']) ? $books->getBooksByAuthor($_POST['author']) : $books->getAllBooks();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<script src="animation.js"></script>
</head>
<body>
    <div class="container">
        <form id="search-form" method="POST" action="#">
            <div class="search-bar">
                <input type="text" placeholder="Search for Author" name="author" value="<?php echo $_POST['author']; ?>" >
                <button type="submit">Search</button>
                <div class="noresult-msg">
                    <?php if(!$allbooks && !empty($_POST['author'])) echo "No books found with the entered author name."?>
                </div>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Book Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ( $allbooks as $book ) {
                ?>
                <tr class="data-row">
                    <td><?php echo $book['author_name']; ?></td>
                    <td><?php echo $book['book_name']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>

