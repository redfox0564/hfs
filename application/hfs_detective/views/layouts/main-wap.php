<!doctype html>
<html lang="en">
<head>
	<script>
        	var STATIC_URL = "<?php echo Yii::app()->params['static_url'];?>";
    	</script>
	<meta charset="UTF-8">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<title><?php echo CHtml::encode($this->pageTitle);?></title>
    <?php
        /**
         *  @静态文件注册
         *  @Author yanghongwei@social-touch.com
         *  @Date   2014/06/05 15:05
         *
         */
        $cs = Yii::app()->clientScript;
    ?>
</head>
<body>
        <?php
        /**
         *  @主题内容框体
         *  @Author yanghongwei@social-touch.com
         *  @Date   2014/06/05 15:12
         *
         */
        echo $content;
        ?>
</body>
</html>
