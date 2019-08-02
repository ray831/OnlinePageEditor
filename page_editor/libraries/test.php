<?php
//include_once('TemplateManager.php');

include_once('PageInfo.php');
//include_once( dirname(__DIR__).'/config.php' );

$arr = PageInfo::getAllPagesInPublic();

var_dump($arr);

