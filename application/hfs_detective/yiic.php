<?php
//设置项目名称
defined('SA_PROJECT_NAME') or define('SA_PROJECT_NAME', substr(realpath(dirname(__FILE__)), strrpos(realpath(dirname(__FILE__)), DIRECTORY_SEPARATOR)+1));

// 系统引导文件
require_once(dirname(__FILE__).'/../../library/shiquTech/bootstrap.php');

$yiic=dirname(__FILE__).'/../../library/yiiframework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';

require_once($yiic);
