<?php


class Transaction {
	public $id;
	public $kindID;
	public $kindString;
	public $comment;
	public $cash;
	public $timestamp;

	function __construct($id, $kindID, $kindString, $comment, $cash, $timestamp) {
		$this->id         = $id;
		$this->comment    = $comment;
		$this->cash 	  = $cash;
		$this->timestamp  = $timestamp;
		$this->kindID     = $kindID;
		$this->kindString = $kindString;
	}


}


/**
*  Finance module manager
*/

class FinanceManager {
	protected $db;
	protected $cashbox = array();
	protected $salesManager;
	protected $exesManager;
	protected $shopID;

	function __construct($db) {
		$this->db 	        = $db;
		$this->salesManager = SysApplication::callManager('sales', "SalesManager");
		$this->exesManager  = SysApplication::callManager('exes.check', 'ExesCheckManager');
	}

	public function setShopID($shopID) {
		$this->shopID = $shopID;
	}

	public function getDailyStat($date = null) {
		$shop = $this->shopID;
		$in  = $this->getIncomeTransaction($date);
		$out = $this->getOutcomeTransaction($date);
		return array("income" => $in, "outcome" => $out);
	}

	private function getIncomeTransaction($date = null) {
		$shop = $this->shopID;
		if ($date == null) { $date = date("Y-m-d"); }
		$dailyChecks = $this->salesManager->getChecks($date, $shop);
		$cash = 0;

		foreach ($dailyChecks as $check) {
			$cash += $check->money;
		}

		$transaction = new Transaction(0, 1, '', '', $cash, $date);

		return $transaction;
	}

	private function getOutcomeTransaction($date = null) {
		$shop = $this->shopID;
		if ($date == null) { $date = date("Y-m-d"); }
		$dailyChecks = $this->exesManager->getChecks($date, $shop);
		$cash = 0;

		foreach ($dailyChecks as $check) {
			$cash += $check->money;
		}

		$transaction = new Transaction(0, 2, '', '', $cash, $date);

		return $transaction;
	}

	public function getMonthTransactions($date = null) {
		$shop = $this->shopID;
		$db = $this->db;

		// ПОЧИНИТЬ НАСТРОИТЬ ЁБА


		// if ($date == null) { 
		// 	$month = mktime(0, 0, 0, date("m"), 1,   date("Y"));
		// } else {
		// 	$month = date("m", strtotime($date));
		// 	$month = mktime(0, 0, 0, $month, 1,   date("Y"));
		// }
		

	//	$nextMonth     	= date('Ymd', strtotime('+1 month', $month));
	//	$thisMonth		= date('Ymd', $month);


		// $query = "SELECT `id`, `kindID`, `comment`, `cash`, `timestamp` FROM `finance_transaction`  
		// 		  WHERE (`timestamp` BETWEEN '". $thisMonth  . "' AND '" . $nextMonth . "') 
		// 		  AND (`shopID` = '$shop')";

		$query = "SELECT `id`, `kindID`, `comment`, `cash`, `timestamp` FROM `finance_transaction`  
				  WHERE (`shopID` = '$shop') ORDER BY `id` DESC";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка при запросе транзакций!</h2>';
					die();
				} else {
					$transactions = array();
				    while ($row = $stmt->fetch_assoc()) {
				    	array_push($transactions, 
				    		new Transaction($row['id'], 
				    						$row['kindID'],
				    						$this->getTransactionKindName($row['kindID']),
				    						$row['comment'],
				    						$row['cash'],
				    						$row['timestamp']));
				    }
				    return $transactions;
				}
	}

	protected function getTransactionKindName($id) {
		$db = $this->db;
		$query = "SELECT `name` FROM `finance_transaction_kind` WHERE `id` = $id";

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка при запросе категории транзакции!</h2>';
					die();
				} else {
				    if ($row = $stmt->fetch_assoc()) {
				   		return $row['name'];
				    }
				}
	}


	public function countUp() {
		$shop = $this->shopID;
		$db = $this->db;
		$query = "SELECT sum(`cash`) FROM `finance_transaction` WHERE (`shopID` = '$shop')";
		$currentSession = $this->getDailyStat();
		$currentMoney   = $currentSession["income"]->cash - $currentSession["outcome"]->cash;

				if (!$stmt = $db->query($query)) {
					echo '<h2>Ошибка при запросе кассы!</h2>';
					die();
				} else {
				    if ($row = $stmt->fetch_assoc()) {
				   		return $row['sum(`cash`)'] + $currentMoney;
				    }
				}
	}

	public function save($transaction) {
		$db = $this->db;
		$query  = "INSERT INTO `finance_transaction` (`kindID`,
													  `comment`,
													  `cash`,
													  `shopID`
								  		  		 )
			VALUES  	  ('$transaction->kindID',
						   '$transaction->comment',
						   '$transaction->cash',
						   '$this->shopID'
						  );";

		if ($db->query($query)) echo "Успешно!";
				   else echo "Something weird has happened!";
	}

	public function kEbenyam($id) {
		$db = $this->db;
		$query  = "DELETE FROM `finance_transaction`
					WHERE `id` = '$id';";


		if ($db->query($query)) echo "Успешнено!";
				   else echo "Something weird has happened!";
	}
}


global $mysqli;
$manager = new FinanceManager($mysqli);