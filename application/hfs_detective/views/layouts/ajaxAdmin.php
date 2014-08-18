<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<?php 
//注册外部js或者css文件
$cs=Yii::app()->getClientScript();
$cs->setCoreScriptUrl(Yii::app()->params['admin_static_url'].'/js/jdefault');
$cs->registerCssFile(Yii::app()->params['admin_static_url'].'/css/style.css?version='.Yii::app()->params['version']);
$cs->registerCssFile(Yii::app()->params['admin_static_url'].'/css/detailview/styles.css?version='.Yii::app()->params['version']);
$cs->registerScriptFile(Yii::app()->params['admin_static_url'].'/js/jdefault/jquery.min.js?version='.Yii::app()->params['version']);
?>
<!--[if lte IE 6]>
<link href="css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>
<?php echo $content; // 这里输出模版内容 ?> 
</body>
</html>