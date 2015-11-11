    <div class="table-client">
    

    <div class="top-client">
         <a href="?page=<?php echo $index; ?>&amp;action=close">Закрыть смену</a>
         <strong style="margin: 0 0 0 10px;">|</strong>
         <a href="?page=<?php echo $index; ?>&amp;action=draw">Снять</a>
         <a href="?page=<?php echo $index; ?>&amp;action=debit">Внести</a>
    </div>

    <div class="date-picker">
           <a href="?page=<?php echo $index; ?>&date=<?php echo date('m', strtotime('-1 month', $date));?>">< Туда</a>
           <a href="?page=<?php echo $index; ?>&date=<?php echo date('m', strtotime('+1 month', $date));?>">Сюда ></a>
    </div>
    <h4>Денег в кассе: <?php echo $balance; ?> руб</h4>
    <h5>Текущая выручка: <?php echo $currentSession['income']->cash; ?> руб<br>
    Текущие расходы: <?php echo $currentSession['outcome']->cash; ?> руб<br>
    Сегодняшняя прибыль: <?php echo $profit . " руб";?></h5>

            <table>
             <thead>
               <td>Тип</td>
               <td>Комент</td>
               <td>Деньги</td>
               <td>Таймкод</td>
             </thead>
             <tbody>
              <?php foreach ($transactions as $transaction) { ?>
                  <tr onclick="window.open('?page=<?php echo $index; ?>&amp;action=single&amp;id=<?php echo $transaction->id; ?>','_self')">
                    <td><?php echo $transaction->kindString; ?></td>
                    <td><?php echo $transaction->comment; ?></td>
                    <td><?php echo $transaction->cash; ?></td>
                    <td style="width:30%;"><?php echo $transaction->timestamp; ?></td>
                  </tr>
              <?php } ?>
             </tbody>
           </table>
   </div>
