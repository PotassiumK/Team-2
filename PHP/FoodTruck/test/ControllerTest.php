<?php
require_once __DIR__.'/../controller/Controller.php';
require_once __DIR__.'/../persistence/PersistenceFoodTruck.php';
require_once __DIR__.'/../model/FTMS.php';
require_once __DIR__.'/../model/Equipment.php';
require_once __DIR__.'/../model/Supply.php';
require_once __DIR__.'/../model/TimeBlock.php';
require_once __DIR__.'/../model/Staff.php';
require_once __DIR__.'/../model/MenuItem.php';
require_once __DIR__.'/../model/Order.php';


class ControllerTest extends PHPUnit_Framework_TestCase
{
	protected $c;
	protected $pm;
	protected $ftms;
	
	protected function setUp()
	{
		//wipe out all previou data for clean test
		$this->c = new Controller();
		$this->pm = new PersistenceFoodTruck();
		$this->ftms = $this->pm->loadDataFromStore();
		$this->ftms->delete();
		$this->pm->writeDataToStore($this->ftms);
	}
	
	protected function tearDown()
	{
	}
	//**** Test for CreateEquipment()
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
		$this->assertEquals($name, $this->ftms->getEquipment_index(0)->getName());
		$this->assertEquals($quantity, $this->ftms->getEquipment_index(0)->getQuantity());
		//helper method: check that every model is null (exceptions) in file
		$this->checkForNull(array(0));
		
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
		//helper method: check that every model is null in file
		$this->checkForNull(array());
		
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
		//helper method: check that every model is null in file
		$this->checkForNull(array());
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
		//helper method: check that every model is null in file
		$this->checkForNull(array());
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
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	public function testCreateEquipmentTooLong() {
		$this->assertEquals(0, count($this->ftms->getEquipment()));
	
		$name = "veryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryverylonglonglonglonglonglonglongstringstringstringstring";
		$quantity = "12345678910";
		$error = "";
		try {
			$this->c->createEquipment($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Equipment name cannot be longer than 50 characters! @2Equipment quantity cannot have more than 9 digits!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	
	//**** Test for CreateSupply()
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
		$this->assertEquals($name, $this->ftms->getSupply_index(0)->getName());
		$this->assertEquals($quantity, $this->ftms->getSupply_index(0)->getQuantity());
		//helper method: check that every model is null (exceptions) in file
		$this->checkForNull(array(1));
	
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
		//helper method: check that every model is null in file
		$this->checkForNull(array());
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
		//helper method: check that every model is null in file
		$this->checkForNull(array());
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
		//helper method: check that every model is null in file
		$this->checkForNull(array());
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
		//helper method: check that every model is null in persistence
		$this->checkForNull(array());
	}
	public function testCreateSupplyTooLong() {
		$this->assertEquals(0, count($this->ftms->getSupplies()));
	
		$name = "veryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryverylonglonglonglonglonglonglongstringstringstringstring";
		$quantity = "12345678910";
		$error = "";
		try {
			$this->c->createSupply($name,$quantity);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Supply name cannot be longer than 50 characters! @2Supply quantity cannot have more than 9 digits!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	//** Test for CreateTimeblock()
	public function testCreateTimeBlock() {
		$this->assertEquals(0, count($this->ftms->getTimeBlocks()));
		$this->assertEquals(0, count($this->ftms->getStaffs()));
		
		//first create staff to add timeblock
		$nameS = "Jenny";
		$roleS = "Cook";
		
		try {
			$this->c->createStaff($nameS,$roleS);
		} catch (Exception $e) {
			// check that no error occurred
			$this->fail();
		}
		
		$day = "Monday";
		$starttime = "09:00";
		$endtime = "10:30";
		 
		try {
			$this->c->createTimeBlock($starttime, $endtime, $day,$nameS);
		} catch (Exception $e) {
			// check that no error occurred
			$this->fail();
		}
		 
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals($day, $this->ftms->getTimeBlock_index(0)->getDayOfWeek());
		$this->assertEquals($starttime, $this->ftms->getTimeBlock_index(0)->getStartTime());
		$this->assertEquals($endtime, $this->ftms->getTimeBlock_index(0)->getEndTime());
		$this->assertEquals($this->ftms->getTimeBlock_index(0), $this->ftms->getStaff_index(0)->getTimeBlock_index(0));
		//helper method: check that every model is null (exceptions) in file
		$this->checkForNull(array(2,3));
	}
	
	public function testCreateTimeBlockNull() {
		$this->assertEquals(0, count($this->ftms->getTimeBlocks()));
	
		$day = null;
		$starttime = null;
		$endtime = null;
		$staffname = null;
	
		$error = "";
		try {
			$this->c->createTimeBlock($starttime, $endtime, $day, $staffname);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Time block day of the week cannot be empty! @2Time block start time must be specified correctly (HH:MM)! @3Time block end time must be specified correctly (HH:MM)! @4Staff not found!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
		
	}
	
	public function testCreateTimeBlockEmpty() {
			$this->assertEquals(0, count($this->ftms->getTimeBlocks()));
	
		$day = "";
		$starttime = "";
		$endtime = "";
		$staffname = "";
	
		$error = "";
		try {
			$this->c->createTimeBlock($starttime, $endtime, $day, $staffname);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Time block day of the week cannot be empty! @2Time block start time must be specified correctly (HH:MM)! @3Time block end time must be specified correctly (HH:MM)! @4Staff not found!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	public function testCreateTimeBlockEndTimeBeforeStartTime() {
		$this->assertEquals(0, count($this->ftms->getTimeBlocks()));
		
		//first create staff to add timeblock
		$nameS = "Jenny";
		$roleS = "Cook";
		
		try {
			$this->c->createStaff($nameS,$roleS);
		} catch (Exception $e) {
			// check that no error occurred
			$this->fail();
		}
		
		$day = "Monday";
		$starttime = "09:00";
		$endtime = "08:59";
	
		$error = "";
		try {
			$this->c->createTimeBlock($starttime, $endtime,$day,$nameS);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@3Time block end time cannot be before Time block start time!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array(3));
	}
	//** test for CreateStaff()
	public function testCreateStaff() {
		$this->assertEquals(0, count($this->ftms->getStaffs()));
	
		$name = "Jenny";
		$role = "Cook";
	
		try {
			$this->c->createStaff($name,$role);
		} catch (Exception $e) {
			// check that no error occurred
			$this->fail();
		}
	
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals($name, $this->ftms->getStaff_index(0)->getName());
		$this->assertEquals($role, $this->ftms->getStaff_index(0)->getRole());
		//helper method: check that every model is null (exceptions) in file
		$this->checkForNull(array(3));
	}
	public function testCreateStaffNull() {
		$this->assertEquals(0, count($this->ftms->getStaffs()));
	
		$name = null;
		$role = null;
		$error = "";
		try {
			$this->c->createStaff($name,$role);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Staff name cannot be empty! @2Staff role cannot be empty!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	public function testCreateStaffEmpty() {
		$this->assertEquals(0, count($this->ftms->getStaffs()));
	
		$name = "";
		$role ="";
		$error = "";
		try {
			$this->c->createStaff($name,$role);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Staff name cannot be empty! @2Staff role cannot be empty!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	public function testCreateStaffTooLong() {
		$this->assertEquals(0, count($this->ftms->getStaffs()));
	
		$name = "veryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryverylonglonglonglonglonglonglongstringstringstringstring";
		$role = "veryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryverylonglonglonglonglonglonglongstringstringstringstring";
		$error = "";
		try {
			$this->c->createStaff($name,$role);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Staff name cannot be longer than 50 characters! @2Staff role cannot be longer than 50 characters!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	//**** Test for CreateMenuItem()
	public function testCreateMenuItem() {
		$this->assertEquals(0, count($this->ftms->getMenuItems()));
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		
		//first createa supply to link to menu item
		$nameS = "Broth";
		$quantityS = 4;
		try {
			$this->c->createSupply($nameS,$quantityS);
		} catch (Exception $e) {
			$this->fail();
		}
		//create menu item to test
		$name = "Soup";
		$supplies = array($nameS);
		try {
			$this->c->createMenuItem($name,$supplies);
		} catch (Exception $e) {
			// check that no error occurred
			$this->fail();
		}
	
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals($nameS, $this->ftms->getSupply_index(0)->getName());
		$this->assertEquals($quantityS, $this->ftms->getSupply_index(0)->getQuantity());
		$this->assertEquals($name, $this->ftms->getMenuItem_index(0)->getName());
		$this->assertEquals($this->ftms->getSupply_index(0), $this->ftms->getMenuItem_index(0)->getSupply_index(0));
		//helper method: check that every model is null (exceptions) in file
		$this->checkForNull(array(1,4));
	}
 	public function testCreateMenuItemNull() {
		$this->assertEquals(0, count($this->ftms->getMenuItems()));
		$this->assertEquals(0, count($this->ftms->getSupplies()));
		
		$name = null;
		$supplies = array(null);
		$error = "";
		try {
			$this->c->createMenuItem($name,$supplies);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Menu item name cannot be empty! @2Menu item ingredient not found!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
 	}
	public function testCreateMenuItemSupplyDoNotExist() {
		$this->assertEquals(0, count($this->ftms->getMenuItems()));
		$this->assertEquals(0, count($this->ftms->getSupplies()));
	
		$nameS = "Banana";
		$quantityS = 4;
		try {
			$this->c->createSupply($nameS,$quantityS);
		} catch (Exception $e) {
			$this->fail();
		}
	
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals(1, count($this->ftms->getSupplies()));
		$supply = $this->ftms->getSupply_index(0);
		$this->ftms->delete();
		$this->pm->writeDataToStore($this->ftms);
		
		$name = "Pasta";
		$supplies = array($supply->getName());
		try {
			$this->c->createMenuItem($name,$supplies);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
		 
		// check error
		$this->assertEquals("@2Menu item ingredient not found!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	public function testCreateMenuItemTooLong() {
		$this->assertEquals(0, count($this->ftms->getMenuItems()));
	
		$nameS = "Banana";
		$quantityS = 4;
		try {
			$this->c->createSupply($nameS,$quantityS);
		} catch (Exception $e) {
			$this->fail();
		}
		
		$name = "veryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryveryverylonglonglonglonglonglonglongstringstringstringstring";
		$error = "";
		$supplies = array($nameS);
		try {
			$this->c->createMenuItem($name,$supplies);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("@1Menu item name cannot be longer than 50 characters!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array(1));
	}
	//*** Test for CreateOder()
	public function testCreateOrder() {
		$this->assertEquals(0, count($this->ftms->getOrders()));
		$this->assertEquals(0, count($this->ftms->getMenuItems()));
	
		//first create supply & menu item to link to order
		$nameS = "Banana";
		$quantityS = 4;
		try {
			$this->c->createSupply($nameS,$quantityS);
		} catch (Exception $e) {
			$this->fail();
		}
		
		$nameM = "Salad";
		$supplyM = array($nameS);
		try {
			$this->c->createMenuItem($nameM,$supplyM);
		} catch (Exception $e) {
			$this->fail();
		}
		//create order to test
		$menuItem = array("Salad");
		try {
			$this->c->createOrder($menuItem);
		} catch (Exception $e) {
			// check that no error occurred
			$this->fail();
		}
	
		// check file contents
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals($nameM, $this->ftms->getMenuItem_index(0)->getName());
		$this->assertEquals(1, $this->ftms->getMenuItem_index(0)->getPopularity());
		$this->assertEquals(3, $this->ftms->getMenuItem_index(0)->getSupply_index(0)->getQuantity());
		$this->assertEquals($this->ftms->getMenuItem_index(0), $this->ftms->getOrder_index(0)->getMenuItem_index(0));
		//helper method: check that every model is null (exceptions) in file
		$this->checkForNull(array(1,4,5));
	}
	public function testCreateOrderNull() {
		$this->assertEquals(0, count($this->ftms->getOrders()));
		$this->assertEquals(0, count($this->ftms->getMenuItems()));
	
		$menuItem = array(null);
		$error = "";
		try {
			$this->c->createOrder($menuItem);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	
		// check error
		$this->assertEquals("Order Menu item not found!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
		
	}
	public function testCreateOrderMenuItemDoNotExist() {
		$this->assertEquals(0, count($this->ftms->getMenuItems()));
		$this->assertEquals(0, count($this->ftms->getSupplies()));
	
		//first create supply & menu item to link to order
		$nameS = "Banana";
		$quantityS = 4;
		try {
			$this->c->createSupply($nameS,$quantityS);
		} catch (Exception $e) {
			$this->fail();
		}
		
		$nameM = "salad";
		$supplyM = array($nameS);
		try {
			$this->c->createMenuItem($nameM,$supplyM);
		} catch (Exception $e) {
			$this->fail();
		}
	
		$this->ftms = $this->pm->loadDataFromStore();
		$this->assertEquals(1, count($this->ftms->getMenuItems()));
		$menuitem = $this->ftms->getMenuItem_index(0);
		$this->ftms->delete();
		$this->pm->writeDataToStore($this->ftms);
	
		$menuItems = array($menuitem->getName());
		try {
			$this->c->createOrder($menuItems);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
			
		// check error
		$this->assertEquals("Order Menu item not found!", $error);
		//helper method: check that every model is null in file
		$this->checkForNull(array());
	}
	private function checkForNull($exceptions){
		$count = array(0,0,0,0,0,0);
		$this->ftms = $this->pm->loadDataFromStore();
		if($exceptions!=NULL){
			foreach ($exceptions as $index){
				$count[$index] = 1;
			}
		}
		$this->assertEquals($count[0], count($this->ftms->getEquipment()));
		$this->assertEquals($count[1], count($this->ftms->getSupplies()));
		$this->assertEquals($count[2], count($this->ftms->getTimeBlocks()));
		$this->assertEquals($count[3], count($this->ftms->getStaffs()));
		$this->assertEquals($count[4], count($this->ftms->getMenuItems()));
		$this->assertEquals($count[5], count($this->ftms->getOrders()));	
	}
		
}

