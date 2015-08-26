<?php

    class Author
    {
        private $author_name;
        private $id;


        function __construct($author_name, $id = null)
        {
            $this->author_name = $author_name;
            $this->id = $id;
        }

        function setAuthorName($new_author_name)
        {
            $this->author_name = $new_author_name;
        }

        function getAuthorName()
        {
            return $this->author_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (author_name)
            VALUES ('{$this->getAuthorName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = array();
            foreach($returned_authors as $author) {
                $author_name = $author['author_name'];
                $id = $author['id'];
                $new_author = new Author($author_name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE author_id = {$this->getId()};");
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM authors;");
        }

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id)
                VALUES ({$this->getId()}, {$book->getId()});");
        }

        function getBooks()
        {
            $found_books = $GLOBALS['DB']->query(
            "SELECT books.* FROM
            authors JOIN authors_books ON (authors.id = authors_books.author_id)
                  JOIN books ON (authors_books.book_id = books.id)
            WHERE authors.id = {$this->getId()};"
            );

            $books = array();
            foreach ($found_books as $book) {
                $id = $book['id'];
                $book_title = $book['book_title'];
                $new_book = new Book($book_title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author) {
                $author_id = $author->getId();
                if ($search_id == $author_id) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }


    }
?>
