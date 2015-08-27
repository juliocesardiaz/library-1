<?php 
	
	class Checkout
	{
		private $patron_id;
		private $copy_id;
		private $due_date;
		private $checkout_status;
		private $id;
		
		function __construct($patron_id, $copy_id, $due_date, $checkout_status, $id = null)
		{
			$this->patron_id = $patron_id;
			$this->copy_id = $copy_id;
			$this->due_date = $due_date;
			$this->checkout_status = $checkout_status;
			$this->id = $id;
		}
		
		function setPatronId($new_patron_id)
		{
			$this->patron_id = $new_patron_id;
		}
		
		function getPatronId()
		{
			return $this->patron_id;
		}
		
		function setCopyId($new_copy_id)
		{
			$this->copy_id = $new_copy_id;
		}
		
		function getCopyId()
		{
			return $this->copy_id;
		}
		
		function setDueDate($new_due_date)
		{
			$this->due_date = $new_due_date;
		}
		
		function getDueDate()
		{
			return $this->due_date;
		}
		
		function setCheckOutStatus($new_checkout_status)
		{
			$this->checkout_status = $new_checkout_status;
		}
		
		function getCheckOutStatus()
		{
			return $this->checkout_status;
		}
		
		function setId($new_id)
		{
			$this->id = $new_id;
		}
		
		function getId()
		{
			return $this->id;
		}
		
		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id, due_date, checkout_status) VALUES ({$this->getPatronId()}, {$this->getCopyId()}, '{$this->getDueDate()}', {$this->getCheckOutStatus()});");
			$this->setId($GLOBALS['DB']->lastInsertId());
		}
		
		static function getAll()
		{
			$returnedcheckouts = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
			$checkouts = array();
			foreach($returnedcheckouts as $checkout) {
				$checkout_patron_id = $checkout['patron_id'];
				$checkout_copy_id = $checkout['copy_id'];
				$checkout_due_date = $checkout['due_date'];
				$checkout_checkout_status = $checkout['checkout_status'];
				$checkout_id = $checkout['id'];
				$new_checkout = new Checkout($checkout_patron_id, $checkout_copy_id, $checkout_due_date, $checkout_checkout_status, $checkout_id);
				array_push($checkouts, $new_checkout);
			} 
			return $checkouts;
		}
		
		function updateCheckoutStatus($new_status)
		{
			$GLOBALS['DB']->exec("UPDATE checkouts SET checkout_status = {$new_status} WHERE id = {$this->getId()};");
			$this->setCheckOutStatus($new_status);
		}
		
		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM checkouts;");
		}
	}
?>
