 <div class="top-client">
	 <a href="?page=<?php echo $index; ?>">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a href="?page=<?php echo $index; ?>&amp;action=edit&amp;id=<?php echo $resource->getID(); ?>">Списать</a>
 </div>

 <div style="display: inline-block; width: 100%;">
	 <h3 style="float: left"><?php echo $resource->getProductName(); ?></h3>
	 <h3 style="float: right"><?php echo $resource->getID(); ?></h3>
</div>

 <br>
 <h4>Количество: <?php echo $resource->getQuantity(); ?></h4>
 <h4>Категория: <?php echo $resource->getCategoryName();?></h4>
 <br>