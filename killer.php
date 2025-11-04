<?php

$pid =  $_POST['pid'];
$s = 'kill -9 '.$pid.' 2>&1';
$result = exec( $s , $out);
header("Location: http://arshin.***.ru");


?>
