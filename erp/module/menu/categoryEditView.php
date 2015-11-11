<form method="post" action="?page=<?php echo $index; ?>&amp;action=categories" id="saveForm">
 <div class="top-client">
	 <a href="javascript:history.back()">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a onclick="document.getElementById('saveForm').submit();">Сохранить</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a href="?page=<?php echo $index; ?>&amp;action=deleteCategory&amp;id=<?php echo $category->getID(); ?>">Удалить</a>
 </div>
	<div style="display: inline-block; width: 100%;">
	 <h3 style="float: right"><?php if ($category->getID() == 0) echo 'Новый'; else echo $category->getID(); ?></h3>
	</div>
		<input type="hidden" name="CategoryID" value="<?php echo $category->getID(); ?>">

	<h3>
		Название
		<br>
		<input type="text" name="CategoryName" value="<?php echo $category->getName(); ?>" placeholder="Название">
	</h3>
	
 <br>
 <h3>Бонус</h3>
 <h3 style="margin-top: 0px;"><input type="number" name="Bonus" value="<?php echo $category->getBonus(); ?>" placeholder="Бонус"></h3>

</form>