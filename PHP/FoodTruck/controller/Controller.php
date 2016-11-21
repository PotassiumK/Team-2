<?php
require_once __DIR__.'/InputValidator.php';
require_once __DIR__.'/../persistence/PersistenceFoodTruck.php';
require_once __DIR__.'/../model/Equipment.php';
require_once __DIR__.'/../model/FTMS.php';

class Controller{

	public function __construct(){

	}

	public function createEquipment($equipment_name, $equipment_quantity){
		//1. Validate input
		$error = "";
		$name = InputValidator::validate_input($equipment_name);
		$quantity = InputValidator::validate_input($equipment_quantity);
		$isInt = preg_match('/^[0-9]+$/',$quantity);
		if ($name!=null && strlen($name)!=0 && $quantity!=null && strlen($quantity)!=0 && $isInt){
			//2. load all of the data
			$pm = new PersistenceFoodTruck();
			$rm = $pm->loadDataFromStore();
		
			//3. Add the new Equipment
			$equipment = new Equipment($name,intval($quantity));
			$rm->addEquipment($equipment);
		
			//4. Write all of the data
			$pm->writeDataToStore($rm);
		}
		else {
			if ($name == null || strlen($name)==0) {
				$error .= "@1Equipment name cannot be empty! ";
			}
			if ($quantity == null || strlen($quantity) ==0) {
				$error .= "@2Equipment quantity cannot be empty! ";
			}
			else if (!$isInt) {
				$error .= "@2Equipment quantity must be a positive integer! ";
			}
			throw new Exception(trim($error));
		} 
	}
	
	public function createSupply($supply_name, $supply_quantity){
		//1. Validate input
		$error = "";
		$name = InputValidator::validate_input($supply_name);
		$quantity = InputValidator::validate_input($supply_quantity);
		$isInt = preg_match('/^[0-9]+$/',$quantity);
		if ($name!=null && strlen($name)!=0 && $quantity!=null && strlen($quantity)!=0 && $isInt){
			//2. load all of the data
			$pm = new PersistenceFoodTruck();
			$rm = $pm->loadDataFromStore();
	
			//3. Add the new Equipment
			$supply = new Supply($name,intval($quantity));
			$rm->addSupply($supply);
	
			//4. Write all of the data
			$pm->writeDataToStore($rm);
		}
		else {
			if ($name == null || strlen($name)==0) {
				$error .= "@1Supply name cannot be empty! ";
			}
			if ($quantity == null || strlen($quantity) ==0) {
				$error .= "@2Supply quantity cannot be empty! ";
			}
			else if (!$isInt) {
				$error .= "@2Supply quantity must be a positive integer! ";
			}
			throw new Exception(trim($error));
		}
	}
	
	
}
