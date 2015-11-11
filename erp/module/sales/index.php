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

      $salesManager = SysApplication::callManager($self->id);

        if (!isset($_GET['action'])) {
          $action = 'list';
        } else {
          $action = $_GET['action'];
        }

        if (isset($_POST['clientid']) && !isset($_POST['delete'])) {
            $salesManager->saveCheck($_POST['checkid'],
                                    $_POST['clientid'],
                                    $_POST['hrid'],
                                    $_POST['shopid']);
        }

        if (isset($_POST['delete'])) {
            $salesManager->deleteCheck($_POST['checkid']);
        }

        switch ($action) {
          case 'single':
              if (isset($_GET['id'])) {
              	$check = $salesManager->getCheckByID($_GET['id']);
                $products = $check->getListOfProducts();


                  include('module/' . $self->id . '/singleView.php');

              } else {
                SysApplication::show404();
              }
          break;

          case 'edit':
              if (isset($_GET['id'])) {
                  $check = $salesManager->getCheckByID($_GET['id']);
                  $products = $check->getListOfProducts();
              } 
                include('module/' . $self->id . '/editView.php');
          break;

          case 'guestMonitor':
                $monitor = new GuestMonitor();
                include('module/' . $self->id . '/guestMonitorView.php');
          break;

          default:
            global $waycup;
      

            $date = date("Y-m-d");
		      	$shop = $waycup->getCurrentShop();


              if (isset($_GET['date']))  $date = $_GET['date'];

                  $cups = $salesManager->getCupsOn($date, $shop);
                 $money = $salesManager->getBalance($date, $shop);
              	$checks = $salesManager->getChecks($date, $shop);
                include('module/' . $self->id . '/tableView.php');

          break;
        }
