<?php 

class OutcomeCheck {
	public $id 		 	 	= 0;
	public $HRID 	 	 	= 0;
	public $HRString 	 	= '';
	public $shopID   	 	= 0;
	public $money		    = 0;
	public $timecode 	 	= "2014-12-28";
	public $listOfProducts  = array();
// вот этого не должно быть.
	private $db;


	function __construct() {
		
	}

	function queryCheck($db, $id) {
		$this->db = $db;
		$query  = "SELECT `id`, `employeeID`, `shopID`, `timecode` FROM `exes_check` WHERE `id` = '$id'";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных при запросе чека!</h2>';
					die();
				} else {
				    if ($row = $stmt->fetch_assoc()) {
				    		$this->id   		= $row['id'];
							$this->HRID   		= $row['employeeID'];
							$this->shopID   	= $row['shopID'];
							$this->timecode   	= $row['timecode'];
							$this->money 		= $this->countUp($db);
				    }
				}

				if (!$stmt = $db->query("SELECT `name` FROM `hr_employee` WHERE `id` = $this->HRID")) {
					$this->HRString = "[Имя бариста]";
				} else {
				    if ($row = $stmt->fetch_assoc()) {
				    	$this->HRString = $row['name'];
				    }
				}
				$this->getListOfProducts($db);
	}


	function getTime() {
		return substr($this->timecode, 10, strlen($this->timecode));
	}

	function countUp($db) {
		$checkIDs = array();
		$query  = "SELECT `itemID` FROM `exes_check_item` WHERE `checkID` = '$this->id'";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных при запросе элементов чека!</h2>';
					die();
				} else {
				    while ($row = $stmt->fetch_assoc()) {
				    	array_push($checkIDs, $row['itemID']);
				    }
				}
		$summ = 0;

	if (count($checkIDs) != 0) {
			
			foreach ($checkIDs as $id) {
				$query  = "SELECT `price` FROM `exes_product` WHERE `id` = $id;";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных при запросе стоимости продуктов!</h2>';
					die();
				} else {
 					if ($row = $stmt->fetch_assoc()) {
				    	$summ += $row['price'];
				    } else {
				    	$summ += 0;
				    }
				}

			}
	
		}
	return $summ;
	}


	function getListOfProducts($db) {
		$result = array();

		$query = "SELECT `itemID` FROM `exes_check_item` WHERE `checkID` = $this->id";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных при запросе элемента чека!</h2>';
					die();
				} else {
				    while ($row = $stmt->fetch_assoc()) {
				    	array_push($result, $row['itemID']);
				    }

				}
					$repeats = array_count_values($result);
					$result = array_unique($result);

					foreach ($result as $productID) {
						$item = new Product();
						$item->queryProduct($db, $productID);
						$occurences = $repeats[$productID];

						array_push($this->listOfProducts, array("occurences" => $occurences, "item" => $item));
					}
	}

	function kEbenyam($db, $stockman) {
		$stockman->writeOff($this->getListOfProducts($db), $this->shopID);

		$query = "DELETE FROM 		   `exes_check`
						WHERE   `id` = '$this->id';";
		if ($db->query($query)) echo "Deleted!";
						   else echo "Something weird has happened.";
				

		$query = "DELETE FROM 			`exes_check_item`
						WHERE 	`checkID` = $this->id";

		if (!$db->query($query)) echo " Почти.";
	}

	public function save($db) {

		$query = "UPDATE `exes_check` SET   `employeeID` 		= '$this->HRID',
											`shopID` 		    = '$this->shopID'

									WHERE   `id` 				= '$this->id';";
		if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened." . $query;
	}

}

