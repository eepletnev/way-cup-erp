<?php

require_once('../sys/sys_db_connect.php');
require_once('../sys/sys_functions.php');


// Application inititalizer: 
 require_once('module/app/application.php');  // App


if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case 'clientSearch':
			if (isset($_GET['query']) && ($_GET['query'] != '')) {
				$find  = $_GET['query'];
				$query = "SELECT `id` FROM `crm_client` 
							   WHERE `id`		  LIKE '%$find%'
						   		  OR `telephone`  LIKE '%$find%' 
						   		  OR `lastname`	  LIKE '%$find%'
						   		  LIMIT 10";

					if ($qry_result = $mysqli->query($query)) {
						$crmManager = SysApplication::callManager('crm');
						
						$result = array();
						while ($row = $qry_result->fetch_assoc()) {
							array_push($result, $crmManager->getClientByID($row['id']));
						}

						echo json_encode($result);
					} else {
						echo json_encode(array("error" => 1, "message" => "Wrong query"));
					}

			} else {
				echo json_encode(array("error" => 1, "message" => "No query recieved"));
			}
			break;

		case 'getMenu':
				$menu = array();
				$menu['elements'] = array();
				$menu['categories'] = array();



				if (!$stmt = $mysqli->query('SELECT id, name, bonus FROM `sales_menu_cat`')) {
					echo '<h2>Сорян, что-то пошло не так с категориями :С</h2>';
				} else {
					$bonus = array();
				    while ($row = $stmt->fetch_assoc()) {
				    	$anElement = array($row['id'], $row['name']);
				    	$bonus[$row['id']] = $row['bonus'];
				    	array_push($menu['categories'], $anElement);
				    }
				}


				if (!$stmt = $mysqli->query('SELECT id, name, price, amount, categoryID, unit FROM `sales_menu`')) {
					echo '<h2>Сорян, что-то пошло не так с менюхой :С</h2>';
				} else {
				    while ($row = $stmt->fetch_assoc()) {
				    	if (!isset($bonus[$row['categoryID']])) {
				    		$bonus[$row['categoryID']] = 'ЧЁ ЗА ХУЙНЯ?!';
				    	}
				    	$anElement = array($row['id'], $row['name'], $row['price'], $row['amount'], $row['categoryID'], $row['unit'], $bonus[$row['categoryID']]);
				    	array_push($menu['elements'], $anElement);
				    }
				}

				echo json_encode($menu);
			break;

		case 'getProducts':
				$menu = array();
				$menu['elements'] = array();
				$menu['categories'] = array();



				if (!$stmt = $mysqli->query('SELECT id, name FROM `exes_product_cat`')) {
					echo '<h2>Сорян, что-то пошло не так с категориями :С</h2>';
				} else {
				    while ($row = $stmt->fetch_assoc()) {
				    	$anElement = array($row['id'], $row['name']);
				    	array_push($menu['categories'], $anElement);
				    }
				}


				if (!$stmt = $mysqli->query('SELECT id, name, price, categoryID, amount, unit FROM `exes_product` WHERE `onView` = 1')) {
					echo '<h2>Сорян, что-то пошло не так с менюхой :С</h2>';
				} else {
				    while ($row = $stmt->fetch_assoc()) {
				    	$anElement = array($row['id'], $row['name'], $row['price'], $row['categoryID'], $row['amount'], $row['unit']);
				    	array_push($menu['elements'], $anElement);
				    }
				}

				echo json_encode($menu);
			break;

		case 'saveIncomeCheck':
				if (!isset($_POST['cardnum'])) {
					$cardnum = 0;
				} else {
					if ('true' == $_POST['newOne'] && $_POST['cardnum'] != 0) {
						$cardnum = $_POST['cardnum'];
						$query  = "INSERT INTO `crm_client` (`telephone`) VALUES ('$cardnum');";
						$mysqli->query($query);
						$cardnum = $mysqli->insert_id;
					} else {
						$cardnum = $_POST['cardnum'];
					}

					$cardnum = $mysqli->real_escape_string($cardnum);
					$query   = "SELECT `id`, `coffees` FROM `crm_client` WHERE `id` = '$cardnum'";
					$qry_result = $mysqli->query($query);
					if ($qry_result->num_rows <> 0) {
						$row = mysqli_fetch_array($qry_result);
						$clientID = $row['id'];
						$newCoffees = $row['coffees'];
					} else {
						$clientID = 0;
						$newCoffees = 1;
					}
					
					
					if (isset($_POST['coffees'])) {
						$newCoffees += $_POST['coffees'];
					}
				}


				if (isset($_POST['cash'])){
					$cash = $_POST['cash'];
				} else {
					$cash = 0;
				}
				setlocale(LC_ALL, 'rus');
				date_default_timezone_set('Europe/Moscow');
				$timecode = date('Y-m-d H:i:s');

				if (!isset($_POST['idset']) || count($_POST['idset']) == 0) {
					echo "ЗАКАЗ ПУСТОЙ";
				} else {
					$idset 	     = $_POST['idset'];
					$baristaId   = $_POST['barista'];
					$shop	     = $_POST['shop'];
					
					$stockMan    = SysApplication::callManager('inventory');
					$menuManager = SysApplication::callManager('menu');
					

					if (!$shop) {
						echo 'Точка не выбрана!';
					} else {
						$query  = "INSERT INTO `sales_check` VALUES (0, '$baristaId', '$clientID', '$shop', '$cash', '$timecode');";
						$query1 = "UPDATE `crm_client` SET `coffees` = '$newCoffees' WHERE `id` = '$clientID'";

						//Execute query
						$qry_result  = $mysqli->query($query);
						$checkID     = $mysqli->insert_id;
						$qry1_result = $mysqli->query($query1);

						if ($qry_result && $qry1_result){
							$toWriteOff = array(); 

							foreach ($idset as $pairItemAction) {
								$isFree = $pairItemAction[1];
								$itemID = $pairItemAction[0];
								$query = "INSERT INTO `sales_check_item` VALUES ($checkID, $itemID, $isFree);";
								$check = $mysqli->query($query);
								
								$item = $menuManager->getItemByID($itemID);

								if ($menuManager->getRecepieFor($item)) {
									$toWriteOff = array_merge($item->Recepie, $toWriteOff);
								}

							}

							$stockMan->writeOff($toWriteOff, $shop);
							
							if ($check) { 
								echo 'Отлично! Схоронил чек по карте #' . $cardnum;
							}

						} else {
							echo 'Всё очень плохо. Очень плохо.';
						}
					}
				}
			break;

		case 'saveOutcomeCheck':
			if (!isset($_POST['idset']) || count($_POST['idset']) == 0) {
					echo "ЗАКАЗ ПУСТОЙ";
				} else {
					$idset 		= $_POST['idset'];
					$baristaId  = $_POST['barista'];
					$shop	    = $_POST['shop'];
					$exesManager = SysApplication::callManager('exes.products');
					
					setlocale(LC_ALL, 'rus');
					date_default_timezone_set('Europe/Moscow');
					$timecode = date('Y-m-d H:i:s');

					if (!$shop) {
						echo 'Точка не выбрана!';
					} else {
						$query  = "INSERT INTO `exes_check` VALUES (0, '$baristaId', '$shop', '$timecode');";

						//Execute query
						$qry_result  = $mysqli->query($query);
						$checkID     = $mysqli->insert_id;

						if ($qry_result){
							$check = true;
							foreach ($idset as $id) {
								$product = $exesManager->getProductByID($id);
								
								$query = "INSERT INTO `exes_check_item` VALUES ($checkID, $id);";
								$checkIfStorable = $mysqli->query($query);

								$query = "SELECT `storable` FROM `exes_product` WHERE `id` = $id;";
								$checkIfStorable = $mysqli->query($query);
								$checkIfStorable = $checkIfStorable->fetch_row();
								$checkIfStorable = $checkIfStorable[0];

								if ($checkIfStorable) {

									$query = "SELECT `id` FROM `inventory_resource` WHERE (`exesID` = $id) AND (`shopID` = '$shop')";
									$checkIfExists = $mysqli->query($query);
									if ($checkIfExists->num_rows != 0) {
										$resID = $checkIfExists->fetch_assoc();
										$resID = $resID['id'];
										$updateQuery = "UPDATE `inventory_resource` SET `quantity` = `quantity` + $product->Amount WHERE `id` = $resID";
										$mysqli->query($updateQuery);
									} else {
										$insertQuery = "INSERT INTO `inventory_resource` VALUES (0, $product->Amount, 1, $product->ID, $shop)";
										$mysqli->query($insertQuery);
									}
								}
							}
							
							if ($check) { 
								echo 'Отлично! Схоронил чек';
							}

						} else {
							echo 'Всё очень плохо. Очень плохо.';
						}
					}
				}
			break;

		default:
			echo json_encode(array("error" => 1, "message" => "Wrong action recieved"));
			break;
	}
} else {
	echo json_encode(array("error" => 1, "message" => "No action requested"));
}