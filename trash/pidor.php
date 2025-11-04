<?php


$s =  'df -h > /dev/null 2>&1 & echo $!; ';
$pid = exec( $s , $return_var);
echo ($pid);

?>
