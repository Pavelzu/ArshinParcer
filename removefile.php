<?php
$name = $_GET['filetoremove'] ;
unlink('results/'.$name);
//sleep(4);
header('Location: http://arshin.corp.exd.ru/results.php?sort=date');


?>