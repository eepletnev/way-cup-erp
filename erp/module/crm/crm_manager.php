<?php

/**
* client class
*/
class Client
{
	public $id   		= 0;
	public $coffees   	= 0;
	public $freeCups   	= 0;
	public $name   		= '';
	public $middlename   = '';
	public $lastname     = '';
	public $telephone    = '';
	public $email   		= '';
	public $registred    = '';
	public $comment 		= '';

	function __construct()	{

	}

	protected function formatPhone($phone) {
			if (strlen($phone) == 11) {
				$phone = substr_replace($phone, '(', 1, 0);
				$phone = substr_replace($phone, ')', 5, 0);
				$phone = substr_replace($phone, '-', 9, 0);
				$phone = substr_replace($phone, '-', 12, 0);
			} else {
				$phone = '-/-';
			}
			return $phone;
	}

	public function queryClient($db, $id) {
		$query  = "SELECT `id`, `name`, `middlename`, `lastname`, `telephone`, email, coffees, freeCups, registred, comment FROM `crm_client` WHERE `id` = '$id'";
					if (!$stmt = $db->query($query)) {
						echo '<h2>Ошибка поддключения к базе данных!</h2>';
						die();
					} else {
					    if ($row = $stmt->fetch_assoc()) {
					    		$this->id   		= $row['id'];
								$this->coffees   	= $row['coffees'];
								$this->freeCups   	= $row['freeCups'];
								$this->name   		= $row['name'];
								$this->middlename   = $row['middlename'];
								$this->lastname     = $row['lastname'];
								$this->telephone    = $row['telephone'];
								$this->email   		= $row['email'];
								$this->registred    = $row['registred'];
								$this->comment 		= $row['comment'];
					    }
					}

	}

	public function getVisits($db, $id) {
			// $query = "SELECT `id` FROM `sales_check` WHERE `clientid` = '$this->id'";
			// 			if (!$stmt = $db->query($query)) {
			// 				echo '<h2>Ошибка поддключения к базе данных!</h2>';
			// 				die();
			// 			} else {
			// 			    if ($row = $stmt->fetch_assoc()) {
			// 			    	array_push($this->visits, $row['id']);
			// 			    }
			// 			}

			$salesManager = SYSApplication::callManager('sales');

			// $this->visits = salesManager->getClientVisits($this->id);
	}

	public function save($db) {
		$date = date('Y-m-d');
		$query  = "INSERT INTO `crm_client` (`name`,
											`coffees`,
											`freeCups`,
											`middlename`,
											`lastname`,
											`telephone`,
											`email`,
											`registred`,
											`comment`)
					VALUES  	  ('$this->name',
								  '$this->coffees',
								  '$this->freeCups',
							      '$this->middlename',
							      '$this->lastname',
							      '$this->telephone',
							      '$this->email',
							      '$date',
							      '$this->comment');";
	
		if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";

	}

	public function update($db) {
		$date = date('Y-m-d');
		$query = "UPDATE `crm_client` SET   `name` 		       	= '$this->name',
											`coffees` 		    = '$this->coffees',
											`freeCups` 		    = '$this->freeCups',
											`middlename`	    = '$this->middlename',
											`lastname` 			= '$this->lastname',
											`telephone` 		= '$this->telephone',
											`email` 			= '$this->email',
											`registred` 		= '$date',
											`comment` 			= '$this->comment'

									WHERE   `id` 				= '$this->id';";
		if ($db->query($query)) echo "Saved!";
						   else echo "Something weird has happened.";
	}

}


/**
*  crm module manager
*/

class CRMManager {
	protected $db;

	function __construct($db) {
		$this->db = $db;
	}

	public function getList($sort = 'default', $limit = 10) {
		$db = $this->db;
		$clients = array();
		if (is_numeric($limit)) {
			$query = "SELECT `id` FROM `crm_client` ORDER BY -coffees, -id DESC LIMIT $limit";
		} else {
			$query = "SELECT `id` FROM `crm_client` ORDER BY -coffees, -id DESC";
		}

		$stmt = $db->query($query);
			if (!$stmt = $db->query($query)) {
				echo '<h2>Ошибка поддключения к базе данных!</h2>';
				die();
			} else {
			    while ($row = $stmt->fetch_assoc()) {
			    	$client = new Client();
			    	$client->queryClient($db, $row['id']);
			    	array_push($clients, $client);
			    }
			}
		 return $clients;

	}

	public function getClientByID($id) {
		$db = $this->db;

		$client = new Client();
		$client->queryClient($db, $id);

		return $client;
	}

	public function saveClient($id, $coffees, $freeCups, $name, $middlename, $lastname, $telephone, $email, $comment) {
		$db = $this->db;
	
		$newClient = new Client();
           
            $newClient->name        = $name;
            $newClient->middlename  = $middlename;
            $newClient->lastname    = $lastname;
            $newClient->coffees    	= $coffees;
            $newClient->freeCups    = $freeCups;
            $newClient->telephone   = $telephone;
            $newClient->email       = $email;
            $newClient->registred   = date('Y-m-d');
            $newClient->comment     = $comment;

		if (0 != $id)  {
        	$newClient->id 			= $id;

        	$newClient->update($db);            
        } else { 
			$newClient->save($db);
        }
	}
}

	global $mysqli;
	$manager = new CRMManager($mysqli);

