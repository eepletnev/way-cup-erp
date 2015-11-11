<?php 
      // CRM модуль. 

        // Задачи:

          // * Отображение перечня клиентов в виде списка;
          // * Отображение инфы по конкретному клиенту, в т.ч. комментарий;
          // * Редактирование полей в карточке клиента, в т.ч. функция написания комментария;
          // * Создание нового клиента.


        // todo:
          
          // * Протестировать, найти баги (отвечаю, будут), устранить
          // * Сверстать синглвью так, чтобы красиво было.
          // * Припилить список посещений клиента в синглвью
              // (этим будет заниматься метод менеджера модуля продаж, так што, сначала нужно запилить его)
          // * Валидацию и безопасность запилить


        // general todo:

          // * Реализовать первую задачу; √
          // * Реализовать вторую задачу; √
          // * Реализовать третью задачу; √
          // * Реализовать четвёртую задачу; √
          // * Отметить завершение разработки модуля бутылочкой игристого жигуля. √   


      // 23.09.2015 


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

        if (isset($_POST['clientid'])) {
            $crmManager->saveClient($_POST['clientid'],
                                    $_POST['coffees'],
                                    $_POST['freeCups'],
                                    $_POST['firstname'],
                                    $_POST['middlename'],
                                    $_POST['lastname'],
                                    $_POST['telephone'], 
                                    $_POST['email'], 
                                    $_POST['comment']);
        }

        switch ($action) {
          case 'single':
              if (isset($_GET['id'])) {
                $client = $crmManager->getClientByID($_GET['id']);

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
                $client = $crmManager->getClientByID($_GET['id']);              
              } else {
                $client = new Client();
              }
                include('module/' . $self->id . '/editView.php');
          break;

          default:
            $sort = 0; $limit = 10;
              if (isset($_GET['sort']))  $sort = $_GET['sort'];
              if (isset($_GET['show'])) $limit = $_GET['show'];


                $clients = $crmManager->getList($sort, $limit);
                include('module/' . $self->id . '/tableView.php');

          break;
        }

