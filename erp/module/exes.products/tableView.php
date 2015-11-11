    <h3 class="main-title">Ассортимент закупок:</h3>

    <div class="table-client">
    

    <div class="top-client">
         <a href="?page=<?php echo $index; ?>&amp;action=edit">Создать</a>
         <strong style="margin: 0 0 0 10px;">|</strong>
         <a href="?page=<?php echo $index; ?>&amp;action=categories">Категории</a>
    </div>

            <table>
             <thead>
               <td>Название</td>
               <td>Объём</td>
               <td>Цена</td>
               <td>Категория</td>
               <td>В закупке</td>
             </thead>
             <tbody>
              <?php foreach ($products as $product) { ?>
                  <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $product->ID; ?>','_self')">
                    <td><?php echo $product->Name; ?></td>
                    <td><?php echo $product->Amount . $product->Unit; ?></td>
                    <td><?php echo $product->Price; ?></td>
                    <td><?php echo $product->getCategoryName(); ?></td>
                    <td><?php echo $product->OnView; ?></td>
                  </tr>
              <?php } ?>
             </tbody>
           </table>
   </div>
