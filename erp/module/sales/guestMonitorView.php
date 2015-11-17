<?php
global $mysqli;

$inFlow = $monitor->getMonthlyInflow($mysqli);	

echo "<h4>Прирост постоянных гостей:</h4>";


foreach ($inFlow as $month) {
	echo $month['month'] . ' – ' . $month['clients'] . '<br>';
}
echo "<br>";

$numbers = $monitor->getGuestRatio($mysqli);


echo "<h4>Процент чеков, пробитых по зареганным картам</h4>";
echo "Уровень лояльности:<br>";
echo "Низкий / Средний / Высокий – %<br>";

foreach ($numbers as $month => $clients) {
	if ($clients['registred'] != 0 || $clients['not'] != 0) {
		$loyalityStat = $clients['loyalityLevel'];
		echo date("F", mktime(0, 0, 0, $month, 1, 2015)) . ": " . ($clients['registred'] / ($clients['not'] + $clients['registred']))*100 . "%<br>";
		echo "<br>";
		$total = array_sum($loyalityStat);
		echo $loyalityStat['low']/$total * 100 . " " . $loyalityStat['average']/$total * 100 . " " . $loyalityStat['huge']/$total * 100 . "<br>";
		echo "–––––––<br>";	
	}

}



echo "<b>" . $monitor->getAverageClientLife($mysqli) . " дней</b>  – средняя продолжительность жизни нашего клиента. C:";
echo "<br>";
