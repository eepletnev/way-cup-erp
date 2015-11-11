<?php 
      // Финансовый модуль
  
        // Задачи:
            // НУТЫПОНЕЛ, некогда писать тз.

  
        // Автор:
            // Копипастер228.
            // При участии команды сайта Ognemet.co

      // 9.09.2015 

  // Find a way to avoid this:

    $self = SysApplication::getCurrentPage();
  
  // 'cause this shit is the same for all the managers using modules.

      $index = SYSApplication::getPageIndexByName($self->name);
      $shopID = $_SESSION['shop_id'];

  // Generaly, the shit below is the only shit that should be here:
       
        $financeManager = SysApplication::callManager($self->id);
        $financeManager->setShopID($shopID);

        if (isset($_GET['date']))  $date = $_GET['date']; else $date = date('Ymd');

        if (!isset($_GET['action'])) {
          $action = 'list';
        } else {
          $action = $_GET['action'];
        }

      
        if (isset($_POST['action'])) {
              switch ($_POST['action']) {
                case 'draw':
                   $draw = new Transaction(0, 4, '', $_POST['comment'], -$_POST['summ'], '');
                   $financeManager->save($draw);
                  break;
                
                case 'debit':
                    $debit = new Transaction(0, 3, '', $_POST['comment'], $_POST['summ'], '');
                    $financeManager->save($debit);
                  break;

                case 'delete':
                    $financeManager->kEbenyam($_POST['transactionID']);
                  break;

                case 'close':
                    $close = new Transaction(0, 5, '', $_POST['comment'], $_POST['summ'], '');
                    $stockMan = SysApplication::callManager('inventory', 'InventoryManager');

                    $date = date('Y-m-d');
                    $shop = $shopID;
                    $HRID = $_SESSION['userID'];

                    $stockMan->saveShiftProducts($date, $shop, $HRID);
                    $financeManager->save($close);
                  break;

                default:
                    break;
              }

        }


        
        switch ($action) {
          case 'single':
              if (isset($_GET['id'])) {
                  include('module/' . $self->id . '/editView.php');
              } else {
                SysApplication::show404();
              }
          break;

          case 'close':
              $currentSession = $financeManager->getDailyStat();   
              $profit = $currentSession['income']->cash - $currentSession['outcome']->cash; 
             include('module/' . $self->id . '/closeView.php');
          break;

          case 'draw':
             include('module/' . $self->id . '/drawView.php');
          break;

          case 'debit':
             include('module/' . $self->id . '/debitView.php');
          break;
          
          default:
              $transactions   = $financeManager->getMonthTransactions($shopID);
              $balance        = $financeManager->countUp($shopID);
              $currentSession = $financeManager->getDailyStat($date);   
              $profit = $currentSession['income']->cash - $currentSession['outcome']->cash; 
              include('module/' . $self->id . '/listView.php');
          break;
        }