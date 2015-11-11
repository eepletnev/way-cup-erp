<form method="post" action="?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $item->ID; ?>" id="saveForm">
 <div class="top-client">
	 <a href="javascript:history.back()">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a onclick="document.getElementById('saveForm').submit();">Сохранить</a>
 </div>
	<div style="display: inline-block; width: 100%;">
	 <h3 style="float: right"><?php if ($item->ID == 0) echo 'Новый'; else echo $item->ID; ?></h3>
	</div>
		<input type="hidden" name="ItemID" value="<?php echo $item->ID; ?>">

	<h3>
		Название
		<br>
		<input type="text" name="Name" value="<?php echo $item->Name; ?>" placeholder="Название">
	</h3>
	
 <br>
 <h3>Цена</h3>
 <h3 style="margin-top: 0px;"><input type="number" name="Price" value="<?php echo $item->Price; ?>" placeholder="Цена"></h3>
 <br>
 <h4>Объём: 
 	<br>	 
 	<input type="number" name="Amount" value="<?php echo $item->Amount; ?>">
 </h4>
 <br> 
 <h4>Единицы измерения: 
 	<br>	 
 	<input type="text" name="Units" value="<?php echo $item->Units; ?>" placeholder="мл">
 </h4>
 <br>
 <h4>Категория:
 	<br> 
 	<input type="number" name="CategoryID" value="<?php echo $item->CategoryID ?>">
 </h4>
 <br>

</form>