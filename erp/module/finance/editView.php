<h3 class="main-title">Действия для транзакции #<?php echo $_GET['id']; ?></h3>
<div class="top-client">
         <a href="?page=<?php echo $index; ?>">Назад</a>
</div>
<form method="post" action="?page=<?php echo $index; ?>">
	<input type="hidden" name="transactionID" value="<?php echo $_GET['id']; ?>"><br>
	<input type="hidden" name="action" value="delete">
	<input type="submit" value="Удалить к хуям!">

</form>