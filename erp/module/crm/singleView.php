 <div class="top-client">
	 <a href="?page=<?php echo $index; ?>">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a href="?page=<?php echo $index; ?>&amp;action=edit&amp;id=<?php echo $client->id; ?>">Редактировать</a>
 </div>

 <div style="display: inline-block; width: 100%;">
	 <h3 style="float: left"><?php echo $client->name . ' ' . $client->middlename . ' ' . $client->lastname; ?></h3>
	 <h3 style="float: right"><?php echo $client->id; ?></h3>
</div>

 <br>
 <h3 style="margin-top: 0px;"><?php echo $client->telephone; ?>  <?php echo $client->email; ?></h3>
 <h4>Стаканов на карте: <?php echo $client->coffees; ?></h4>
 <h4>Текущих бонусов: <?php echo $client->coffees % 6; ?></h4>
 <h4>Сохранённых бесплатных: <?php echo $client->freeCups; ?></h4>
 <br>

  <h5>Комментарий:</h5>
<?php echo $client->comment; ?>


 <h5>Любимый кофе:</h5>
<?php echo "<i style='color: grey;'>Still in progress...</i>"; ?>

<h5>Посещения:</h5>
 <?php echo "<i style='color: grey;'>Still in progress...</i>"; ?>