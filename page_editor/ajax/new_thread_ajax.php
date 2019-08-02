<?php

include_once('../../inc/check.php');

include_once('../libraries/PageInfo.php');

if(!isset($_POST['oper'])) exit;



switch($_POST['oper'])
{
    case "check_file_exist":
        goto CHECK_FILE_EXIST;
    case "qry_page_name":
        goto QRY_PAGE_NAME;
    case "qry_page_version":
        goto QRY_PAGE_VERSION;
    default:
        exit;
}

CHECK_FILE_EXIST:
$pi = new PageInfo(@$_POST['pgn']);
echo $pi->isPageExistInTemp() ? 1 : "";
exit;


QRY_PAGE_NAME:
$files = PageInfo::getAllPagesInTemp();

$files = array_convert_encoding($files, "BIG5", "UTF-8");
$data = array();
foreach( $files as $file )
{
    array_push( $data, 
        array(
            "id" => $file,
            "text" => $file
        )
    );
}
echo json_encode($data);
exit;


QRY_PAGE_VERSION:
$pi = new PageInfo($_POST['pgn']);
$files = $pi->getAllVersion();

$files = array_convert_encoding($files, "BIG5", "UTF-8");
$data = array();
foreach( $files as $file )
{
    array_push( $data, 
        array(
            "text" => $file,
            "value" => $file
        )
    );
}
echo json_encode($data);
exit;


?>