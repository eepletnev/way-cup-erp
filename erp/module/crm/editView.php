<form method="post" action="?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $client->id; ?>" id="saveForm">
 <div class="top-client">
	 <a href="javascript:history.back()">Назад</a>
	 <strong style="margin: 0 0 0 10px;">|</strong>
	 <a onclick="document.getElementById('saveForm').submit();">Сохранить</a>
 </div>
	<div style="display: inline-block; width: 100%;">
	 <h3 style="float: right"><?php if ($client->id == 0) echo 'новый'; else echo $client->id; ?></h3>
	</div>
		<input type="hidden" name="clientid" value="<?php echo $client->id; ?>">

	<h3>
		<input type="text" name="firstname" value="<?php echo $client->name; ?>" placeholder="Имя">
		<input type="text" name="middlename" value="<?php echo $client->middlename; ?>" placeholder="Отчество">
		<input type="text" name="lastname" value="<?php echo $client->lastname; ?>" placeholder="Фамилия">
	</h3>
	
 <br>
 <h3 style="margin-top: 0px;"><input type="text" name="telephone" value="<?php echo $client->telephone; ?>" placeholder="Телефон"></h3>
 <h3><input type="text" name="email" value="<?php echo $client->email; ?>" placeholder="Email"></h3>

 <h4>Стаканов на карте: 	 <input type="number" name="coffees" value="<?php echo $client->coffees; ?>"></h4>
 <h4>Сохранённых бесплатных: <input type="number" name="freeCups" value="<?php echo $client->freeCups; ?>"></h4>
 <br>

  <h5>Комментарий:</h5>
	<textarea name="comment"><?php echo $client->comment; ?></textarea>

</form>