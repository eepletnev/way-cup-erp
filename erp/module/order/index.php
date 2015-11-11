<?php 
      // Модуль оформления заказа. 

        // Задачи:

          // * Полностью нахуй переделать.


        // general todo:

          // * Реализовать первую задачу;


      // 6.10.2015 


  // Find a way to avoid this:

    $self = SysApplication::getCurrentPage();
  
    $path = 'module/' . $self->id . '/' . $self->id . '_manager.php';
     
     if (file_exists($path)) {
        require_once($path);
     }

  // 'cause this shit is the same for all the managers using modules.

      $index = SysApplication::getPageIndexByName($self->name);

  // Generaly, the shit below is the only shit that should be here:


  ?>


<input type="hidden" id="shop_id" value="<?php echo $_SESSION['shop_id']; ?>">
<script src="../js/react/react.js"></script>
<script src="../js/react/JSXTransformer.js"></script>
<script type="text/jsx" src="module/order/orderHandling.jsx"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <div class="menu-block">		
      		<div id="tooltip">

          		<a onclick="this.parentNode.style.display = 'none';">x</a>
          		<div id="tooltipText"></div>
          	</div>
          <h3 class="main-title">Оформление заказа</h3>
          <div id="menu-react-mount"></div>

       </div>