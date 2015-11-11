 <div class="top-client">
	 <a href="?page=<?php echo $index; ?>">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a href="?page=<?php echo $index; ?>&amp;action=edit&amp;id=<?php echo $check->id; ?>">Редактировать</a>
 </div>

<div style="display: inline-block; width: 100%;">
	 <h3 style="float: left">Чек #<?php echo $check->id; ?>:</h3>
	 <h3 style="float: right"><?php echo $check->timecode; ?></h3>
</div>
<h3></h3>
<h4>Бариста: <?php echo $check->HRString; ?></h4>
<h4>Заказ:</h4>
	<ul>
		<?php foreach ($products as $product) { ?>
			<li><?php echo $product->Name . '...........' . $product->Price . 'руб.'; ?></li>
		<?php } ?>
	</ul>
<h5>Итого: <?php echo $check->money; ?> рублей</h5>
