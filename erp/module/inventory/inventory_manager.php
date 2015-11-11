<?php
/**
*  Inventory module manager
*/
require_once 'Resource.php';
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
}
	global $mysqli;
	$manager = new InventoryManager($mysqli);

