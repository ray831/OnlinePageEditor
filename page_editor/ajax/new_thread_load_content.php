<?php

include_once('../libraries/PageReader.php');

include_once('../../inc/check.php');

if( !isset($_POST['pgname']) ){
	echo "pgname is not set! Load data failed!";
	exit;
}

$pr = new PageReader($_POST['pgname'], @$_POST['version']);


if( !is_array($_POST['types']) ){
	echo $pr->load($_POST['types'], $_POST['loadFrom']);
}
else{
	echo json_encode($pr->loadAll($_POST['types'], $_POST['loadFrom']));
}


?>