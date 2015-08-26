<?php

    class Book
    {
        private $book_title;
        private $id;


        function __construct($book_title, $id = null)
        {
            $this->book_title = $book_title;
            $this->id = $id;
        }

        function setBookTitle($new_book_title)
        {
            $this->book_title = $new_book_title;
        }

        function getBookTitle()
        {
            return $this->book_title;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (book_title)
                VALUES ('{$this->getBookTitle()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();
            foreach($returned_books as $book) {
                $book_title = $book['book_title'];
                $id = $book['id'];
                $new_book = new Book($book_title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        function update($new_book_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET book_title = '{$new_book_title}'
                WHERE id = {$this->getId()};");
            $this->setBookTitle($new_book_title);
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE book_id = {$this->getId()};");
        }

        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id)
                VALUES ({$author->getId()}, {$this->getId()});");
        }

        function getAuthors()
        {
            $found_authors = $GLOBALS['DB']->query(
            "SELECT authors.* FROM
            books JOIN authors_books ON (books.id = authors_books.book_id)
                  JOIN authors ON (authors_books.author_id = authors.id)
            WHERE books.id = {$this->getId()};"
            );
            $authors = array();

            foreach ($found_authors as $author) {
                $id = $author['id'];
                $author_name = $author['author_name'];
                $new_author = new Author($author_name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach($books as $book) {
                $book_id = $book->getId();
                if ($search_id == $book_id) {
                    $found_book = $book;
                }
            }
            return $found_book;
        }


    }
?>
