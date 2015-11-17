<?php

   $index = SysApplication::getPageIndexByName('По карте');
   $index1 = SysApplication::getPageIndexByName('Закупка');

?>          <h3 class="main-title">Заказ</h3><br>
            
            <div style="border-top: 1px #ebae08 solid; border-bottom: 1px #ebae08 solid; margin-top: 20px; padding: 20px; overflow-y: scroll;">
                 <a href="<?php echo "?page=$index"; ?>">
                  <div class="div-like-li">
                     <span style='margin-left: auto; margin-right: auto; display: inline;'>По карте</span>
                  </div>
                </a>
               <a href="<?php echo "?page=$index1"; ?>">
                  <div class="div-like-li">
                     <span style='margin-left: auto; margin-right: auto; display: inline;'>Закупка</span>
                  </div>
                </a>                   
            </div>


                  <div class="clear"></div>
                  <br>

               <h3 class="main-title">Новости</h3>
               <div style="border-top: 1px #ebae08 solid; border-bottom: 1px #ebae08 solid; margin-top: 20px; padding: 20px; height: 300px; overflow-y: scroll;">
                  
               </div>
