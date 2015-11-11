    <div class="table-client">
    <div class="top-client">
         <a href="?page=<?php echo $index; ?>&amp;action=categoryEdit">Создать</a>
         <strong style="margin: 0 0 0 10px;">|</strong>
         <a href="?page=<?php echo $index; ?>&amp;action=list">Items</a>
    </div>
            <table>
             <thead>
               <td>Номер</td>
               <td>Название</td>
               <td>Бонус</td>
             </thead>
             <tbody>
              <?php foreach ($categories as $category) { ?>
                  <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=categoryEdit&amp;id=<?php echo $category->getID(); ?>','_self')">
                    <td><?php echo $category->getID(); ?></td>
                    <td><?php echo $category->getName()?></td>
                    <td><?php echo $category->getBonus(); ?></td>
                  </tr>
              <?php } ?>
             </tbody>
           </table>
   </div>
 </div>