<?php
include_once('../../inc/check.php');

if( !isset($_POST['pgname']) || !isset($_POST['oper']) ){
	echo "Failed!";
	exit;
}


include_once('../libraries/TemplateManager.php');
include_once('../libraries/PageWriter.php');
include_once('../libraries/PageReader.php');

$pw = new PageWriter($_POST['pgname'], "");


switch($_POST['oper'])
{
    case "create":
        goto CREATE;
    case "edit":
        goto EDIT;
    default:
        //exit;
}

CREATE:
$tm = new TemplateManager($_POST['tpname']);

$contents = $tm->loadAll();

$pw->saveAll($contents, "temp");
$pw->saveAll($contents, "public");

exit;

EDIT:
$pr = new PageReader($_POST['pgname'], "");

$contents = $pr->loadAll(array('htm','js','ss'), 'public');

$pw->backUpPublicPage();

$msg = $pw->saveAll($contents, 'temp');

//print_r($msg);

exit;

?>