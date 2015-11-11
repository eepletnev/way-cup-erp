 <div class="top-client">
	 <a href="?page=<?php echo $index; ?>">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a href="?page=<?php echo $index; ?>&amp;action=edit&amp;id=<?php echo $item->ID; ?>">Редактировать</a>
 </div>

 <div style="display: inline-block; width: 100%;">
	 <h3 style="float: left"><?php echo $item->Name; ?></h3>
	 <h3 style="float: right"><?php echo $item->ID; ?></h3>
</div>

 <br>
 <h3 style="margin-top: 0px;">Стоимость: <?php echo $item->Price; ?> </h3>
 <h4>Объём: <?php echo $item->Amount; ?></h4>
 <h4>Единицы измерения: <?php echo $item->Units; ?></h4>
 <h4>Название категории: <?php echo $item->getCategoryName(); ?></h4>
 <br>