<?php 

class OutcomeCheck {
	public $id 		 	 = 0;
	public $HRID 	 	 = 0;
	public $HRString 	 = '';
	public $shopID   	 = 0;
	public $money		 = 0;
	public $timecode 	 = "2014-12-28";

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
				    	$product = new Product();
				    	$product->queryProduct($db, $row['itemID']);
				    	array_push($result, $product);
				    }
				}
				if (count($result) != 0) {
					return $result;
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


class ExesCheckManager {
	protected $db;
	protected $stockman;

	function __construct($db) {
		$this->db = $db;
		$this->stockman = SysApplication::callManager('inventory');
	}

	public function getChecks($date, $shop) {

		$today     = date('Ymd', strtotime('+1 days', strtotime($date)));
		$yesterday = date('Ymd', strtotime($date));


		$db = $this->db;
		$checks = array();
			$query = "SELECT `id` FROM `exes_check` WHERE (`timecode` BETWEEN '". $yesterday  . "' AND '" . $today . "') AND (`shopID` = '" . $shop . "')	";

		$stmt = $db->query($query);
			if (!$stmt = $db->query($query)) {
				echo '<h2>Ошибка поддключения к базе данных при запросе чека!</h2>';
				die();
			} else {
			    while ($row = $stmt->fetch_assoc()) {
			    	$check = new OutcomeCheck();
			    	$check->queryCheck($db, $row['id']);
			    	array_push($checks, $check);
			    }
			}
		 return $checks;

	}


	public function getCheckByID($id) {
		$db = $this->db;

		$check = new OutcomeCheck();
		$check->queryCheck($db, $id);

		return $check;
	}

	public function saveCheck($id, $hrid, $shopID) {
		$db = $this->db;

		
		$check = new OutcomeCheck();
		$check->queryCheck($db, $id);

		$check->HRID 		 = $hrid;
		$check->shopID   	 = $shopID;

		$check->save($db);
	}

	public function deleteCheck($id) {
		$db = $this->db;

		$check = new OutcomeCheck();
		$check->queryCheck($db, $id);
		$check->kEbenyam($db, $this->stockman);
	}

	public function getListOfProductsForCheck($check) {
		$db = $this->db;
		return $check->getListOfProducts($db);
	}

}

	global $mysqli;
	$manager = new ExesCheckManager($mysqli);

