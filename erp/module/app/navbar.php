       <div class="span2">
         <div class="menu-left">
          <ul>
            <?php
            	foreach (SysApplication::getAllPages() as $i => $page) {
                if (($page->status != 'blocked') && ($page->getType() == 'navigation')) {
              		echo '<li><a href="?page=' . $i . '"' . $page->markActive()  . '><i class="' . $page->getClass() . '"></i>' . $page->name . '</a></li>';	
                }
               }
            ?>
          </ul>
         </div>
       </div>

       <div class="span10">
         <div class="main-content">