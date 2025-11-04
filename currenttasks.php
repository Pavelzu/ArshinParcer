<?php

function translate($st)
{
   
  $st=strtr($st,array('org_title'=> 'Организация', 'verification_year'=> 'Год', 'mi.mititle'=> 'Наименование типа', 'mi.mitnumber'=> 'Регистрационный номер типа',
 'mi.mitype'=> 'Тип', 'mi.modification'=> "Модификация", 'verification_date'=> 'Дата'));
 
  return $st;
}

function getlogfilename($pid)
{
	//$file = fopen('./trash/pidlogargs.txt', 'r');
	$file = fopen('pidlogargs.txt', 'r');
	while (!feof($file)) 
	{
	$row = fgets($file);
	if (strcmp(mb_strstr($row, ' ', true), $pid)==0)
		{
		
		$rownopid = mb_strstr($row, ' ', false);
		$logfile = mb_substr($rownopid, 0, mb_strpos($rownopid, '{')-1);
		$logfile = str_replace(' ', '', $logfile);
		break;

		}
	}
	//echo($logfile);
 	fclose($file);
 	return $logfile;
}

function getsummury($logfile)
{
	//$file = fopen('./trash/logs/'.$logfile, 'r'); 
	$file = fopen('./logs/'.$logfile, 'r'); 
	while (!feof($file)) 
		{
		$row = fgets($file);
		if(strpos($row, 'Общее кол-во результатов')==false)
			continue;
		else
			{
			$array = explode(' ', $row);
			$sum = end($array);
			break;
			}
		
		
		}
	fclose($file);
 	return $sum;
}


function getcurrent($logfile)
{

	//$file = './trash/logs/'.$logfile;
	$file = './logs/'.$logfile;
	$s = 'tail -n 30 '.$file.' | grep -i карточку# 2>&1';
	$l = exec( $s , $out,$return_var);
	$array = explode(' ', end($out));
	$cur = end($array);
	if ($cur == NULL) $cur = 0;
	
 	return $cur;
}

$s = 'sudo ps -u www-data -o pid,args | grep python3 2>&1';
$last_line = exec( $s , $pslines);
#echo($s);


$pylines = array();

foreach ($pslines as &$st) 
	{
	$pos21 = strripos($st, "2>&1");
	$possh = strripos($st, "sh -c");
	$posgrep = strripos($st, "grep");
	$possel = strripos($st, "selenium");
	
    if ($pos21==false and $possh==false and $posgrep==false and $possel==false)
		$pylines[] = $st;	
		
	}



echo('<style>p {
  ;
 } .label{margin-left: 20px;}</style>');

echo('<table width="1500" border = 0 >');
foreach ($pylines as &$st)
	{
	echo('<tr>');
	$st = trim($st);
	$pid = stristr($st, ' ', true); 
	//echo("st= ".$st);
	//echo("pid= ".$pid);
	$params = mb_substr($st, mb_strpos($st, ' main.py ') + mb_strlen(' main.py ')); //на этом этапе только параметры переданные в python
	//$origparams = $params;
	$params = translate($params);
	$params = str_replace('|','"',$params);
	echo('<td>');
	$logfile = getlogfilename($pid);
	//echo($logfile);
	$common = getsummury($logfile);
	$current = getcurrent($logfile);
	//echo($current);
	//echo($common);
	echo('<form action="killer.php" method="POST">');
	echo('<input type=hidden name="pid" value='.$pid.'>');
	echo('<button type="submit">Завершить</button>');
	echo('<label class="label"> '.$current.' из '.$common);
	echo('<label class="label">'.$params.'</label>');
	echo('</form>');
	echo('</td>');
	echo('</tr>');
	}
echo('</table>');



?>