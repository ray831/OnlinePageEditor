<?php
	if(!isset($_GET['pgn'])){
        header("Location: new_thread_wizard.php"); 
        exit;
    }
	
	if(preg_match("/^\w+$/", $_GET['pgn']) !== 1){
		echo 'Only accept alphanumeric string.';
		exit;
	}

	$_GET['pgn'] = htmlspecialchars($_GET['pgn'], ENT_QUOTES);
	if(!file_exists($_GET['pgn'].'.php')
	&& !file_exists("page_editor/temp/".$_GET['pgn'])){
		header("Location: new_thread_wizard.php"); 
        exit;
	}
	
	clearstatcache();
?>