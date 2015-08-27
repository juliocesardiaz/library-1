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
	
	class CopyTest extends PHPUnit_Framework_TestCase
	{
		protected function teardown()
		{
			Book::deleteAll();
			Copy::deleteAll();
		}
		
		function testGetId()
		{
			$book_title = "Dune";
			$test_book = new Book($book_title);
			$test_book->save();
			
			$test_copy = new Copy($amount = 1, $test_book->getId(), $id = 1);
			
			$result = $test_copy->getId();
			
			$this->assertEquals(1, $result);
		}	
		
		function testGetAmount()
		{
			$book_title = "Dune";
			$test_book = new Book($book_title);
			$test_book->save();
			
			$amount = 1;
			$book_id = $test_book->getId();
			$test_copy = new Copy($amount, $book_id);
			$test_copy->save();
			
			$result = $test_copy->getAmount();
			
			$this->assertEquals(1, $result);
		}	
		
		function testSave()
		{
			$book_title = "Dune";
			$id = null;
			$test_book = new Book($book_title, $id);
			$test_book->save();
			
			$amount = 1;
			$book_id = $test_book->getId();
			$test_copy = new Copy($amount, $book_id);
			$test_copy->save();
			
			$result = Copy::getAll();
			
			$this->assertEquals([$test_copy], $result);
		}
		
		function testAddCopy()
		{
			$book_title = "Three Blind Mice";
			$test_book = new Book($book_title);
			$test_book->save();
			
			$test_copy = new Copy($amount = 1, $test_book->getId());
			$test_copy->save();
			
			$title2 = "Chicken Dog";
			$test_book2 = new Book($title2);
			$test_book2->save();
			
			$test_copy->addCopies(1);
			
			$result = $test_copy->getAmount();
			
			$this->assertEquals(2, $result);
		}
		
		function testGetAll()
		{
			$book_title = "Three Blind Mice";
			$id = null;
			$test_book = new Book($book_title, $id);
			$test_book->save();
			
			
			$test_copy = new Copy($amount = 1, $test_book->getId());
			$test_copy->save();
			
			$result = Copy::getAll();
			
			$this->assertEquals([$test_copy], $result);
		}
		
		function testUpdate()
		{
			$book_title = "Snow Crash";
            $id = null;
            $test_book = new Book($book_title, $id);
            $test_book->save();
			
			$test_copy = new Copy($amount = 1, $test_book->getId());
			$test_copy->save();
			
			$new_amount = $amount + 1;
			
			$test_copy->update($new_amount);
			
			$this->assertEquals(2, $test_copy->getAmount());
		}
		
		function testFind()
		{
			$book_title = "Snow Crash";
            $id = null;
			$amount = 1;
            $test_book = new Book($book_title, $id);
            $test_book->save();
			
			$book_title2  = "Dune";
            $id2 = null;
			$amount2 = 2;
            $test_book2 = new Book($book_title2, $id2);
            $test_book2->save();
			
			$test_copy = new Copy($amount, $test_book->getId());
			$test_copy->save();
			$test_copy2 = new Copy($amount2, $test_book2->getId());
			$test_copy2->save();
		
			$result = Copy::find($test_copy->getId());
			
			$this->assertEquals($test_copy, $result);
		}
		
		function testFindBook()
		{
			$book_title = "Snow Crash";
            $id = null;
			$amount = 1;
            $test_book = new Book($book_title, $id);
            $test_book->save();
			
			$book_title2  = "Dune";
            $id2 = null;
			$amount2 = 2;
            $test_book2 = new Book($book_title2, $id2);
            $test_book2->save();
			
			$result = Book::find($test_book->getId());
			
			$this->assertEquals($test_book, $result);
		}	
	}
?>