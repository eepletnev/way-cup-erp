    <div class="table-client">
    

    <div class="top-client">
         <a href="?page=<?php echo $index; ?>&amp;action=edit">Создать</a>
         <strong style="margin: 0 0 0 10px;">|</strong>
         <a href="?page=<?php echo $index; ?>&amp;show=10">10</a>
         <a href="?page=<?php echo $index; ?>&amp;show=25">25</a>
         <a href="?page=<?php echo $index; ?>&amp;show=50">50</a>
         <a href="?page=<?php echo $index; ?>&amp;show=100">100</a>
         <a href="?page=<?php echo $index; ?>&amp;show=1000">1000</a>
         <a href="?page=<?php echo $index; ?>&amp;show=all">Все</a>
    </div>

            <table>
             <thead>
               <td>Номер</td>
               <td>ФИО</td>
               <td>Телефон</td>
               <td>Бонусы</td>
               <td>Покупок</td>
             </thead>
             <tbody>
              <?php foreach ($clients as $client) { ?>
                  <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $client->id; ?>','_self')">
                    <td><?php echo $client->id; ?></td>
                    <td><?php echo $client->name . ' ' . $client->middlename . ' ' . $client->lastname; ?></td>
                    <td><?php echo $client->telephone; ?></td>
                    <td>
                    <?php
                      for ($coffee=1; $coffee <= $client->coffees % 6; $coffee++) { 
                        echo "<i></i>";
                      }
                    ?>
                    </td>
                    <td><?php echo $client->coffees; ?></td>
                  </tr>
              <?php } ?>
             </tbody>
           </table>
   </div>
 </div>