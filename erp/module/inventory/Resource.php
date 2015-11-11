<?php 
/**
*Resource class
*/

require_once 'ResourceCategory.php';
SysApplication::callManager('exes.products');
class Resource{
	function __construct()	{
		$this->resourceCategory = new ResourceCategory();
		$this->product = new Product();
	}

	public function getID(){
		return $this->id;
	}
	public function getCategoryID(){
		return $this->categoryID;
	}
	public function getQuantity(){
		return $this->quantity;
	}
	public function getExesID(){
		return $this->exesID;
	}
	public function getShopID(){
		return $this->shopID;
	}
	public function setID($id){
		$this->id = $id;
	}
	public function setCategoryID($categoryID){
		$this->categoryID = $categoryID;
	}
	public function setQuantity($quantity){
		$this->quantity = $quantity;
	}
	public function setExesID($exesID){
		$this->exesID = $exesID;
	}
	public function setShopID($id){
		$this->shopID = $id;
	}
	public function getCategoryName(){
		return $this->resourceCategory->getName();
	}
	public function getProductName(){
		return $this->product->Name;
	}
	public function getProductUnit(){
		return $this->product->Unit;
	}
	public function getProductID() {
		return $this->product->ID;
	}
	public function queryResource($db, $id) {
		$query  = "SELECT `id`, `quantity`, `exesID`, `shopID`, `categoryID`  FROM $this->TABLE_NAME WHERE `id` = '$id'";
		if (!$stmt = $db->query($query)) {
			echo '<h2>Ошибка подключения к базе данных при запросе(class Resource)!</h2>';
			die();
		} else {
			if ($row = $stmt->fetch_assoc()) {
				$this->id   		= $row['id'];
				$this->exesID 		= $row['exesID'];
				$this->shopID 		= $row['shopID'];
				$this->quantity  	= $row['quantity'];
				$this->categoryID 	= $row['categoryID'];
			}
			$this->resourceCategory->queryResourceCategory($db,$this->categoryID);
			$this->product->queryProduct($db,$this->exesID);
		}
	}

	public function save($db) {
		$query  = "INSERT INTO $this->TABLE_NAME (`exesID`,
												  `shopID`,
												  `quantity`,
										   		  `categoryID`
										  	)
					VALUES  	  ('$this->exesID',
								   '$this->shopID',
								   '$this->quantity',
								   '$this->categoryID'
								  );";
	
		return $db->query($query);
	}
	public function update($db) {
		$query = "UPDATE $this->TABLE_NAME SET   `exesID` 		    = '$this->exesID',
												 `shopID`			= '$this->shopID',
										  		 `quantity` 		= '$this->quantity',
										  		 `categoryID` 		= '$this->categoryID'

										WHERE 	 `id` 				= '$this->id';";

		return $db->query($query);
	}

	public function delete($db) {
		$query = "DELETE FROM $this->TABLE_NAME WHERE `id` = '$this->id'";

		return $db->query($query);
	} 

	private $id 		= 0;
	private $exesID 	= 0;
	private $quantity 	= 0;
	private $categoryID = 0;
	private $shopID 	= 0;
   	private $resourceCategory;
   	private $product;
    private $TABLE_NAME = 'inventory_resource';
}