<?php
// 解决IE下iframe无法读取COOKIE的问题
header('P3P: CP=CAO PSA OUR');
error_reporting(0);
ini_set('date.timezone','Asia/Shanghai');
// 系统引导文件
$yii=dirname(__FILE__).'/../../library/shiquTech/bootstrap.php';

// 是否开启调试功能
defined('YII_DEBUG') or define('YII_DEBUG', false);
// Yii跟踪级别
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//设置项目名称
defined('SA_PROJECT_NAME') or define('SA_PROJECT_NAME', substr(realpath(dirname(__FILE__)), strrpos(realpath(dirname(__FILE__)), DIRECTORY_SEPARATOR)+1));

require_once($yii);
$config=SA_PROJECT.'/config/main.php';
Yii::createWebApplication($config)->run();
