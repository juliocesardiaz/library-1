<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        // default delete function
        protected function tearDown()
        {
            Book::deleteAll();
        }

        function testSetBookTitle()
        {
            //Arrange
            $book_title = "Dune";
            $test_book = new Book($book_title);

            //Act
            $test_book->setBookTitle("Reamde");
            $result = $test_book->getBookTitle();

            //Assert
            $this->assertEquals("Reamde", $result);
        }

        function testGetBookTitle()
        {
            //Arrange
            $book_title = "Ender's Game";
            $test_book_title = new Book($book_title);

            //Act
            $result = $test_book_title->getBookTitle();

            //Assert
            $this->assertEquals($book_title, $result);
        }

        function testGetId()
        {
            //Arrange
            $id = 1;
            $book_title = "The Foundation";
            $test_book = new Book($book_title, $id);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            //Arrange
            $book_title = "Dune";
            $id = null;
            $test_book = new Book($book_title, $id);

            //Act
            $test_book->save();

            //Assert
            $result = Book::getAll();
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $book_title = "Snow Crash";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            $book_title2 = "Ready Player One";
            $id2 = null;
            $test_book2 = new Book($book_title2, $id2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }
    }
?>
