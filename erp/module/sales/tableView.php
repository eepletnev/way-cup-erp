
	<h3 class="main-title">Продажи</h3>
	<div class="date-picker">
		 <a href="?page=<?php echo $index; ?>&action=products&date=<?php echo date('Y-m-d');?>">По продуктам</a>
		 <a href="?page=<?php echo $index; ?>&date=<?php echo date('Y-m-d', strtotime('-1 days', strtotime($date)));?>">< Туда</a>
		 <label><input type="date" onchange="window.location.replace('?page=<?php echo $index; ?>&date=' + this.value);" name="date" value="<?php echo date('Y-m-d', strtotime($date));?>"></label>
         <a href="?page=<?php echo $index; ?>&date=<?php echo date('Y-m-d', strtotime('+1 days', strtotime($date)));?>">Сюда ></a>
	</div>

<?php if (count($checks) != 0) { ?>

         <div class="table-client">
	         <table id='summary-table'>
		         <thead>
		         	<tr>
		         		
		         		<td>Клиент</td>
		         		<td>Продукты</td>
		         		<td>Сумма</td>
		         		<td>Время транзакции</td>
		         		<td>Бариста</td>
		         	</tr>
		         </thead>
		         <tbody>
					<?php foreach ($checks as $check) { ?>
							 <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $check->id; ?>','_self')">
			                    <td>
			                    <?php if ($check->clientID != 0) {
			                    	echo $check->clientString; 
			                    	echo "<br>";
			                    	echo substr($check->clientTel, 7);
			                    } ?>
			                    </td>
			                     <td>
			                    <?php
			                    	foreach ($check->getGroupedList() as $item) {
			                    		echo $item['item']->ActionString . ' ' . $item['item']->Name . ' ' . $item['item']->Amount . $item['item']->Units . ' x' . $item['occurences'] . '<br>';
			                    	}	
			                    ?>
			                    </td>
			                    <td><?php echo $check->money; ?> руб.</td>
			                    <td><?php echo $check->getTime(); ?></td>
			                    <td><?php echo $check->HRString?></td>
			                  </tr>
					<?php  }?>
				</tbody>
			</table>

		<h5>Всего за этот день:</h5>
		<table>
			<thead>
				<tr>
					<td>Стаканов</td>
					<td>Денег</td>
					<td>Чеков</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $cups; ?></td>
					<td><?php echo $money; ?></td>
					<td><?php echo count($checks); ?></td>
				</tr>
			</tbody>
		</table>
		</div>

<?php } else { ?>
		<div class='empty-table'>
			<h4>Нет продаж.</h4>
		</div>
<?php }?>