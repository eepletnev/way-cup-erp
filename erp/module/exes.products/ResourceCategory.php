<?php

/**
*Resource Category class
*/

class ResourceCategory{

	public function __construct($id = 0, $name = ''){

	}
	public function queryResourceCategory($db, $id){
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
						   VALUES  	  					 ('$this->categoryName'
								  						 );";
	
				if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";
	}

	public function update($db){
				$query = "UPDATE $this->TABLE_NAME SET   `name`	= '$this->categoryName'

											WHERE   	  `id`  = '$this->id';";
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

	public function getID(){
		return $this->id;
	}
	public function setID($id){
		$this->id = $id;
	}
	public function getName(){
		return $this->name;
	}
	public function setName($name){
		$this->name = $name;
	}
	private $TABLE_NAME = 'inventory_resource_cat';
	private $id = 0;
	private $name = '';
}
