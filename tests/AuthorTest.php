<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        // default delete function
        protected function tearDown()
        {
            Author::deleteAll();
        }

        function testSetAuthorName()
        {
            //Arrange
            $author_name = "Neal Stephenson";
            $test_author = new Author($author_name);

            //Act
            $test_author->setAuthorName("Frank Herbert");
            $result = $test_author->getAuthorName();

            //Assert
            $this->assertEquals("Frank Herbert", $result);
        }

        function testGetAuthorName()
        {
            //Arrange
            $author_name = "Neal Stephenson";
            $test_author = new Author($author_name);

            //Act
            $result = $test_author->getAuthorName();

            //Assert
            $this->assertEquals($author_name, $result);
        }

        function testGetId()
        {
            //Arrange
            $id = 1;
            $author_name = "Frank Herbert";
            $test_author = new Author($author_name, $id);

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            //Arrange
            $author_name = "Frank Herbert";
            $id = null;
            $test_author = new Author($author_name, $id);

            //Act
            $test_author->save();

            //Assert
            $result = Author::getAll();
            $this->assertEquals($test_author, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $author_name = "Frank Herbert";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $author_name2 = "Neal Stephenson";
            $id2 = null;
            $test_author2 = new Author($author_name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testAddBook()
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
            $test_author->addBook($test_book);
            $result = $test_author->getBooks();

            //Assert
            $this->assertEquals($result, [$test_book]);
        }

        function testGetBooks()
        {
            //Arrange
            $author_name = "Super Dog";
            $id2 = 2;
            $test_author = new Author($author_name, $id2);
            $test_author->save();


            $book_title = "Snow Crash";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();

            $book_title2 = "Ready Player One";
            $id2 = null;
            $test_book2 = new Book($book_title2, $id2);
            $test_book2->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);
            $result = $test_author->getBooks();

            //Assert
            $this->assertEquals($result, [$test_book, $test_book2]);
        }

        function testDelete()
        {
            //Arrange
            $author_name = "Frank Herbert";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $author_name2 = "Neal Stephenson";
            $id2 = null;
            $test_author2 = new Author($author_name2, $id2);
            $test_author2->save();

            //Act
            $test_author->delete();

            //Assert
            $this->assertEquals([$test_author2], Author::getAll());
        }

        function testFind()
        {
            //Arrange
            $author_name = "Frank Herbert";
            $id = null;
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $author_name2 = "Neal Stephenson";
            $id2 = null;
            $test_author2 = new Author($author_name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author->getId());
            //Assert
            $this->assertEquals($test_author, $result);
        }
        
        function test_searchAuthor()
		{
			$name = "Jerry Garcia";
			$test_author = new Author($name);
			$test_author->save();
			
			$name2 = "Frank Sinatra";
			$test_author2 = new Author($name2);
			$test_author2->save();
			
			$result = Author::searchAuthor($test_author->getAuthorName());
			
			$this->assertEquals($test_author, $result);
		}

    }
?>
