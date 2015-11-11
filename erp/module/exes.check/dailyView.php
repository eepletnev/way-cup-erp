
	<h3 class="main-title">Затраты</h3>
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
		         		<td>Бариста</td>
		         		<td>Сумма</td>
		         		<td>Время транзакции</td>
		         	</tr>
		         </thead>
		         <tbody>
					<?php foreach ($checks as $check) { ?>
							 <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $check->id; ?>','_self')">
			                    <td><?php echo $check->HRString; ?></td>
			                    <td><?php echo $check->money; ?> руб.</td>
			                    <td><?php echo $check->getTime(); ?></td>
			                  </tr>
					<?php  }?>
				</tbody>
			</table>
		</div>
<?php } else { ?>
		<div class='empty-table'>
			<h4>Нет затрат.</h4>
		</div>
<?php }?>