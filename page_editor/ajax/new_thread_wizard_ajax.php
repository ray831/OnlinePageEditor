<?php
include_once('../../inc/check.php');

include_once('../libraries/PageInfo.php');

include_once('../libraries/TemplateManager.php');

if( !isset($_POST['oper']) ) exit;

switch($_POST['oper'])
{
    case "check_file_exist":
        goto CHECK_FILE_EXIST;
    case "qry_page_name":
        goto QRY_PAGE_NAME;
    case "qry_template":
        goto QRY_TEMPLATE;
    case "req_template_content":
        goto REQ_TEMPLATE_CONTENT;
    default:
        //exit;
}

CHECK_FILE_EXIST:
$pi = new PageInfo(@$_POST['pgn']);
echo $pi->isPageExistInPublic() ? 1 : "";
exit;

QRY_PAGE_NAME:
$files = PageInfo::getAllPagesInPublic();

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

QRY_TEMPLATE:
$files = TemplateManager::getAllTemplateName();

$files = array_convert_encoding($files, "BIG5", "UTF-8");
echo json_encode($files);
exit;

REQ_TEMPLATE_CONTENT:
$tm = new TemplateManager($_POST['tpname']);
echo json_encode($tm->load('htm'));
exit;
?>