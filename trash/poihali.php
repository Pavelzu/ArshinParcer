<?php
$a =  $_POST['trgt'];
echo $a;
//#exec("sudo su");
$s = "python3 main.py ".strval($a);
//$s = "python3 f.py ".strval($a);
//$s = "python3 main.py pipisa 2>&1";
//echo $s;
$pylanch = exec($s);

//echo $pylanch;

//echo phpinfo();
?>
