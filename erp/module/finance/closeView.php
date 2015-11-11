<h3 class="main-title">Закрыть смену</h3>
<div class="top-client">
         <a href="?page=<?php echo $index; ?>">Назад</a>
</div>

<form method="post" action="?page=<?php echo $index; ?>">
	<input type="hidden" name="summ" value="<?php echo $profit; ?>"><br>
	Коммент:<br>
	<textarea name="comment"></textarea><br>
	<input type="hidden" name="action" value="close"><br>
	<input type="submit" value="Закрыть!">

</form>