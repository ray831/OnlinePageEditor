<?php

include_once('../libraries/PageWriter.php');

include_once('../../inc/check.php');

if( !isset($_POST['pgname']) ){
	echo "pgname is not set! Save data failed!";
	exit;
}

$pw = new PageWriter($_POST['pgname'], @$_POST['version']);


if( !isset($_POST['contents']) ){
	$msg = $pw->save($_POST['content'], 
					 $_POST['type'], 
					 $_POST['saveTo'] );
	echo($msg);
}
else{
	$msg = $pw->saveAll( json_decode($_POST['contents'], true), 
						 $_POST['saveTo'] );
	echo json_encode($msg);
}



?>