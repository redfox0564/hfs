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
        <div class="content">
            <h1 class="schedule-four">第四季</h1>
            <h2 class="title">《<?php echo $answer;?>》</h2>
            <div class="main">
                <ul>
                    <li class="hc">
                        <h2>实力音乐侦探</h2>
                        <?php
                        	if (is_array($winners) && !empty($winners)){
                        		foreach ($winners as $type => $winner){
                        			if ($type === '实力音乐侦探'){
										foreach ($winner as $win){
											echo '<p>用户名：'.$win.'</p>';
										}
						}
                        		}
                        	}
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </body>
</html>
