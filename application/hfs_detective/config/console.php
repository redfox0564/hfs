<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$config	= array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'default',
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	
	'language'=>'zh_cn',
		
	// 扩展参数 调用方式:Yii::app()->params[key]
	'params'=>array(
	),
);

if (strstr($_SERVER['SERVER_ADDR'], '172.16.0.') || strstr($_SERVER['SERVER_ADDR'], '127.0.0.')) {
    $database    = @include_once(dirname(__FILE__).'/database-local.php');
}else{
    $database    = @include_once(dirname(__FILE__).'/database.php');
}
if(!empty($database))
{
	if (isset($config['components']))
	{
		$config['components'] = @array_merge($config['components'], $database);
	}
	else 
	{
		$config['components'] = $database;
	}
}

return $config;