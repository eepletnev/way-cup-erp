<div class="span10">
     <div class="main-content">
     	<h3 class="main-title">Продали за всё время:</h3>
	     <?php
	     	$mysqli = $GLOBALS['mysqli'];
	     	$queryMenuItems 	= "SELECT `id`,`name`, `category`, `amount` FROM `menu`";
	     	$queryCategories 	= "SELECT `id`, `name` 			  			FROM `menuCategories`";
	     	$queryChecks 		= "SELECT `id`, `orderlist` 	  			FROM `check`";




	     	$categories  = $mysqli->query($queryCategories);
	     	$tmp = array();
	     	while ($row = $categories->fetch_assoc()) {
	     		$tmp[$row['id']] = $row['name'];
			}
			$categories = $tmp;



	     	$menuItems  = $mysqli->query($queryMenuItems);
			$tmp = array();
			while ($row = $menuItems->fetch_assoc()) {
	     		array_push($tmp, array('id' => $row['id'], 'category' => $row['category'], 'name' => $row['name'], 'ml' => $row['amount']));
			}
	     	$menuItems = $tmp;



			$checks = $mysqli->query($queryChecks);
			$tmp = '';
			while ($row = $checks->fetch_assoc()) {
				$tmp .= $row['orderlist'] . '.';
			}
			$tmp = substr($tmp, 0, strlen($tmp) - 1);
			$tmp = explode('.', $tmp);
			$repeats = array_count_values($tmp);








	     	foreach ($categories as $id => $name) {
	     		echo "<h5>" . $name . ":</h5>";
	     		foreach ($menuItems as $value) {
	     			if ($id == $value['category']) {
	     				$count = isset($repeats[$value['id']]) ? $repeats[$value['id']] : 0;
	     				$count .= '</b> шт';
	     				echo $value['name'] .  $value['ml'] . ' <b>' . $count . '.<br/>';
	     			}
	     		}
	     	}






	
	     ?>
	   </div>
</div>