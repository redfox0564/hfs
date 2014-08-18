<!DOCTYPE html>
<html>
<head>
    <title>海飞丝实力音乐侦探</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0"/>
    <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.5, user-scalable=yes">

    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-touch-fullscreen" content="no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="format-detection" content="telephone=no"/>
	<?php
		$cs = Yii::app()->clientScript;
		$cs->registerCssFile(Yii::app()->params['static_url'].'/css/base.css?version='.Yii::app()->params['version']);
		$cs->registerCssFile(Yii::app()->params['static_url'].'/css/play.css?version='.Yii::app()->params['version']);
	?>
</head>
<body>

<script>
    var date = +new Date;
	var hfs_data = <?php echo $clues;?>;
</script>
<div class="page play">

    <h1 class="schedule-one">第一季</h1>
    <h2>拨开云雾寻找答案</h2>
    <div class="play_container">
        <div class="play_cloud"></div>

        <div class="play_board"></div>

        <div class="play_timer">
            <h3>距离下一条线索还有</h3>
            <div class="play_timers">
                <span>
                    <b>3</b><b>3</b>
                </span>
                :
                <span>
                    <b>3</b><b>2</b>
                </span>
                :
                <span>
                    <b>2</b><b>2</b>
                </span>
            </div>
        </div>
        <div class="play_button">
            <a class="real">写出真相</a>
        </div>
    </div>

    <ul class="play_tab">
        <li class="cur" data-index="0">
            <p>
                <a>线索1</a>
            </p>
            <p class="state">（解锁）</p>
        </li>
        <li data-index="1">
            <p>
                <a>线索2</a>
            </p>
            <p class="state">（解锁）</p>
        </li>
        <li data-index="2">
            <p>
                <a>线索3</a>
            </p>
            <p class="state">（解锁）</p>
        </li>
    </ul>

    <?php
		$cs->registerScriptFile(Yii::app()->params['static_url'].'/js/zepto.js?version='.Yii::app()->params['version']);
		$cs->registerScriptFile(Yii::app()->params['static_url'].'/js/play.js?version='.Yii::app()->params['version']);
	?>
    <script>
        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
            WeixinJSBridge.call('hideToolbar');
        });
    </script>
</div>
<body>
