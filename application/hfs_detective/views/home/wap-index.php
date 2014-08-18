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
			$cs->registerCssFile(Yii::app()->params['static_url'].'/css/index.css?version='.Yii::app()->params['version']);
			$cs->registerCssFile(Yii::app()->params['static_url'].'/css/dialog.css?version='.Yii::app()->params['version']);
		?>
        <script>
            var date = +new Date;
			var hfs_data = <?php echo json_encode($clues);?>;
			var ans = <?php echo '"'.$answer.'"';?>;
        </script>
    </head>
    <body>
        <div class="hfs page">
	<header class="header">
                <a class="past">往季真相>></a>
            </header>	
            <div class="content">
                <section class="text-desc">
                    <p>人人都有做侦探的潜质，只有真正的实力</p>
                    <p>派才能打破迷局。看线索，猜歌名，赢取大</p>
                    <p>礼！谁的青春高八度？够实力，你就来！</p>
                </section>
                <section class="prizes">
                    <ul>  
                        <li>
                            <div class="pic"> 
                                <img src="<?php echo Yii::app()->params['static_url']?>/images/001.png?_v<?php echo Yii::app()->params['version'];?>" />
                            </div>
                            <div class="name">
                                <span>海飞丝洗发产品</span>
                            </div>
                        </li>
                        <li>
                            <div class="pic"> 
                                <img src="<?php echo Yii::app()->params['static_url']?>/images/001.png?_v<?php echo Yii::app()->params['version'];?>" />
                            </div>
                            <div class="name">
                                <span>蔡依林音乐CD</span>
                            </div>
                        </li>
                        <li>
                            <div class="pic"> 
                                <img src="<?php echo Yii::app()->params['static_url']?>/images/001.png?_v<?php echo Yii::app()->params['version'];?>" />
                            </div>
                            <div class="name">
                                <span>iPhone专用音箱底座</span>
                            </div>
                        </li>
                    </ul>
                </section>
                <section class="buttons">
                    <span class="btn">
                        马上开始
                        <span class="search-icon"></span>
                    </span>
                </section>
                <section class="links">
                    <a href="/hfs_detective/index.php?r=home/tutorial&source=local" class="link">活动说明 ></a>
                </section>
            </div>
        </div>
        <div class="mask"></div>
        <div class="loading">
            <h3>小海正在帮您打造自信秀发，<br/>
                您即将闪亮登场……</h3>
            <div class="loader"><div>0%</div></div>
            <p>独家破案秘籍：活动的曲目都选自海飞丝冠名音乐剧<我的青春高八度>呦，一般人儿小海不告诉TA~</p>
        </div>


        <div class="play page" id="play" style="display:none;">
        <div class="header">
                <a class="back" href="/hfs_detective/index.php?r=home/wapIndex&amp;source=local">返回首页</a>
            </div>    
	<h1 class="schedule-one">第一季</h1>
            <h2>拨开云雾寻找答案</h2>
            <div class="play_container">
                <div class="play_cloud"></div>
                <div class="play_board"></div>
                <div class="play_timer">
                    <h3>距离下一条线索还有</h3>
                    <div class="play_timers">
                        <span></span>
                        :
                        <span></span>
                        :
                        <span></span>
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
                    <p class="state"></p>
                </li>
                <li data-index="1">
                    <p>
                        <a>线索2</a>
                    </p>
                    <p class="state"></p>
                </li>
                <li data-index="2">
                    <p>
                        <a>线索3</a>
                    </p>
                    <p class="state"></p>
                </li>
            </ul>
        </div>
		<?php
			$cs->registerScriptFile(Yii::app()->params['static_url'].'/js/zepto.js?version='.Yii::app()->params['version']);
			$cs->registerScriptFile(Yii::app()->params['static_url'].'/js/play.js?version='.Yii::app()->params['version']);
			$cs->registerScriptFile(Yii::app()->params['static_url'].'/js/dialog.js?version='.Yii::app()->params['version']);
			$cs->registerScriptFile(Yii::app()->params['static_url'].'/js/ctrl.js?version='.Yii::app()->params['version']);
			$cs->registerScriptFile(Yii::app()->params['static_url'].'/js/doT.js?version='.Yii::app()->params['version']);
		?>
        <script>
             var shareData = {
                img_url: "",
                img_width: 200,
                img_height: 200,
                link: '阿迪飞洒的说法',
                desc: '',
                title: '是发顺丰发的撒手 ',
                appid: 0
            };
	    window.wxcallback = function(){
			//跳�到表单页面
		window.location.href ="/hfs_detective/index.php?r=home/userinfo"	
	    }

	    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideToolbar');
            });
            window.PRELOAD_RES =[
                STATIC_URL+"/images/play-cloud.png?41",
                STATIC_URL+"/images/bg.png?41",
                STATIC_URL+"/images/play-music.png?41"
            ];

            //首页加载时间
            (function($){
                var mask = $('.mask'),
                        loading = $('.loading'),
                        loadtext = loading.find('.loader div'),
                        page = $('.hfs'),
                        play = $('#play');

                $('.buttons').on('click',function(){
                    //预加载资源
                    if ( window.PRELOAD_RES && PRELOAD_RES.length ) {
                        var total = PRELOAD_RES.length,
                                per  = 1/ total,cloud,
                                step = 0,timer,
                                progress =0;

                        loading.show();
                        mask.show();

                        PRELOAD_RES.forEach(function(item){
                            var image = new Image;
                            image.onload = function(){
                                if (!cloud && item.match(/cloud/) ){
                                    cloud = image;
                                }
                                progress = per* ++step;
                            };
                            image.src = item;
                        });
                        //假的加载进度
                        timer = setInterval(function(){

                            if (progress<per*(step+1)){
                                progress+=(Math.random()*(10-1) +1)/100
                            }

                            loadtext.html(parseInt(Math.max(100,progress*100),10)+'%');
                            if ( progress>=1 ) {
                                mask.hide();
                                loading.hide();
                                page.hide();
                                play.show();
                                clearInterval(timer);
                                new $.Cloud(cloud);
                            }
                        },13)
                    }
                });


            })(Zepto)

        </script>
    <body>
</html>
