	<h3 class="main-title">История перемещений</h3>
	<div class="date-picker">
		 <a href="?page=<?php echo $index; ?>&date=<?php echo date('Y-m-d', strtotime('-1 month', strtotime($date)));?>">< Туда</a>
         <a href="?page=<?php echo $index; ?>&date=<?php echo date('Y-m-d', strtotime('+1 month', strtotime($date)));?>">Сюда ></a>
	</div>

<?php if (count($records) != 0) { ?>

         <div class="table-client">
	         <table id='summary-table'>
		         <thead>
		         	<tr>
		         		<td>Бариста</td>
		         		<td>Тип</td>
		         		<td>Время транзакции</td>
		         	</tr>
		         </thead>
		         <tbody>
					<?php foreach ($records as $record) { ?>
							 <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=singleRecord&amp;id=<?php echo $record->id; ?>','_self')">
			                    <td><?php echo $record->HRString; ?></td>
			                    <td><?php echo $record->kind; ?></td>
			                    <td><?php echo $record->timecode; ?></td>
			                  </tr>
					<?php  }?>
				</tbody>
			</table>
		</div>
<?php } else { ?>
		<div class='empty-table'>
			<h4>Нет записей.</h4>
		</div>
<?php }?>