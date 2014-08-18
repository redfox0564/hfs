<!DOCTYPE html>
<html>
    <head>
        <title>海飞丝实力音乐侦探</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-touch-fullscreen" content="no"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <meta name="format-detection" content="telephone=no"/>
<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->params['static_url'].'/css/base.css?version='.Yii::app()->params['version']);
$cs->registerCssFile(Yii::app()->params['static_url'].'/css/dialog.css?version='.Yii::app()->params['version']);
$cs->registerCssFile(Yii::app()->params['static_url'].'/css/form.css?version='.Yii::app()->params['version']);
?>
</head>
<body>
<div class="hfs page form">
<div class="content">
<h2 class="title">
<p><em class="yellow">登记实力侦探信息</em>，本季小海将会抽选一</p>
<p>位幸运者送出<em class="yellow">奖品</em>，请持续关注海飞丝官</p>
<p>方微信呦！</p>
</h2>
<div class="main">
<div class="reg"> 
    <form name="reg">
	<div class="item"> 
	    <label for="nick">微信昵称</label>
	    <input type="text" name="nick" />
	</div>
	<div class="item">
	    <label for="mobile">手机号码</label>
	    <input type="text" name="mobile" />
	</div>
	<div class="item error">
	    <div class="msg"></div>
	</div>
	<div class="item buttons">
	    <a class="submit">提交</a>
	</div>
    </form>
</div>
</div>
</div>
</div>

 <?php
                        $cs->registerScriptFile(Yii::app()->params['static_url'].'/js/zepto.js?version='.Yii::app()->params['version']);
                        $cs->registerScriptFile(Yii::app()->params['static_url'].'/js/dialog.js?version='.Yii::app()->params['version']);
                        $cs->registerScriptFile(Yii::app()->params['static_url'].'/js/form.js?version='.Yii::app()->params['version']);
                ?>

    </body>
</html>
