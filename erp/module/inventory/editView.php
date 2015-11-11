<form method="post" action="?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $resource->getID(); ?>" id="saveForm">
 <div class="top-client">
	 <a href="javascript:history.back()">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a onclick="document.getElementById('saveForm').submit();">Сохранить</a>
 </div>
	<div style="display: inline-block; width: 100%;">
	 <h3 style="float: right"><?php if ($resource->getID() == 0) echo 'новый'; else echo $resource->getID(); ?></h3>
	</div>
		
		<input type="hidden" name="ResourceID" value="<?php echo $resource->getID(); ?>">

	<h3>

		<input type="hidden" name="ProductID" value="<?php echo $resource->getExesID(); ?>">
			<?php echo $resource->getProductName(); ?>
		<br>
	</h3>
	<h3>
		Номер категории ресурса:
		<br>
		<input type="number" name="ResourceCategoryID" value="<?php echo $resource->getCategoryID(); ?>">
		<br>
		<input type="hidden" name="action" value="edit">
		Название категории:
		<?php echo $resource->getCategoryName(); ?>
	</h3>
	
 <br>
 <h4>Количество: 	 
 <br><input type="number" name="ResourceQuantity" value="<?php echo $resource->getQuantity(); ?>"></h4>
 <br>
</form>