<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script>
        var STATIC_URL = "<?php echo Yii::app()->params['static_url'];?>";
        var SINA_PASS  = "<?php echo Yii::app()->params['is_sina_pass'];?>";
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php 
        //注册外部js或者css文件
        $cs=Yii::app()->clientScript;
        //  Jacascript
        $cs->registerScriptFile(Yii::app()->params['admin_static_url'].'/js/jquery-1.8.3.min.js?version='.Yii::app()->params['version']);
        $cs->registerScriptFile(Yii::app()->params['admin_static_url'].'/js/doT-min.js?version='.Yii::app()->params['version']);

    ?>
    <!--[if lte IE 6]>
    <link href="<?php echo Yii::app()->params['admin_static_url'];?>/css/ie6.css?version=<?php echo Yii::app()->params['version'];?>" rel="stylesheet" type="text/css" />
    <![endif]-->
    
    <style>
    </style>    
</head>
<body>
    
    <?php echo $content; // 这里输出模版内容 ?>
    
<style>
.c-layer{position:fixed;top:0;right:0;left:0;bottom:0;width:100%;height:100%;background:#000;filter:alpha(opacity=50);opacity: 0.5;z-index:10;}
</style>
</body>
</html>
