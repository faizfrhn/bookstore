# PHP Test Project

## About The Project
Basic program to process XML of books and display the books and authors in a page using PHP for a test.

The XML stored within the project directory is first sorted by the genre of the books and the subdirectories are divided by the first letter of the book's name.  

eg; Book Name = 'Another One Bites The Cookie' directory would be: books->fiction->A->list.xml

![image](https://user-images.githubusercontent.com/103376436/214969880-62ad777f-8333-4579-a2bd-ccbc67550f31.png)

### Built With
PHP: 8.2  
Postgres: 14.1

## Getting Started

As this test project was developed within Docker, to get a local copy you may set up Docker by following the link:
https://docs.docker.com/get-docker/

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/faizfrhn/bookstore.git
   ```
2. Build the Docker containers
   ```sh
   docker-compose build
   ```
3. Get the containers up and running
   ```sh
   docker-compose up
   ```
4. Navigate to localhost on your web browser to test
