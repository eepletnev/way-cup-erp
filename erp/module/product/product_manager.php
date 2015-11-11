<?php
if (!class_exists('Product')) {
	SysApplication::callManager('exes.check');
}

/**
*Item Category class
*/

class ItemCategory{
    public function __construct($ID = 0, $Name = '', $Bonus = 0)   {
        $this->id 			= $ID;
        $this->categoryName = $Name;
        $this->bonus 		= $Bonus;
    }

	public function queryCategory($db, $id) {
				$query  = "SELECT `id`, name, bonus FROM $this->TABLE_NAME WHERE `id` = '$id'";
					if (!$stmt = $db->query($query)) {
						echo '<h2>Ошибка поддключения к базе данных!</h2>';
						die();
					} else {
					    if ($row = $stmt->fetch_assoc()) {
					    		$this->id   		= $row['id'];
								$this->bonus  		= $row['bonus'];
								$this->categoryName	= $row['name'];
					    }
					}

	}
	public function save($db){
				$query  = "INSERT INTO $this->TABLE_NAME (`name`,
										   		   		  `bonus`
										  		  		 )
					VALUES  	  ('$this->categoryName',
								   '$this->bonus'
								  );";
	
				if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";
	}

	public function update($db){
				$query = "UPDATE $this->TABLE_NAME SET   `name` 		       	= '$this->categoryName',
												  		 `bonus` 		    	= '$this->bonus'

											WHERE   	  `id` 					= '$this->id';";
				if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";
	}

    public function getID()		{
    	return $this->id;
    }
    public function getName()   {
        return $this->categoryName;
    }
    public function getBonus()	{
    	return $this->bonus;
    }
    public function setID($id)	{
    	$this->id = $id;
    }
    public function setName($name)	{
        $this->categoryName = $name;
    }
    public function setBonus($bonus)	{
    	$this->bonus = $bonus;
    }
    private $TABLE_NAME = 'wcc_menu_cat';
    private $id;
    private $categoryName;
    private $bonus;
}

/**
* Item class
*/

class Item
{
	public $ID   		= 0;
	public $Price       = 0;
    public $CategoryID 	= 0;
    public $Amount		= 0;
    public $Name   		= '';
    public $Units 		= '';

   private $itemCategory;

    private $TABLE_NAME = 'wcc_menu';
	function __construct()	{
		$this->itemCategory = new ItemCategory();
	}
	public function getCategoryName(){
		return $this->itemCategory->getName();
	}
	public function queryItem($db, $id) {
		$query  = "SELECT `id`, `name`, `price`, `categoryID`, `unit` , `amount` FROM $this->TABLE_NAME WHERE `id` = '$id'";
					if (!$stmt = $db->query($query)) {
						echo '<h2>Ошибка подключения к базе данных при запросе Элементов!</h2>';
						die();
					} else {
					    if ($row = $stmt->fetch_assoc()) {
					    		$this->ID   		= $row['id'];
								$this->Name   		= $row['name'];
								$this->Units 		= $row['unit'];		
								$this->Price   		= $row['price'];
								$this->Amount 		= $row['amount'];
								$this->CategoryID 	= $row['categoryID'];
					    }
					}
		$this->itemCategory->queryCategory($db,$this->CategoryID);
	}

	public function save($db) {
		$query  = "INSERT INTO $this->TABLE_NAME (`name`,
												  `unit`,
										   		  `price`,
										   		  `amount`
										   		  `categoryID`
										  	)
					VALUES  	  ('$this->Name',
								   '$this->Units',
								   '$this->Price',
								   '$this->Amount',
								   '$this->CategoryID'
								  );";
	
		if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";

	}

	public function update($db) {
		$query = "UPDATE $this->TABLE_NAME SET   `name` 		    = '$this->Name',
												 `unit`				= '$this->Units',
										  		 `price` 		    = '$this->Price',
										  		 `amount`			= '$this->Amount',
										  		 `categoryID` 		= '$this->CategoryID'

										WHERE 	 `id` 				= '$this->ID';";

		if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";
	}
}


/**
*  menu module manager
*/

class MenuManager {
	protected $db;
	protected $TABLE_NAME_MENU = 'wcc_menu';
	protected $TABLE_NAME_CATEGORY = 'wcc_menu_cat';

	function __construct($db) {
		$this->db = $db;
	}

	public function getItemsList() {
		$db = $this->db;
		$items = array();

			if (!$stmt = $db->query("SELECT `id` FROM $this->TABLE_NAME_MENU ORDER BY -id DESC")) {
				echo '<h2>Ошибка поддключения к базе данных!</h2>';
				die();
			} else {
			    while ($row = $stmt->fetch_assoc()) {
			    	$item = new Item();
			    	$item->queryItem($db, $row['id']);
			    	array_push($items, $item);
			    }
			}
		 return $items;
	}

	public function getCategoriesList() {
		$db = $this->db;
		$categories = array();

			if (!$stmt = $db->query("SELECT `id` FROM $this->TABLE_NAME_CATEGORY ORDER BY -id DESC")) {
				echo '<h2>Ошибка поддключения к базе данных!</h2>';
				die();
			} else {
			    while ($row = $stmt->fetch_assoc()) {
			    	$item = new ItemCategory();
			    	$item->queryCategory($db, $row['id']);
			    	array_push($categories, $category);
			    }
			}
		 return $categories;
	}


	public function getItemByID($id) {
		$db = $this->db;
		$item = new Item();
		$item->queryItem($db, $id);
		return $item;
	}

	public function saveItem($id, $price, $name, $categoryID, $units, $amount) {
		$db = $this->db;
	
		$newItem = new Item();
           $newItem->Name        = $name;
           $newItem->Price 		 = $price;
           $newItem->Units 		 = $units;
           $newItem->Amount 	 = $amount;
           $newItem->CategoryID  = $categoryID;

		if (0 != $id)  {
        	$newItem->ID 		 = $id;
        	$newItem->update($db);            
        } else { 
			$newItem->save($db);
        }
	}
}

	global $mysqli;
	$manager = new MenuManager($mysqli);

