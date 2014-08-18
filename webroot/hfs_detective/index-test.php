<?php
ini_set('display_errors', 'On');
ini_set('date.timezone','Asia/Shanghai');
// 系统引导文件
$yii=dirname(__FILE__).'/../../library/shiquTech/bootstrap.php';
// 是否开启调试功能
defined('YII_DEBUG') or define('YII_DEBUG',true);
// Yii跟踪级别
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//设置项目名称
defined('SA_PROJECT_NAME') or define('SA_PROJECT_NAME', substr(realpath(dirname(__FILE__)), strrpos(realpath(dirname(__FILE__)), DIRECTORY_SEPARATOR)+1));

require_once($yii);
$config=SA_PROJECT.'/config/main.php';
$app = Yii::createWebApplication($config);
//log组件加载
$components = array(
    'log' => array (
        'class'  => 'CLogRouter',
        'routes' => array (
            array (
                'class'  => 'CFileLogRoute',
                'levels' => 'error, warning',
            ),
            //uncomment the following to show log messages on web pages
            array (
                'class'  => 'CWebLogRoute',
            ),
        ),
    ), 
);
$app->setComponents($components);
$app->getComponent('log'); //log组件加载
//log组件加载结束
$app->run();
