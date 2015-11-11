
	<h3 class="main-title">Продажи</h3>
	<div class="date-picker">
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
		         		<td>Сумма</td>
		         		<td>Стаканы</td>
		         		<td>Время транзакции</td>
		         	</tr>
		         </thead>
		         <tbody>
					<?php foreach ($checks as $check) { ?>
							 <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $check->id; ?>','_self')">
			                    <td><?php echo $check->clientString; ?></td>
			                    <td><?php echo $check->money; ?></td>
			                    <td>
			                    	<?php
			                    		for ($cup=0; $cup < $check->getCups(); $cup++) { 
			                    			echo "<i style='background-size: 9px 18px; width: 9px; height: 18px;'></i>";
			                    		}
			                    	?>
			                    </td>
			                    <td><?php echo $check->getTime(); ?></td>
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