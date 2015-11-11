<?php

// Object of this class is supposed to be set on the application provided with the database. 

class WCCManager {
	protected $listOfShops;
	protected $db;
	protected $user;
	protected $currentShop;

	function __construct($db, $user) {
		$this->db = $db;
		$this->user = $user;
		$this->listOfShops = $this->getShops();
		$this->setCurrentShop($_SESSION['shop_id']);
		
	}

	public function getShops() {
		$mysqli = $this->db;
		$shops = array();
		$query  = "SELECT `id`, `name` FROM `wcc_shop`";
            if (!$stmt = $mysqli->query($query)) {
            	return false;
            } else {
                while ($row = $stmt->fetch_assoc()) {
                  array_push($shops, array("id" => $row['id'], "name" => $row['name']));
                }
            }
        return $shops;
	}

	public function getListOfShops() {
		return $this->listOfShops;
	}


	public function getCurrentShop() {
		return $this->currentShop;
	}

	public function setCurrentShop($shop) {
		$this->currentShop = $shop;
	}

	public function getShopName($id = null) {
		// returns current shop's name in case id's not passed.

		$mysqli = $this->db;
		if (!isset($id)) {
			$id = $this->getCurrentShop();
		}
			$query  = "SELECT `name` FROM `wcc_shop` WHERE `id` = '$id'";
			
			if (!$stmt = $mysqli->query($query)) {
				return false;
			} else { 
				$res = $stmt->fetch_row();
				return $res[0];
			}
	}

	public function postHandler($post) {
		// change to a function. I'm guessing there's a function for that already.

		foreach ($post as $name => $value) {
			switch ($name) {
				case 'change_shop_to':
					$this->currentShop = $value;
					$_SESSION['shop_id'] =  $this->getCurrentShop();
					break;
				
				default:

					break;
			}
		}
	}
}