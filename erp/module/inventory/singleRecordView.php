 <div class="top-client">
	 <a href="?page=<?php echo $index; ?>">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
 </div>

 <div style="display: inline-block; width: 100%;">
 	<h3>Операция: <?php echo $record->kind; ?></h3>
 	<h3>Бариста:  <?php echo $record->HRString; ?></h3>
</div>
<div class="table-client">
	<table>
		<thead>
			<tr>
				<td>Наименование</td>
				<td>Колличество</td>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach ($record->listOfResources as $res) { ?>
			<?php var_dump($res); ?>
				<tr>
					<td><?php echo $res->product->Name; ?></td>
					<td><?php echo $res->product->Amount . $res->product->Unit; ?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>
</div>
 <br>
 <br>