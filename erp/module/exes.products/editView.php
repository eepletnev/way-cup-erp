<form method="post" action="?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $product->ID; ?>" id="saveForm">
 <div class="top-client">
	 <a href="javascript:history.back()">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a onclick="document.getElementById('saveForm').submit();">Сохранить</a>
 </div>
	<div style="display: inline-block; width: 100%;">
	 <h3 style="float: right"><?php if ($product->ID == 0) echo 'Новый'; else echo $product->ID; ?></h3>
	</div>
		<input type="hidden" name="ProductID" value="<?php echo $product->ID; ?>">

	<h3>
		Название
		<br>
		<input type="text" name="Name" value="<?php echo $product->Name; ?>" placeholder="Название">
	</h3>
	
 <br>
 <h3>Цена</h3>
 <h3 style="margin-top: 0px;"><input type="number" name="Price" value="<?php echo $product->Price; ?>" placeholder="Цена"></h3>
 <br>
 <h4>Категория:</h4>
 	<select name="ProductCategoryID">
 		<?php foreach ($categories as $category) { ?>
 				<option value='<?php echo $category->getID(); ?>' <?php if ($category->getID() == $product->CategoryID) echo " selected"; ?>><?php echo $category->getName(); ?></option>
 		<?php } ?>
 	</select>
 
 <h4>Объём:
 	<br> 
 	<input type="text" name="Amount" value="<?php echo $product->Amount ?>">
 </h4>
 <h4>Мера измерения:
 	<br> 
 	<input type="text" name="Unit" value="<?php echo $product->Unit ?>">
 </h4>
 <br>
 <h4>В плиточках?:
 	<br> 
 	<input type="checkbox" name="OnView" value="1" <?php if (1 == $product->OnView) echo 'checked'; ?>>
 </h4>

</form>