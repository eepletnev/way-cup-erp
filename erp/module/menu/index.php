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
       
        $menuManager = SysApplication::callManager($self->id);

        if (!isset($_GET['action'])) {
          $action = 'list';
        } else {
          $action = $_GET['action'];
        }

        if (isset($_POST['ItemID'])) {
            $menuManager->saveItem($_POST['ItemID'],
                                  $_POST['Price'],
                                  $_POST['Name'],
                                  $_POST['ItemCategoryID'],
                                  $_POST['Units'],
                                  $_POST['Amount']
                                  );
        }
       if (isset($_POST['CategoryID'])) {
            $menuManager->saveCategory($_POST['CategoryID'],
                                  $_POST['CategoryName'],
                                  $_POST['Bonus']
                                  );
        }

        switch ($action) {
          case 'single':
              if (isset($_GET['id'])) {
                $item = $menuManager->getItemByID($_GET['id']); 
                $menuManager->getRecepieFor($item);
                  // todo: 
                  // Ебануть уи. Вот.

                  include('module/' . $self->id . '/singleView.php');

              } else {
                SysApplication::show404();
              }
          break;

          case 'deleteItem':
            $menuManager->deleteItem($_GET['id']);
          break;

          case 'deleteCategory':
            $menuManager->deleteCategory($_GET['id']);
          break;

          case 'edit':
              if (isset($_GET['id'])) {
                $item = $menuManager->getItemByID($_GET['id']);              
              } else {
                $item = new Item();
              }
                include('module/' . $self->id . '/editView.php');
          break;

          case 'categories':
            $categories = $menuManager->getCategoriesList();
            include ('module/' . $self->id . '/categoryTableView.php');
          break;

          case 'categoryEdit':
              if (isset($_GET['id'])) {
                $category = $menuManager->getCategoryByID($_GET['id']);              
              } else {
                $category = new ItemCategory();
              }
                include('module/' . $self->id . '/categoryEditView.php');
          break;
          
          default:
            $sort = 0; $limit = 10;
              if (isset($_GET['sort']))  $sort = $_GET['sort'];
              if (isset($_GET['show'])) $limit = $_GET['show'];


                $items = $menuManager->getItemsList($sort, $limit);
                include('module/' . $self->id . '/tableView.php');

          break;
        }