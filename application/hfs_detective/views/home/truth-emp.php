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
			$cs->registerCssFile(Yii::app()->params['static_url'].'/css/truth.css?version='.Yii::app()->params['version']);
		?>
    </head>
    <body>
    <div class="hfs page truth">
        <header class="header">
            <a class="back">返回首页</a>
        </header>
        <div class="content">
            <h2 class="emp">真相即将揭晓，敬请期待！</h2>
        </div>
    </div>
    <body>
</html>
