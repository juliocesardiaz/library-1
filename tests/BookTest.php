<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Copy.php";

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
            Author::deleteAll();
            Copy::deleteAll();
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

        function testUpdate()
        {
            //Arrange
            $book_title = "Snow Crash";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            $new_book_title = "Foundations Edge";

            //Act
            $test_book->update($new_book_title);

            //Assert
            $this->assertEquals("Foundations Edge", $test_book->getBookTitle());
        }

        function testDelete()
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
            $test_book->delete();

            //Assert
            $this->assertEquals([$test_book2], Book::getAll());
        }

        function testAddAuthor()
        {
            //Arrange
            $author_name = "Super Dog";
            $id = 1;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $book_title = "Il Monstro";
            $id2 = 2;
            $test_book = new Book($book_title, $id2);
            $test_book->save();

            //Act
            $test_book->addAuthor($test_author);
            $result = $test_book->getAuthors();

            //Assert
            $this->assertEquals($result, [$test_author]);
        }

        function testGetAuthors()
        {
            //Arrange
            $book_title = "Snow Crash";
            $id = 1;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            $author_name = "Super Dog";
            $id2 = 2;
            $test_author = new Author($author_name, $id2);
            $test_author->save();

            $author_name2 = "Neal Stephenson";
            $id3 = 3;
            $test_author2 = new Author($author_name2, $id3);
            $test_author2->save();

            //Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);
            $result = $test_book->getAuthors();

            //Assert
            $this->assertEquals($result, [$test_author, $test_author2]);
        }

        function testFind()
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
            $result = Book::find($test_book->getId());
            //Assert
            $this->assertEquals($test_book, $result);
        }
        
        function test_searchTitle()
		{
			$title = "Three Blind Mice";
			$test_book = new Book($title);
			$test_book->save();
			
			$title2 = "Chicken Dog";
			$test_book2 = new Book($title2);
			$test_book2->save();
			
			$result = Book::searchTitle($test_book->getBookTitle());
			
			$this->assertEquals([$test_book], $result);
		}
    }
?>
