<?php 

class GuestMonitor {
	
	function __construct() {

	}

	function getAverageClientLife($db){
		$query = "SELECT `id`, `registred` FROM `crm_client` WHERE (`name` <> '') OR (`lastname` <> '') OR (`telephone` <> '0')";
		$everyoneslife = array();
		if (!$stmt = $db->query($query)) {
			echo '<h2>Ошибка поддключения к базе данных!</h2>';
			die();
		} else {
		    while ($row = $stmt->fetch_assoc()) {
		    	$id = $row['id'];
		    	$query = "SELECT `timecode` FROM `sales_check` WHERE `clientID` = $id ORDER BY `id` DESC LIMIT 1";
				
				if (!$nthrstmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных!</h2>';
					die();
				} else {
				    if ($lastvisit = $nthrstmt->fetch_assoc()) {
				    	$life = date_diff(date_create($row['registred']), date_create($lastvisit['timecode']));
				    	if ($life) {
				    		array_push($everyoneslife, $life->days);
				    	}
				    }
				}

		    }
		}
		return array_sum($everyoneslife) / count($everyoneslife);
	}

	function getLoyalityStat($db, $clientid) {
    	$query = "SELECT count(`id`) AS `visits` FROM `sales_check` WHERE `clientID` = $clientid";
		
		if (!$nthrstmt = $db->query($query)) {
			echo '<h2>Ошибка поддключения к базе данных!</h2>';
			die();
		} else {
		    if ($visits = $nthrstmt->fetch_assoc()) {
		    	if (0 == $visits['visits']) {
		    		return 'none';
		    	}
		    	if (3 >= $visits['visits']) {
		    		return 'low';
		    	}
		    	if (15 > $visits['visits']) {
		    		return 'huge';
		    	}
		    	if (3 < $visits['visits']) {
		    		return 'average';
		    	}

		    }
		}
	}



	function getMonthlyInflow($db){
		$result = array();
		$query = "SELECT COUNT( MONTH(  `registred` ) ) AS  `new_clients` , MONTHNAME(  `registred` ) AS  `date` 
				FROM  `crm_client` 
				GROUP BY MONTH(  `registred` ) 
				ORDER BY  `crm_client`.`registred` ASC";

		if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных!</h2>';
					die();
				} else {
				    while ($row = $stmt->fetch_assoc()) {
				    	array_push($result, array("month" => $row['date'], "clients" => $row['new_clients']));
				    }
				}

		return $result;	
	}

	function getGuestRatio($db) {
		$result = array();
		$registred    = 0;
		$notregistred = 0;
		$loyalityLevel['low'] 		  = 0;
		$loyalityLevel['average'] 	  = 0;
		$loyalityLevel['huge'] 		  = 0;
		$loyalityLevel['none'] 		  = 0;

		for ($month = 1; $month < 13 ; $month++) { 
			$query = "SELECT `clientID` FROM `sales_check` WHERE month(`timecode`) = " . $month;

			if (!$stmt = $db->query($query)) {
				echo "huita";
				die();
			} else {
				while ($row = $stmt->fetch_assoc()) {
					if ($row['clientID'] != 0) {
						$registred++;
						$loyalityLevel[$this->getLoyalityStat($db, $row['clientID'])]++;
					} else {
						$notregistred++;
					}
				}
			}
		$result[$month] = array("registred" => $registred, "not" => $notregistred, 'loyalityLevel' => $loyalityLevel);
		}

		return $result;		
	}
}


if (!class_exists('Item')) {
	SysApplication::callManager('menu');
}

class IncomeCheck {
	public $id 		 	 	= 0;
	public $HRID 	 	 	= 0;
	public $HRString 		= '';
	public $clientID 		= 0;
	public $clientString 	= '';
	public $clientTel		= 0;
	public $shopID   	 	= 0;
	public $money 	 	 	= 0;
	public $timecode 	    = "2014-12-28";
	public $listOfProducts  = array();

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

				if (!$stmt = $db->query("SELECT `name`, `lastname`, `telephone` FROM `crm_client` WHERE `id` = $this->clientID")) {
					$this->clientString = "[Имя клиента]";
				} else {
				    if ($row = $stmt->fetch_assoc()) { 
				    	$this->clientString = $row['name'] . ' ' . $row['lastname'];
				    	$this->clientTel 	= $row['telephone'];
				    }
				}

				$this->getListOfProducts();
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
		$this->listOfProducts = array();
		$db = $this->db;
		$result = array();
		$free = array();

		$query = "SELECT `itemID`, `actionID` FROM `sales_check_item` WHERE `checkID` = $this->id";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка поддключения к базе данных при запросе элемента чека!</h2>';
					die();
				} else {
				     while ($row = $stmt->fetch_assoc()) {
				     	if (1 == $row['actionID']) {
					     	array_push($free, $row['itemID']);
				     	} else {
							array_push($result, $row['itemID']);
				    	}
				    }

				}
					$repeats = array_count_values($result);
					$result = array_unique($result);

					foreach ($result as $productID) {
						$item = new Item();
						$item->queryItem($db, $productID);
						$occurences = $repeats[$productID];
						array_push($this->listOfProducts, array("occurences" => $occurences, "item" => $item));
					}

					$repeats = array_count_values($free);
					$result = array_unique($free);

					foreach ($result as $productID) {
						$item = new Item();
						$item->queryItem($db, $productID);
						$item->Name  = 'Беспл. ' . $item->Name;
						$item->Price = 0;	 

						$occurences = $repeats[$productID];

						array_push($this->listOfProducts, array("occurences" => $occurences, "item" => $item));
					}
	}

	function getCups() { 
		$this->getListOfProducts();
		$cups = 0;

		foreach ($this->listOfProducts as $item) {

			if ($item['item']->Units == 'мл') {
				$cups += $item['occurences'];
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

	public function getChecks($date, $shop, $HRID = null) {

		$today     = date('Ymd', strtotime('+1 days', strtotime($date)));
		$yesterday = date('Ymd', strtotime($date));


		$db = $this->db;
		$checks = array();
			$query = "SELECT `id` FROM `sales_check` WHERE (`timecode` BETWEEN '". $yesterday  . "' AND '" . $today . "') AND (`shopID` = '" . $shop . "')";

			if ($HRID != null) { $query .= " AND (`baristaID` = $HRID)"; }

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

	public function getBalance($date, $shop) {
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

