<h3 class="main-title">Вытащить бабосиков</h3>
<div class="top-client">
         <a href="?page=<?php echo $index; ?>">Назад</a>
</div>
Сумма в рублях:
<form method="post" action="?page=<?php echo $index; ?>">
	<input type="number" name="summ"><br>
	Коммент:<br>
	<textarea name="comment"></textarea><br>
	<input type="hidden" name="action" value="draw"><br>
	<input type="submit" value="Снять!">

</form>