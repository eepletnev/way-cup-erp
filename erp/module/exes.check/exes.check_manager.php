<?php 

require_once 'OutcomeCheck.php';

class ExesCheckManager {
		protected $db;
		protected $stockman;

		function __construct($db) {
			$this->db = $db;
			$this->stockman = SysApplication::callManager('inventory', 'InventoryManager');
			// $this->stockman    = new InventoryManager($db);

			// ДОРАБОТАТЬ ПИДОР МЕТОДА!!!!!!! АППЛИКЕЙШН!!!!!
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
