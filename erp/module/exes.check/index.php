<?php 
      // Модуль продаж. 

        // Задачи:

          // * Отображение дневных чеков в виде списка;
          // * Отображение инфы по конкретному чеку;
          // * Редактирование чека;


        // general todo:

          // * Реализовать первую задачу;


      // 26.09.2015 


  // Find a way to avoid this:

    $self = SysApplication::getCurrentPage();

  // 'cause this shit is the same for all the managers using modules.

      $index = SYSApplication::getPageIndexByName($self->name);

  // Generaly, the shit below is the only shit that should be here:

      $exesManager      = SysApplication::callManager($self->id);


        if (!isset($_GET['action'])) {
          $action = 'list';
        } else {
          $action = $_GET['action'];
        }

        if (isset($_POST['checkid']) && !isset($_POST['delete'])) {
            $exesManager->saveCheck($_POST['checkid'],
                                    $_POST['hrid'],
                                    $_POST['shopid']);
        }


         if (isset($_POST['delete'])) {
            $exesManager->deleteCheck($_POST['checkid']);
            $action = 'list';
            echo "<br>";
        }

        switch ($action) {
          case 'single':
              if (isset($_GET['id'])) {
              	$check = $exesManager->getCheckByID($_GET['id']);
                $products = $exesManager->getListOfProductsForCheck($check);
                  include('module/' . $self->id . '/singleView.php');

              } else {
                SysApplication::show404();
              }
          break;

          case 'edit':
              if (isset($_GET['id'])) {
                  $check = $exesManager->getCheckByID($_GET['id']);
                  $products = $exesManager->getListOfProductsForCheck($check);
                  include('module/' . $self->id . '/editView.php');
              } else {
                SysApplication::show404();
              }
                
          break;

          default:
            global $waycup;

            $date = date("Y-m-d");
		      	$shop = $waycup->getCurrentShop();



              if (isset($_GET['date']))  $date = $_GET['date'];

              	$checks = $exesManager->getChecks($date, $shop);
                include('module/' . $self->id . '/dailyView.php');

          break;
        }
