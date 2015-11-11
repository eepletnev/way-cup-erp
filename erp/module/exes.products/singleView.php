 <div class="top-client">
	 <a href="?page=<?php echo $index; ?>">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a href="?page=<?php echo $index; ?>&amp;action=edit&amp;id=<?php echo $product->ID; ?>">Редактировать</a>
 </div>

 <div style="display: inline-block; width: 100%;">
	 <h3 style="float: left"><?php echo $product->Name; ?></h3>
	 <h3 style="float: right"><?php echo $product->ID; ?></h3>
</div>
<h4><?php echo $product->Amount . ' ' . $product->Unit; ?></h4>
<h4>Стоимость: <?php echo $product->Price; ?> руб</h4>
 <h4>Категория: <?php echo $product->getCategoryName(); ?></h4>
 <br>