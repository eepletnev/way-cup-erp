    <h3 class="main-title">Ассортимент меню:</h3>

    <div class="table-client">
    

    <div class="top-client">
         <a href="?page=<?php echo $index; ?>&amp;action=edit">Создать</a>
         <strong style="margin: 0 0 0 10px;">|</strong>
         <a href="?page=<?php echo $index; ?>&amp;action=categories">Категории</a>
    </div>

            <table>
             <thead>
               <td>Категория</td>
               <td>Название</td>
               <td>Цена</td>
               <td>Объём</td>
               <td>Единицы измерения</td>

             </thead>
             <tbody>
              <?php foreach ($items as $item) { ?>
                  <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $item->ID; ?>','_self')">
                    <td><?php echo $item->getCategoryName(); ?></td>
                    <td><?php echo $item->Name?></td>
                    <td><?php echo $item->Price; ?></td>
                    <td><?php echo $item->Amount; ?></td>
                    <td><?php echo $item->Units; ?></td>

                  </tr>
              <?php } ?>
             </tbody>
           </table>
   </div>
