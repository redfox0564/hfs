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
?>
<!--[if lte IE 6]>
<link href="css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<style>
.chead {height:50px;margin:20px 50px 0 50px;}
.cleft {width:160px;height:300px;padding-left:20px;}
.cright {margin-left:185px;margin-top:-300px;height:600px}
</style>
</head>
<body>
<div class="chead"><h1>后台</h1></div>
<hr>
<div>
    <div class="cleft">
<?php
$menuList   = isset(Yii::app()->params['menuList']) ?
                    Yii::app()->params['menuList'] : array();
$this->widget('sa_ext.kui.CKuiPanelBarNew', array(
    'id'=>'CKuiPanelBar',
    'htmlOptions'=>array(
        'style'=>'width:150px',
    ),
    'options'=>array(
        'dataSource' => $menuList, 
    ),
));
?>
    </div>
    <div class="cright">
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', array(
            'htmlOptions'=>array('class'=>'location'),
            'homeLink'=>'您现在的位置：',
            'links'=>$this->breadcrumbs,
        ));
        ?>
        <br />

        <div class="container">
        <?php echo $content; // 这里输出模版内容 ?> 
        </div>
    </div>
</div>
</body>
</html>
