<?php
require_once __DIR__.'/../controller/Controller.php';
require_once __DIR__.'/../persistence/PersistenceFoodTruck.php';
require_once __DIR__.'/../model/FTMS.php';
require_once __DIR__.'/../model/Equipment.php';
require_once __DIR__.'/../model/Supply.php';


class ControllerTest extends PHPUnit_Framework_TestCase
{
	protected $c;
	protected $pm;
	protected $ftms;
	
	protected function setUp()
	{
		$this->c = new Controller();
		$this->pm = new PersistenceFoodTruck();
		$this->ftms = $this->pm->loadDataFromStore();
		$this->ftms->delete();
		$this->pm->writeDataToStore($this->ftms);
	}
	
	protected function tearDown()
	{
	}
	
	public function testCreateEquipment() {
		$this->assertEquals(0, count($this->ftms->getEquipment()));
	
		$name = "Knife";
		$quantity = "3";
	
		try {
			$this->c->createEquipment($name,$quantity);
		} catch (Exception $e) {
			// check that no error occurred
			$this->fail();
		}
	
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals(1, count($this->ftms->getEquipment()));
		$this->assertEquals($name, $this->ftms->getEquipment_index(0)->getName());
		$this->assertEquals($quantity, $this->ftms->getEquipment_index(0)->getQuantity());
		
		$this->assertEquals(0, count($this->ftms->getSupplies()));
// 		$this->assertEquals(0, count($this->ftms->getEvents()));
// 		$this->assertEquals(0, count($this->ftms->getRegistrations()));
	}
	public function testCreateEquipmentNull() {
		$this->assertEquals(0, count($this->ftms->getEquipment()));
	
		$name = null;
		$quantity = null;
		$error = "";
		try {
			$this->c->createEquipment($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Equipment name cannot be empty! @2Equipment quantity cannot be empty!", $error);
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		$this->assertEquals(0, count($this->ftms->getSupplies()));
// 		$this->assertEquals(0, count($this->rm->getEvents()));
// 		$this->assertEquals(0, count($this->rm->getRegistrations()));
	}
	public function testCreateEquipmentEmpty() {
		$this->assertEquals(0, count($this->ftms->getEquipment()));
	
		$name = "";
		$quantity ="";
		$error = "";
		try {
			$this->c->createEquipment($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Equipment name cannot be empty! @2Equipment quantity cannot be empty!", $error);
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		// 		$this->assertEquals(0, count($this->rm->getEvents()));
		// 		$this->assertEquals(0, count($this->rm->getRegistrations()));
	}
	
	public function testCreateEquipmentQuantityNotInt() {
		$this->assertEquals(0, count($this->ftms->getEquipment()));
	
		$name = "Pan";
		$quantity = "hello";
		$error = "";
		try {
			$this->c->createEquipment($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@2Equipment quantity must be a positive integer!", $error);
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
	
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		// 		$this->assertEquals(0, count($this->rm->getEvents()));
		// 		$this->assertEquals(0, count($this->rm->getRegistrations()));
	}
	
	public function testCreateEquipmentQuantityNegative() {
		$this->assertEquals(0, count($this->ftms->getEquipment()));
	
		$name = "Pan";
		$quantity = -4;
		$error = "";
		try {
			$this->c->createEquipment($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@2Equipment quantity must be a positive integer!", $error);
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
	
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		// 		$this->assertEquals(0, count($this->rm->getEvents()));
		// 		$this->assertEquals(0, count($this->rm->getRegistrations()));
	}
	//**
	public function testCreateSupply() {
		$this->assertEquals(0, count($this->ftms->getSupplies()));
	
		$name = "Cucumber";
		$quantity = "3";
	
		try {
			$this->c->createSupply($name,$quantity);
		} catch (Exception $e) {
			// check that no error occurred
			$this->fail();
		}
	
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals(1, count($this->ftms->getSupplies()));
		$this->assertEquals($name, $this->ftms->getSupply_index(0)->getName());
		$this->assertEquals($quantity, $this->ftms->getSupply_index(0)->getQuantity());
		
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		// 		$this->assertEquals(0, count($this->ftms->getEvents()));
		// 		$this->assertEquals(0, count($this->ftms->getRegistrations()));
	}
	public function testCreateSupplyNull() {
		$this->assertEquals(0, count($this->ftms->getSupplies()));
	
		$name = null;
		$quantity = null;
		$error = "";
		try {
			$this->c->createSupply($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Supply name cannot be empty! @2Supply quantity cannot be empty!", $error);
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
	
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		// 		$this->assertEquals(0, count($this->rm->getEvents()));
		// 		$this->assertEquals(0, count($this->rm->getRegistrations()));
	}
	public function testCreateSupplyEmpty() {
		$this->assertEquals(0, count($this->ftms->getSupplies()));
	
		$name = "";
		$quantity ="";
		$error = "";
		try {
			$this->c->createSupply($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Supply name cannot be empty! @2Supply quantity cannot be empty!", $error);
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		// 		$this->assertEquals(0, count($this->rm->getEvents()));
		// 		$this->assertEquals(0, count($this->rm->getRegistrations()));
	}
	
	public function testCreateSupplyQuantityNotInt() {
		$this->assertEquals(0, count($this->ftms->getSupplies()));
	
		$name = "Cucumber";
		$quantity = "hello";
		$error = "";
		try {
			$this->c->createSupply($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@2Supply quantity must be a positive integer!", $error);
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
	
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		// 		$this->assertEquals(0, count($this->rm->getEvents()));
		// 		$this->assertEquals(0, count($this->rm->getRegistrations()));
	}
	
	public function testCreateSupplyQuantityNegative() {
		$this->assertEquals(0, count($this->ftms->getSupplies()));
	
		$name = "Cucumber";
		$quantity = -4;
		$error = "";
		try {	
			$this->c->createSupply($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@2Supply quantity must be a positive integer!", $error);
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
	
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		$this->assertEquals(0, count($this->ftms->getEquipment()));
		// 		$this->assertEquals(0, count($this->rm->getEvents()));
		// 		$this->assertEquals(0, count($this->rm->getRegistrations()));
	}
	
}

