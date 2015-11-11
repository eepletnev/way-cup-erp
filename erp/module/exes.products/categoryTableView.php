    <div class="table-client">
    <div class="top-client">
         
         <a href="?page=<?php echo $index; ?>&amp;action=list">Продукты</a>
         <strong style="margin: 0 0 0 10px;">|</strong>
         <a href="?page=<?php echo $index; ?>&amp;action=categoryEdit">Создать</a>
         
    </div>
            <table style="width: 60%; margin-left: auto; margin-right: auto; margin-top: 20px;">
            <thead>
              <tr><td>Категории</td></tr>
            </thead>
              <?php foreach ($categories as $category) { ?>
                  <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=categoryEdit&amp;id=<?php echo $category->getID(); ?>','_self')" style="height: 50px;">
                    <td><?php echo $category->getName(); ?></td>
                  </tr>
              <?php } ?>
           </table>
   </div>
 </div>