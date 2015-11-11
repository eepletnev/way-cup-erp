    <div class="table-client">
    

    <div class="top-client">
         <a href="?page=<?php echo $index; ?>&amp;action=edit">Создать</a>
         <strong style="margin: 0 0 0 10px;">|</strong>
    </div>

            <table>
             <thead>
               <td>Номер</td>
               <td>Название</td>
               <td>Цена</td>
               <td>Объём</td>
               <td>Единицы измерения</td>
               <td>Категория</td>
             </thead>
             <tbody>
              <?php foreach ($items as $item) { ?>
                  <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $item->ID; ?>','_self')">
                    <td><?php echo $item->ID; ?></td>
                    <td><?php echo $item->Name?></td>
                    <td><?php echo $item->Price; ?></td>
                    <td><?php echo $item->Amount; ?></td>
                    <td><?php echo $item->Units; ?></td>
                    <td><?php echo $item->getCategoryName(); ?></td>
                  </tr>
              <?php } ?>
             </tbody>
           </table>
   </div>
 </div>