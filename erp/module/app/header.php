<?php
  global $waycup;
  $shops = $waycup->getListOfShops();

  setlocale(LC_ALL, 'rus');
  date_default_timezone_set('Europe/Moscow');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>

      <?php 
      $pagetitle = SysApplication::getCurrentPage()->name;
      if (!$pagetitle) { 
         echo "Way Cup Coffee";
      } else { 
         echo "Way Cup Coffee" . " | " . $pagetitle;
      }
      ?>

    </title>
    <script src="../js/jquery.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.min.js"></script> 
    <link href="../css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="../css/style.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" type="image/x-icon" href="../img/icon.gif" />

  </head>
  <body>
   <div class="container header-crm">
     <div class="row">
      <div class="span4"><a href="../erp" class="logo-head"></a></div>
      <div class="span4">
        <div class="time">
          <h2>
            <?php
            echo $waycup->getShopName();
            ?>
        </h2>
          <span><?php echo date("H:i");; ?></span><br>
          <!-- <span id='daily-stat'>Стаканов: 0. Касса: 0 руб.</span> -->
        </div>
      </div>
      <div class="span4">
        <div class="login-out">
        <?php echo htmlentities($_SESSION['username']); ?><br>
          
          <ul class="user-block">
             <li><div class="shop-select">
            <form method="post" action="">
            <label>
              <select name="change_shop_to" onchange="this.form.submit();">
                <?php 
                  foreach ($shops as $value) {
                    echo "<option value='" . $value['id'] . "'";
                    if ($waycup->getCurrentShop() == $value['id']) echo ' selected';
                    echo ">" . $value['name'] . "</option>";
                  }
                  if (!$waycup->getCurrentShop()) echo '<option value="false" selected>НЕ ВЫБРАНА</option>';
                ?>
              </select>
            </label>
            </form>
            </div></li>
            <li><a href="?page=<?php echo SysApplication::getPageIndexByName('Профиль'); ?>">Профиль</a></li>
            <li><a href="../login/logout.php">Выйти</a></li>
          </ul>
          <input type='hidden' id='barista_id' value=<?php echo $_SESSION['userID']; ?>>
        </div>
      </div>
    </div>
   </div>
  <div class="container main-block">
    <div class="row">