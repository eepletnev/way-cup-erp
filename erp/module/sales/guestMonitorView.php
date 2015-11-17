<?php
global $mysqli;

$inFlow = $monitor->getMonthlyInflow($mysqli);	

echo "<h4>Прирост постоянных гостей:</h4>";


foreach ($inFlow as $month) {
	echo $month['month'] . ' – ' . $month['clients'] . '<br>';
}
echo "<br>";

$numbers = $monitor->getGuestRatio($mysqli);


echo "<h4>Месячная стата</h4>";
echo "Месяц: Процент чеков, пробитых по зареганным картам<br><br>";
echo "Низкий / Средний / Высокий – уровень лояльности<br>";
echo "–––––––<br>";	

foreach ($numbers as $month => $clients) {
	if ($clients['registred'] != 0 || $clients['not'] != 0) {
		$loyalityStat = $clients['loyalityLevel'];
		echo date("F", mktime(0, 0, 0, $month, 1, 2015)) . ": " . number_format(($clients['registred'] / ($clients['not'] + $clients['registred']))*100, 2) . "%<br>";
		echo "<br>";
		$total = array_sum($loyalityStat);
		echo number_format($loyalityStat['low']/$total * 100, 2) . "% / " . number_format($loyalityStat['average']/$total * 100, 2) . "% / " . number_format($loyalityStat['huge']/$total * 100, 2) . "%<br>";
		echo "–––––––<br>";	
	}

}



echo "<b>" . $monitor->getAverageClientLife($mysqli) . " дней</b>  – средняя продолжительность жизни нашего клиента. C:";
echo "<br>";

?>
<pre>

</pre>