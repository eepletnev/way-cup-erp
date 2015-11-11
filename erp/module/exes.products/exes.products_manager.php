<?php

/**
*Product Category class
*/

class ProductCategory{
    public function __construct($ID = 0, $Name = '')   {
        $this->id 			= $ID;
        $this->categoryName = $Name;
    }

	public function queryCategory($db, $id) {
		$query  = "SELECT `id`, `name` FROM $this->TABLE_NAME WHERE `id` = '$id'";
		if (!$stmt = $db->query($query)) {
			echo '<h2>Ошибка поддключения к базе данных!</h2>';
			die();
		} else {
		    if ($row = $stmt->fetch_assoc()) {
		    		$this->id   		= $row['id'];
					$this->categoryName	= $row['name'];
		    }
		}
	}
	public function save($db){
				$query  = "INSERT INTO $this->TABLE_NAME (`name`
										  		  		 )
					VALUES  	  ('$this->categoryName'
								  );";
	
				if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";
	}

	public function update($db){
				$query = "UPDATE $this->TABLE_NAME SET   `name` 		       	= '$this->categoryName'

											WHERE   	  `id` 					= '$this->id';";
				if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";
	}
	public function delete($db, $id){
		$query  = "DELETE FROM $this->TABLE_NAME WHERE `id` = $id";
				if ($db->query($query)) echo "Deleted!";
						   else echo "Something weird has happened.";
		$this->id = 0;
		$this->categoryName = ''; 
	}
    public function getID()		{
    	return $this->id;
    }
    public function getName()   {
        return $this->categoryName;
    }

    public function setID($id)	{
    	$this->id = $id;
    }
    public function setName($name)	{
        $this->categoryName = $name;
    }
    private $TABLE_NAME = 'exes_product_cat';
    private $id;
    private $categoryName;
}

/**
*Product class
*/
class Product{
	public $ID   		= 0;
	public $Price       = 0;
    public $CategoryID 	= 0;
    public $OnView 		= 0;
    public $Name   		= '';
    public $Amount   	= 0;
    public $Unit   		= '';

   	private $productCategory;

    private $TABLE_NAME = 'exes_product';
	function __construct()	{
		$this->productCategory = new ProductCategory();
	}
	public function getCategoryName(){
		return $this->productCategory->getName();
	}
	public function queryProduct($db, $id) {
		$query  = "SELECT `id`, `name`, `price`, `categoryID`, `onView`, `amount`, `unit` FROM $this->TABLE_NAME WHERE `id` = '$id'";
					if (!$stmt = $db->query($query)) {
						echo '<h2>Ошибка подключения к базе данных при запросе Элементов!</h2>';
						die();
					} else {
					    if ($row = $stmt->fetch_assoc()) {
					    		$this->ID   		= $row['id'];
								$this->Name   		= $row['name'];
								$this->Price   		= $row['price'];
								$this->OnView 		= $row['onView'];
								$this->CategoryID 	= $row['categoryID'];
								$this->Amount 		= $row['amount'];
								$this->Unit 		= $row['unit'];
					    }
					}
		$this->productCategory->queryCategory($db,$this->CategoryID);
	}

	public function save($db) {
		$query  = "INSERT INTO $this->TABLE_NAME (`name`,
										   		  `price`,
										   		  `onView`,
										   		  `categoryID`,
										   		  `amount`,
										   		  `unit`
										  	)
					VALUES  	  ('$this->Name',
								   '$this->Price',
								   '$this->OnView',
								   '$this->CategoryID',
								   '$this->Amount',
								   '$this->Unit'
								  );";
	
		if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened with save product.";

	}

	public function update($db) {

		$query = "UPDATE $this->TABLE_NAME SET   `name` 		    = '$this->Name',
										  		 `price` 		    = '$this->Price',
										  		 `onView`			= '$this->OnView',
										  		 `categoryID` 		= '$this->CategoryID',
										  		 `amount`			= '$this->Amount',
										  		 `unit`				= '$this->Unit'

										WHERE 	 `id` 				= '$this->ID';";
		if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened with update product.";
	}
	public function delete($db, $id){

		$query = "UPDATE $this->TABLE_NAME SET `onView`			= false
										WHERE 	 `id` 			= '$this->ID';";
		return $db->query($query);
	}
}

/**
*  product module manager
*/

class ProductManager {
	protected $db;
	protected $TABLE_NAME_PRODUCT 	= 'exes_product';
	protected $TABLE_NAME_CATEGORY 	= 'exes_product_cat';

	function __construct($db) {
		$this->db = $db;
	}

	public function getProductsList() {
		$db = $this->db;
		$products = array();

			if (!$stmt = $db->query("SELECT `id` FROM $this->TABLE_NAME_PRODUCT ORDER BY -onView, categoryID DESC")) {
				echo '<h2>Ошибка поддключения к базе данных!</h2>';
				die();
			} else {
			    while ($row = $stmt->fetch_assoc()) {
			    	$product = new Product();
			    	$product->queryProduct($db, $row['id']);
			    	array_push($products, $product);
			    }
			}
		 return $products;
	}

	public function getCategoriesList() {
		$db = $this->db;
		$categories = array();

			if (!$stmt = $db->query("SELECT `id` FROM $this->TABLE_NAME_CATEGORY ORDER BY -id DESC")) {
				echo '<h2>Ошибка поддключения к базе данных!</h2>';
				die();
			} else {
			    while ($row = $stmt->fetch_assoc()) {
			    	$category = new ProductCategory();
			    	$category->queryCategory($db, $row['id']);
			    	array_push($categories, $category);
			    }
			}
		 return $categories;
	}


	public function getProductByID($id) {
		$db = $this->db;
		$product = new Product();
		$product->queryProduct($db, $id);
		return $product;
	}
	public function getCategoryByID($id) {
		$db = $this->db;
		$category = new ProductCategory();
		$category->queryCategory($db, $id);
		return $category;
	}
	public function saveProduct($id, $price, $name, $categoryID, $onView, $amount, $unit) {
		$db = $this->db;
	
		$newProduct = new Product();
           $newProduct->Name        = $name;
           $newProduct->Price 		= $price;
           $newProduct->OnView 	 	= $onView;
           $newProduct->CategoryID  = $categoryID;
           $newProduct->Amount 		= $amount;
           $newProduct->Unit 		= $unit;

		if (0 != $id)  {
        	$newProduct->ID    	    = $id;
        	$newProduct->update($db);            
        } else { 
			$newProduct->save($db);
        }
	}
	public function saveCategory($id, $name) {
		$db = $this->db;
	
		$newCategory = new ProductCategory();
           $newCategory->setName($name);

		if (0 != $id)  {
        	$newCategory->setID($id);
        	$newCategory->update($db);            
        } else { 
			$newCategory->save($db);
        }
	}
	public function deleteProduct($id){
		$db = $this->db;
		$deleted = new Product();
		$deleted->delete($db, $id);
	}
	public function deleteCategory($id){
		$db = $this->db;
		$deleted = new ProductCategory();
		$deleted->delete($db, $id);
	}
}

	global $mysqli;
	$manager = new ProductManager($mysqli);