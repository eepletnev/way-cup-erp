  <h3 class="main-title">Склад</h3>

    <div class="table-client">
    

    <div class="top-client">
         <a href="?page=<?php echo $index; ?>&amp;action=edit">Добавить продукт</a>
         <strong style="margin: 0 0 0 10px;">|</strong>
    </div>

            <table>
             <thead>
               <td>Номер</td>
               <td>Название</td>
               <td>Категория</td>
               <td>Остаток</td>

             </thead>
             <tbody>
              <?php foreach ($resources as $resource) { ?>
                  <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $resource->getID(); ?>','_self')">
                    <td><?php echo $resource->getID(); ?></td>
                    <td><?php echo $resource->getProductName();?></td>
                    <td><?php echo $resource->getCategoryName();?></td>
                    <td><?php echo $resource->getQuantity(); echo $resource->getProductUnit(); ?></td>
                  </tr>
              <?php } ?>
             </tbody>
           </table>
   </div>
 </div>