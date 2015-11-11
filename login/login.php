<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Way Cup Coffee</title>
    <link href="../css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="../css/style.css"     rel="stylesheet" media="screen">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/sha512.js"></script> 
    <script src="../js/forms.js"></script> 
  </head>
  <body>
     <div class="container login-container">
    <div class="logo-top-block">
      <a href="index.php"></a>
    </div>

      <div class="login-form">
    <?php
    if (isset($_GET['error'])) { ?>
      <p class="error">Что-то пошло не так!<?php echo " Код ошибки: " . $_GET['error'];?></p>
    <?php }                      ?> 
    
       <form action="sys_login.php" method="post" name="login_form">
         <ul>
           <li>
            Пользователь:
            <input type="text" name="username" />
           </li>
           <li>
            Пароль:
            <input type="password" name="password" id="password" />
           </li>
           <li>
            <input type="button" class="btn" value="Вход" onclick="formhash(this.form, this.form.password);" />
            <label for="check"><input type="checkbox" value="true" name="dont-rmbr"> Не запоминать </label>
           </li>
         </ul>
       </form>
     </div>
   </div>
    </div>
  </body>
</html>