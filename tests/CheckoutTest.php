<?php 
	
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/
	
	require_once "src/Checkout.php";
	require_once "src/Patron.php";
	require_once "src/Copy.php";
	
	$server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
	
	class CheckoutTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Checkout::deleteAll();
			Patron::deleteAll();
			Copy::deleteAll();
		}
		
		function testGetPatronId()
		{
			$patron_name = "Eduardo";
			$patron_id = 1;
			$test_patron = new Patron($patron_name, $patron_id);
			$test_patron->save();
			
			$copy_id = 1;
			$due_date = "2015-01-01";
			$checkout_status = false;
			$test_checkout = new Checkout($patron_id, $copy_id, $due_date, $checkout_status);
			
			$result = $test_checkout->getPatronId();
			
			$this->assertEquals(1, $result);
		}
		
		function testGetCopyId()
		{
			$id = 1;
			$copy_id = 1;
			$patron_id = 1;
			$checkout_status = false;
			$due_date = "2015-01-01";
			$test_checkout = new Checkout($patron_id, $copy_id, $due_date, $checkout_status);
			
			$result = $test_checkout->getCopyId();
			
			$this->assertEquals(1, $result);
		}
		
		function testGetDueDate()
		{
			$id = 1;
			$copy_id = 1;
			$patron_id = 1;
			$checkout_status = false;
			$due_date = "2015-01-01";
			$test_checkout = new Checkout($patron_id, $copy_id, $due_date, $checkout_status);
			
			$result = $test_checkout->getDueDate();
			
			$this->assertEquals($due_date, $result);
		}
		
		function testGetCheckOutStatus()
		{
			$id = 1;
			$copy_id = 1;
			$patron_id = 1;
			$checkout_status = false;
			$due_date = "2015-01-01";
			$test_checkout = new Checkout($patron_id, $copy_id, $due_date, $checkout_status);
			
			$result = $test_checkout->getCheckOutStatus();
			
			$this->assertEquals($checkout_status, $result);
		}
		
		function testGetId()
		{
			$id = 1;
			$copy_id = 1;
			$patron_id = 1;
			$checkout_status = false;
			$due_date = "2015-01-01";
			$test_checkout = new Checkout($patron_id, $copy_id, $due_date, $checkout_status, $id);
			
			$result = $test_checkout->getId();
			
			$this->assertEquals(1, $result);
		}
		
		function testSave()
		{
			$patron_id = 1;
			$copy_id = 2;
			$due_date = "2015-12-12";
			$checkout_status = 1;
			$test_checkout = new Checkout($patron_id, $copy_id, $due_date, $checkout_status);
			
			$test_checkout->save();
			$result = Checkout::getAll();
			
			$this->assertEquals([$test_checkout], $result);
		}
		
		
		function testGetAll()
		{
			$id = 1;
			$copy_id = 1;
			$patron_id = 1;
			$checkout_status = 0;
			$due_date = "2015-01-01";
			$test_checkout = new Checkout($patron_id, $copy_id, $due_date, $checkout_status, $id);
			$test_checkout->save();
			
			$id2 = 2;
			$copy_id2 = 2;
			$patron_id2 = 2;
			$checkout_status2 = 1;
			$due_date2 = "2015-02-02";
			$test_checkout2 = new Checkout($copy_id2, $patron_id2, $due_date2, $checkout_status2, $id2);
			$test_checkout2->save();
			
			$result = Checkout::getAll();
			
			$this->assertEquals([$test_checkout, $test_checkout2], $result);
		}
		
		function testUpdateCheckOutStatus()
		{
			$copy_id = 1;
			$patron_id = 1;
			$checkout_status = 0;
			$due_date = "2015-01-01";
			$test_checkout = new Checkout($patron_id, $copy_id, $due_date, $checkout_status);
			$test_checkout->save();
			
			$test_checkout->updateCheckOutStatus(1);
			
			$result = $test_checkout->getCheckOutStatus();
			
			$this->assertEquals(1, $result);
		}
	}
?>