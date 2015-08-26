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

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM books;");
        }

    }
?>
