<?php 
      // Менеджер меню
  
        // Задачи:
            // НУТЫПОНЕЛ, некогда писать тз.

  
        // Автор:
            // Мулика, Фиса, Компьютер.
            // При участии команды сайта Ognemet.co

      // 9.09.2015 

  // Find a way to avoid this:

    $self = SysApplication::getCurrentPage();
  
  // 'cause this shit is the same for all the managers using modules.

      $index = SYSApplication::getPageIndexByName($self->name);

  // Generaly, the shit below is the only shit that should be here:
       
        $crmManager = SysApplication::callManager($self->id);

        if (!isset($_GET['action'])) {
          $action = 'list';
        } else {
          $action = $_GET['action'];
        }

        if (isset($_POST['ItemID'])) {
            $crmManager->saveItem($_POST['ItemID'],
                                  $_POST['Price'],
                                  $_POST['Name'],
                                  $_POST['CategoryID'],
                                  $_POST['Units'],
                                  $_POST['Amount']
                                  );
        }

        switch ($action) {
          case 'single':
              if (isset($_GET['id'])) {
                $item = $crmManager->getItemByID($_GET['id']); 

                  // todo: 
                  // Ебануть уи. Вот.
                  // Ещё надо инфу по покупкам. Но это, по идее, не так уж сложно должно быть. 
                  
                  include('module/' . $self->id . '/singleView.php');

              } else {
                SysApplication::show404();
              }
          break;

          case 'edit':
              if (isset($_GET['id'])) {
                $item = $crmManager->getItemByID($_GET['id']);              
              } else {
                $item = new Item();
              }
                include('module/' . $self->id . '/editView.php');
          break;

          case 'categories':
            $categories = $crmManager->getCategoriesList();
          break;

          default:
            $sort = 0; $limit = 10;
              if (isset($_GET['sort']))  $sort = $_GET['sort'];
              if (isset($_GET['show'])) $limit = $_GET['show'];


                $items = $crmManager->getItemsList($sort, $limit);
                include('module/' . $self->id . '/tableView.php');

          break;
        }