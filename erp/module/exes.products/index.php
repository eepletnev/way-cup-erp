<?php 
      // Менеджер продуктов
  
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

  // Generaly, the shit below is the only shit that should be here:
       
        $exesProductManager = SysApplication::callManager($self->id);

        if (!isset($_GET['action'])) {
          $action = 'list';
        } else {
          $action = $_GET['action'];
        }

        if (isset($_POST['ProductID'])) {
          $handleViewCheckbox   = (isset($_POST['OnView'])) ? 1 : 0;
          $handleStoreCheckbox = (isset($_POST['ToStore'])) ? 1 : 0; 

            $exesProductManager->saveProduct($_POST['ProductID'],
                                  $_POST['Price'],
                                  $_POST['Name'],
                                  $_POST['ProductCategoryID'],
                                  $handleViewCheckbox,
                                  $handleStoreCheckbox,
                                  $_POST['Amount'],
                                  $_POST['Unit']
                                  );
        }
       if (isset($_POST['CategoryID'])) {
            $exesProductManager->saveCategory($_POST['CategoryID'],
                                  $_POST['CategoryName']
                                  );
        }

        switch ($action) {
          case 'single':
              if (isset($_GET['id'])) {
                $product = $exesProductManager->getProductByID($_GET['id']); 
                  include('module/' . $self->id . '/singleView.php');
              } else {
                SysApplication::show404();
              }
          break;

          case 'edit':
              if (isset($_GET['id'])) {
                $product = $exesProductManager->getProductByID($_GET['id']);              
              } else {
                $product = new Product();
              }
                $categories = $exesProductManager->getCategoriesList();

                include('module/' . $self->id . '/editView.php');
          break;

          case 'deleteProduct':
            $exesProductManager->deleteProduct($_GET['id']);
          break;

          case 'deleteCategory':
            $exesProductManager->deleteCategory($_GET['id']);
          break;

          case 'categories':
            $categories = $exesProductManager->getCategoriesList();
            include ('module/' . $self->id . '/categoryTableView.php');
          break;

          case 'categoryEdit':
              if (isset($_GET['id'])) {
                $category = $exesProductManager->getCategoryByID($_GET['id']);              
              } else {
                $category = new ProductCategory();
              }
                include('module/' . $self->id . '/categoryEditView.php');
          break;
          
          default:
            $sort = 0; $limit = 10;
              if (isset($_GET['sort']))  $sort = $_GET['sort'];
              if (isset($_GET['show'])) $limit = $_GET['show'];


                $products = $exesProductManager->getProductsList($sort, $limit);
                include('module/' . $self->id . '/tableView.php');

          break;
        }