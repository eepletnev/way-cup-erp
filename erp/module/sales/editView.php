<script type="text/javascript">
	function deleteCheck() {
		if (confirm("Подтвердите удаление?") == true) {
			document.getElementById('deleteForm').submit();
		} 
	}
</script>



<form method="post" action="?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $check->id; ?>" id="saveForm">
 <div class="top-client">
	 <a href="javascript:history.back()">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a onclick="document.getElementById('saveForm').submit();">Сохранить</a>
	 <a onclick="deleteCheck()">Удалить</a>
 </div>
	<div style="display: inline-block; width: 100%;">
	 	 <h3 style="float: left">Чек #<?php echo $check->id; ?>:</h3>
		 <h3 style="float: right"><?php echo $check->timecode; ?></h3>
	</div>
		<input type="hidden" name="checkid" value="<?php echo $check->id; ?>">
	<h3></h3>
	<h4>Клиент:</h4><input type="text" value="<?php echo $check->clientID; ?>" name="clientid">
	<h4>Бариста:</h4><input type="text" value="<?php echo $check->HRID; ?>" name="hrid">
	<h4>Кофейня:</h4><input type="text" value="<?php echo $check->shopID; ?>" name="shopid">
	<h4>Удалить:</h4>
	<?php echo "<i style='color: grey;'>Удаление ещё не реализованно...</i>"; ?>
		<ul>
			<?php foreach ($products as $product) { ?>
				<li><?php echo $product->name . ' ' . $product->amount . '...........' . $product->price . 'руб.'; ?><input type="checkbox" name="delete[]" value="<?php echo $product->id; ?>"></li>
			<?php } ?>
		</ul>
	<h5>Итого: <?php echo $check->money; ?> рублей</h5>


</form>

<form method="post" action="?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $check->id; ?>" id="deleteForm">
	<input type="hidden" name="checkid" value="<?php echo $check->id; ?>">
	<input type="hidden" name="delete" value="true">
</form>




