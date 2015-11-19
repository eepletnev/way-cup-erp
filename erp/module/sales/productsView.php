<div class="table-client">
<div class="top-client">
     <a href="javascript:history.back()">Назад</a>
</div>
<div class="top-client">

	<table>
		<thead>
			<tr>
				<td>Акция</td>
				<td>Имя позиции</td>
				<td>Колличество, шт</td>
				<td>Бабки</td>
			</tr>
		</thead>
		<tbody>
			<?php $listOfProducts = $check->getGroupedList(); ?>

			<?php	foreach ($listOfProducts as $pair) { ?> 
					<tr>
						<td><?php echo ($pair['item']->ActionID == 0) ? 'нет' : $pair['item']->ActionString; ?></td>
						<td><?php echo $pair['item']->Name; ?></td>
						<td><?php echo $pair['occurences']; ?></td>
						<td><?php echo $pair['item']->Price * $pair['occurences']; ?>руб.</td>
					</tr>
			<?php }	?>
		</tbody>
	</table>
</div>