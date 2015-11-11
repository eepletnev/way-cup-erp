<?php 

class MenuItem {
	public $id;
	public $name;
	public $price;
	public $category;
	public $amount;
	public $unit;

	function __construct($db, $id) {
		$query = "SELECT `name`, `price`, `categoryID`, `amount`, `unit` FROM `sales_menu` WHERE `id` = $id";

		$stmt = $db->query($query);
		if (!$stmt = $db->query($query)) {
				echo '<h2>Ошибка поддключения к базе данных при запросе элемента меню!</h2>';
				die();
			} else {
			    if ($row = $stmt->fetch_assoc()) {
			    	$this->id 		= $id;
			    	$this->name 	= $row['name'];
			    	$this->price 	= $row['price'];
			    	$this->category = $row['categoryID'];
			    	$this->amount 	= $row['amount'];
			    	$this->unit 	= $row['unit'];
			    }
			}


	}
}

class IncomeCheck {
	public $id 		 	 = 0;
	public $HRID 	 	 = 0;
	public $HRString 	 = '';
	public $clientID 	 = 0;
	public $clientString = '';
	public $shopID   	 = 0;
	public $money 	 	 = 0.0;
	public $timecode 	 = "2014-12-28";

	private $db;

	function __construct() {

	}

	function queryCheck($db, $id) {
		$this->db = $db;

		$query  = "SELECT `id`, `baristaID`, `clientID`, `money`, `shopID`, `timecode` FROM `sales_check` WHERE `id` = '$id'";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных при запросе чека!</h2>';
					die();
				} else {
				    if ($row = $stmt->fetch_assoc()) {
				    		$this->id   		= $row['id'];
							$this->HRID   		= $row['baristaID'];
							$this->clientID   	= $row['clientID'];
							$this->shopID		= $row['shopID'];
							$this->money   		= $row['money'];
							$this->timecode   	= $row['timecode'];
				    }
				}


				if (!$stmt = $db->query("SELECT `name` FROM `hr_employee` WHERE `id` = $this->HRID")) {
					$this->HRString = "[Имя бариста]";
				} else {
				    if ($row = $stmt->fetch_assoc()) {
				    	$this->HRString = $row['name'];
				    }
				}

				if (!$stmt = $db->query("SELECT `name`, `lastname` FROM `crm_client` WHERE `id` = $this->clientID")) {
					$this->clientString = "[Имя клиента]";
				} else {
				    if ($row = $stmt->fetch_assoc()) {
				    	$this->clientString = $row['name'] . ' ' . $row['lastname'];
				    }
				}
	}

	function kEbenyam($db) {
		$query = "DELETE FROM 		   `sales_check`
						WHERE   `id` = '$this->id';";
		if ($db->query($query)) echo "Deleted!";
						   else echo "Something weird has happened.";
	}

	function getTime() {
		return substr($this->timecode, 10, strlen($this->timecode));
	}

	function getListOfProducts() {
		$result = array();
		$db = $this->db;

		$query = "SELECT `itemID` FROM `sales_check_item` WHERE `checkID` = $this->id";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных при запросе элемента чека!</h2>';
					die();
				} else {
				    while ($row = $stmt->fetch_assoc()) {
				    	$product = new MenuItem($db, $row['itemID']);
				    	array_push($result, $product);
				    }
				}
				if (count($result) != 0) {
					return $result;
				}
	}


	function getCups() { 
		$products = $this->getListOfProducts();
		$cups = 0;

		foreach ($products as $item) {
			if ($item->unit == 'мл') {
				$cups += 1;
			}
		}

		return $cups;
	}

	public function save($db) {

		$query = "UPDATE `sales_check` SET   `baristaID` 		= '$this->HRID',
											`clientID` 			= '$this->clientID', 
											`shopID` 		    = '$this->shopID'

									WHERE   `id` 				= '$this->id';";
		if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";
	}



}



class SalesManager {
	protected $db;

	function __construct($db) {
		$this->db = $db;
	}

	public function getChecks($date, $shop) {

		$today     = date('Ymd', strtotime('+1 days', strtotime($date)));
		$yesterday = date('Ymd', strtotime($date));


		$db = $this->db;
		$checks = array();
			$query = "SELECT `id` FROM `sales_check` WHERE (`timecode` BETWEEN '". $yesterday  . "' AND '" . $today . "') AND (`shopID` = '" . $shop . "')	";

		$stmt = $db->query($query);
			if (!$stmt = $db->query($query)) {
				echo '<h2>Ошибка поддключения к базе данных при запросе чека!</h2>';
				die();
			} else {
			    while ($row = $stmt->fetch_assoc()) {
			    	$check = new IncomeCheck();
			    	$check->queryCheck($db, $row['id']);
			    	array_push($checks, $check);
			    }
			}
		 return $checks;

	}

	public function getCupsOn($date, $shop) {		
		$db = $this->db;

		$checks = $this->getChecks($date, $shop);
		$cups = 0;

		foreach ($checks as $check) {
		 	$cups += $check->getCups();
		}

		return $cups;
	}

	public function getCheckByID($id) {
		$db = $this->db;

		$check = new IncomeCheck();
		$check->queryCheck($db, $id);

		return $check;
	}

	public function saveCheck($id, $clientid, $hrid, $shopID) {
		$db = $this->db;

		
		$check = new IncomeCheck();
		$check->queryCheck($db, $id);

		$check->clientID     = $clientid;
		$check->HRID 		 = $hrid;
		$check->shopID   	 = $shopID;

		$check->save($db);
	}

	public function deleteCheck($id) {
		$db = $this->db;

		$check = new IncomeCheck();

		$check->id = $id;
		$check->kEbenyam($db);
	}

	function getBalance($date, $shop) {
		$income = 0;
		$db = $this->db;

		$today     = date('Ymd', strtotime('+1 days', strtotime($date)));
		$yesterday = date('Ymd', strtotime($date));

			$query = "SELECT sum(`money`) FROM `sales_check` WHERE (`timecode` BETWEEN '". $yesterday  . "' AND '" . $today . "') AND (`shopID` = '" . $shop . "')	";

		$stmt = $db->query($query);
			if (!$stmt = $db->query($query)) {
				echo '<h2>Ошибка поддключения к базе данных при запросе чека!</h2>';
				die();
			} else {
			    if ($row = $stmt->fetch_assoc()) {
			    	$income = $row['sum(`money`)'];
			    }
			}
		 return $income;
	}

}

	global $mysqli;
	$manager = new SalesManager($mysqli);

