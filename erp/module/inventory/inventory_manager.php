<?php
/**
*  Inventory module manager
*/
require_once 'Resource.php';

class Record {
	public $id 		 	   = 0;
	public $HRID 	 	   = 0;
	public $HRString 	   = '';
	public $kindID 		   = 1;
	public $kind 		   = 'Списание';
	public $shopID   	   = 0;
	public $timecode 	   = "2014-12-28";
	public $listOfResources = array();

	function __construct() {
		
	}

	public function queryRecord($db, $id) {
		$query  = "SELECT `id`, `HRID`, `shopID`, `kindID`, `timecode`  FROM `inventory_history` WHERE `id` = '$id'";
		if (!$stmt = $db->query($query)) {
			echo '<h2>Ошибка подключения к базе данных!</h2>';
			die();
		} else {
			if ($row = $stmt->fetch_assoc()) {
				$this->id 			= $row['id'];
				$this->HRID 		= $row['HRID'];
				$this->shopID 		= $row['shopID'];
				$this->timecode 	= $row['timecode'];
				$this->kindID 		= $row['kindID'];
				$this->kind 		= (1 == $row['kindID']) ? 'Пополнение' : ((2 == $row['kindID']) ? 'Списание' : 'День');
			}
 		}

		$this->listOfResources = $this->getListOfResources($db);

		if (!$stmt = $db->query("SELECT `name` FROM `hr_employee` WHERE `id` = $this->HRID")) {
			$this->HRString = "[Имя бариста]";
		} else {
		    if ($row = $stmt->fetch_assoc()) {
		    	$this->HRString = $row['name'];
		    }
		}


	}

	protected function getListOfResources($db) {
		$result = array();

		$query = "SELECT `resourceID` FROM `inventory_history_resource` WHERE `historyID` = $this->id";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных при запросе элемента чека!</h2>';
					die();
				} else {
				    while ($row = $stmt->fetch_assoc()) {
				    	$resource = new Resource();
				    	$resource->queryResource($db, $row['resourceID']);
				    	array_push($result, $resource);
				    }
				}
				if (count($result) != 0) {
					return $result;
				}
	}

	public function save($db) {
		$query = "INSERT INTO `inventory_history` (`HRID`, `shopID`, `kindID`) VALUES ($this->HRID, $this->shopID, $this->kindID)";
		$db->query($query);
		$id = $db->insert_id;

		foreach ($this->listOfResources as $res) {
			$query = "INSERT INTO `inventory_history_resource` (`historyID`, `resourceID`, `quantity`) VALUES ($id, $res->ID, $res->Amount)";
			$db->query($query);
		}
	}

}

class InventoryManager {
	protected $db;
	protected $TABLE_NAME_RESOURCE 				= 'inventory_resource';
	protected $TABLE_NAME_RESOURCE_CATEGORY 	= 'inventory_resource_cat';
	function __construct($db) {
		$this->db = $db;
	}

	public function getInventoryList($shopID) {
		$db = $this->db;


		$resources = array();
		$query = "SELECT `id` FROM $this->TABLE_NAME_RESOURCE WHERE `shopID` = $shopID ORDER BY -id DESC";
		if (!$stmt = $db->query($query)) {
			echo '<h2>Ошибка подключения к базе данных!</h2>';
			die();
		} else {
		    while ($row = $stmt->fetch_assoc()) {
		    	$resource = new Resource();
		    	$resource->queryResource($db, $row['id']);
		    	array_push($resources, $resource);
		    }
		}
		return $resources;
	}

	public function getInventoryHistory($shopID, $date = null) {
		$db = $this->db;

		$records = array();
		$query = "SELECT `id` FROM `inventory_history` WHERE `shopID` = $shopID ORDER BY id DESC";
		if (!$stmt = $db->query($query)) {
			echo '<h2>Ошибка подключения к базе данных!</h2>';
			die();
		} else { 
			while ($row = $stmt->fetch_assoc()) {
				$record = new Record();
				$record->queryRecord($db, $row['id']);
				array_push($records, $record);
			}
		}
		return $records;
	}

	public function getRecordByID($id) {
		$db = $this->db;
		$record = new Record();
		$record->queryRecord($db, $id);
		return $record;
	}

	public function getResourceByID($id) {
		$db = $this->db;
		$resource = new Resource();
		$resource->queryResource($db, $id);
		return $resource;
	}

	public function getResourceByExesID($exesID, $shop) {
		$list = $this->getInventoryList($shop);
		foreach ($list as $resource) {
			if ($resource->getProductID() == $exesID) {
				return $this->getResourceByID($resource->getID());
			}
		}
		return false;

	}

	public function getCategoryByID($id) {
		$db = $this->db;
		$category = new ProductCategory();
		$category->queryCategory($db, $id);
		return $category;
	}
	public function saveResource($id, $exesID, $quantity, $categoryID) {
		$db = $this->db;
		$newResource = new Resource();
		$newResource = $this->getResourceByID($id);
		$newResource->setExesID($exesID);
        $newResource->setQuantity($quantity);
        $newResource->setCategoryID($categoryID);
		if (0 != $id)  {
        	$newResource->setID($id);
        	$newResource->update($db);            
        } else { 
			$newResource->save($db);
        }
	}
	public function saveResourceCategory($id, $name) {
		$db = $this->db;
		$newResourceCategory = new ResourceCategory();
        $newResourceCategory->setName($name);
		if (0 != $id)  {
        	$newResourceCategory->setID($id);
        	$newResourceCategory->update($db);            
        } else { 
			$newResourceCategory->save($db);
        }
	}
	public function deleteResource($id){
		$db = $this->db;
		$deleted = new Resource();
		$deleted = $this->getResourceByID($id);
		if (!$deleted->delete($db, $id)) {
			echo "Случилась хуйня при попытке удаления.";
		}
	}
	public function deleteResourceCategory($id){
		$db = $this->db;
		$deleted = new ResourceCategory();
		$deleted->delete($db, $id);
	}
	public function writeOff($listOfProducts, $shop) {	
		if ($listOfProducts != null) {
			foreach ($listOfProducts as $productToWriteOff) {
				$stockItem = $this->getResourceByExesID($productToWriteOff->ID, $shop);

				if ($stockItem != null) {
					$stockItem->setQuantity($stockItem->getQuantity() - $productToWriteOff->Amount);
					if ($stockItem->getQuantity() <= 0) {
						$this->deleteResource($stockItem->getID());
					} else {
						$this->saveResource($stockItem->getID(), $stockItem->getExesID(), $stockItem->getQuantity(), $stockItem->getCategoryID());
					}
				} else {
					echo "Не смог найти " . $productToWriteOff->Amount . $productToWriteOff->Unit . " " . $productToWriteOff->Name . " на складе!<br>";
				}
			}
		}
	}

	public function saveRecord($listOfResources, $shop, $HRID, $kindID) {
		$db = $this->db;
		$record = new Record();
		$record->listOfResources = $listOfResources;
		$record->shopID			= $shop;
		$record->HRID 			= $HRID;
		$record->kindID 		= $kindID;

		$record->save($db);
	}

	public function saveShiftProducts($date, $shop, $HRID) {
		$salesMan = SysApplication::callManager('sales', 'SalesManager');
		$products = $salesMan->getListOfShiftProducts($date, $shop, $HRID);
		$this->saveRecord($products, $shop, $HRID, 3);
		$this->writeOff($products, $shop);
	} 
}
	global $mysqli;
	$manager = new InventoryManager($mysqli);

