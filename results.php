<?php

echo '<a href=http://arshin.***.ru/> Back </a><br>';
$sorttype = 'date';
$sorttype = $_GET['sort'] ;

$files = glob("results/*.xlsx");
$result = [];
$i = 0;
foreach ($files as $filename) {
    $result[$i]['name'] = str_replace("results/","",$filename);
	$result[$i]['size'] = filesize($filename);
	$result[$i]['date'] = filemtime($filename);
	$result[$i]['hdate'] = date('d.m.Y H:i:s', filemtime($filename));
	$i = $i + 1;
}

array_multisort(array_column($result, $sorttype), SORT_ASC, $result);
echo '<font size="1" face="Arial" >';
echo '<br>';
echo '
	<table >
		<tr>
			<td align="center">
				<a href=results.php?sort=name> Filename </a>
			</td>
			<td align="center">
				Size
			</td>
			<td align="center">
				<a href=results.php?sort=date> Date </a>
				
			</td>
		</tr>
		
';

foreach ($result as $res) {
	echo "<tr>";
		echo "<td>";
			echo '<a href=results/'.$res['name'].'>'.$res['name'].'</a>';	
		echo "</td>";	
		echo "<td>";
			echo $res['size'];	
		echo "</td>";
		echo "<td>";
			echo $res['hdate'];
			echo "&nbsp&nbsp";
		echo "</td>";
		echo "<td>";
			echo '<a href=removefile.php?filetoremove='.$res['name'].'>Remove file</a>';	
		echo "</td>";
	echo "</tr>";
	
}
	
echo "
	</table>
";
	



/*


echo "<br>=======================================<br>";
$i = 0;
foreach ($result as $res) {

	echo $res['name']." - ".$res['size']." - ".$res['date']." - ".$res['hdate'];
	echo "<br>";
	$i = $i + 1;
}
*/
?>
