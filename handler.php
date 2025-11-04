<?php



$verification_year = $_POST['Year'];
$org_title = $_POST['Organisation'];
$miDOTmitnumber = $_POST['Regnom'];
$miDOTmititle = $_POST['TypeSiName'];
$miDOTmitype = $_POST['TypeSi'];
$miDOTmodification = $_POST['ModificationSi'];
$verification_dateOT = $_POST['PoverkaDateOt'];
$verification_dateDO = $_POST['PoverkaDateDo'];

$result = '{|verification_year|: |'.$verification_year.'|, |org_title|: |'.$org_title.'|, |mi.mititle|: |'.$miDOTmititle.'|, |mi.mitnumber|: |'.$miDOTmitnumber.'|, |mi.mitype|: |'.$miDOTmitype.'|, |mi.modification|: |'.$miDOTmodification.'|';

//$vdates  = '['.$verification_dateOT.'T00:00:00Z TO '.$verification_dateDO.'T23:59:59Z]';

if ($verification_dateOT=="" and $verification_dateDO == "")
	$vdates = "";
else 
	if ($verification_dateOT=="")
		$vdates = "[* TO ".$verification_dateDO."T23:59:59Z]"; // "[*%20TO%202024-09-11T23:59:59Z]"
	else 
		if ($verification_dateDO=="")
			$vdates = "[".$verification_dateOT."T00:00:00Z TO *]"; //[2024-09-03T00:00:00Z%20TO%20*]
		else 
			$vdates  = '['.$verification_dateOT.'T00:00:00Z TO '.$verification_dateDO.'T23:59:59Z]';


$result = $result.',|verification_date|: |'.$vdates.'|}';

$result = str_replace('"', '^', $result);

//echo $result;



$s = 'python3 main.py "'.strval($result).'" 2>&1';
//$s = 'python3 main.py "'.strval($result).'" > /dev/null 2>&1 & echo $!; ';
$last_line = exec( $s , $return_var);
//echo $last_line;


// удалить из файла pidlogparams
/*
$pidsjournal = 'pidlogargs.txt';
$listfromfile = array();
$listfromfile = file($file) or die('Не открывается');

foreach ($listfromfile as &$lst) 
	{
	if(strpos($lst, 'pid')==false)
	
	}
*/
?>
