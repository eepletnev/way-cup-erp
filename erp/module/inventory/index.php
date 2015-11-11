<?php 
      // Модуль склада.

        // Задачи:
          //  Сделать, плез, начинай писать уже, хорош пиздеть.

      // 09.09.2015 


  // Find a way to avoid this:

    $self = SysApplication::getCurrentPage();
  
  // 'cause this shit is the same for all the managers using modules.

      $index = SYSApplication::getPageIndexByName($self->name);

  // Generaly, the shit below is the only shit that should be here:
       
        $inventoryManager = SysApplication::callManager($self->id);
        
        global $waycup;
        $shop = $waycup->getCurrentShop();


        if (!isset($_GET['action'])) {
          $action = 'list';
        } else {
          $action = $_GET['action'];
        }

        if (isset($_POST['action'])) {
          switch ($_POST['action']) {
            case 'edit':
                $resource = new Resource();
                $resource = $inventoryManager->getResourceByID($_POST['ResourceID']);
                $product  = $resource->product;
                $product->Amount = $_POST['minusQuantity'];
                $inventoryManager->saveRecord(array($product), $shop, $_SESSION['userID'], 2);
                $inventoryManager->writeOff(array($product), $shop);
                echo "Done!";
              break;
            
            default:
              break;
          }
        }



        switch ($action) {
          case 'single':
              if (isset($_GET['id'])) {
                $resource = $inventoryManager->getResourceByID($_GET['id']);
                  include('module/' . $self->id . '/singleView.php');
              } else {
                SysApplication::show404();
              }
          break;

          case 'edit':
              if (isset($_GET['id'])) {
                $resource = $inventoryManager->getResourceByID($_GET['id']);              
              } else {
                $resource = new Resource();
              }
                include('module/' . $self->id . '/editView.php');
          break;

          case 'records':
                $records = $inventoryManager->getInventoryHistory($shop);
                include('module/' . $self->id . '/historyView.php');
          break;

          case 'singleRecord': 
            if (isset($_GET['id'])) {
              $record = $inventoryManager->getRecordByID($_GET['id']);         
            } else {
              $record = new Record();
            }
              include('module/' . $self->id . '/singleRecordView.php');
          break;

          default:
                $resources = $inventoryManager->getInventoryList($shop);
                include('module/' . $self->id . '/tableView.php');

          break;
        }