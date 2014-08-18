<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['admin_static_url'];?>/css/style.css?version=<?php echo Yii::app()->params['version'];?>" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['admin_static_url'];?>/jui/themes/base/jquery.ui.all.css?version=<?php echo Yii::app()->params['version'];?>" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['admin_static_url'];?>/jui/themes/base/jquery-ui.css?version=<?php echo Yii::app()->params['version'];?>" />
<style type="text/css">
/*<![CDATA[*/
ul li{height:35px}
ul li label{width:70px;display:inline-block}
ul li input{margin-left:35px;}
.login_sub{margin-left:240px}
/*]]>*/
</style>
<title><?php echo Yii::app()->name;?>项目管理后台</title>
</head>
<body>
<div style="margin: 150px auto;width: 320px;">
<div>
<h1><?php echo Yii::app()->name;?>项目管理后台</h1>
</div>
<div class="ui-widget ui-widget-content ui-corner-all" style="padding: 30px;width: 310px;">
    <div style="background: none; border: 0;" class="ui-dialog-content ui-widget-content">
    <form name="login_form" action="" method="post">
        <ul>
            <li>
                <label for="userId">管理员ID:</label>
                <input type="text" id="userId" name="userId" value="">
            </li>
            <li>
                <label for="password">密码:</label>
                <input type="password" id="password" name="password" value="">
            </li>
        </ul>
        <input type="submit" value="登录" class="button ui-button ui-widget ui-state-default ui-corner-all login_sub" role="button">
        <div class="ui-widget" style="margin-top:5px;<?php echo $error? '': 'display:none'?>">
          <div class="ui-state-highlight ui-corner-all">
            <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
            <strong>Hey!</strong> 信息错误！</p>
          </div>
        </div>
    </form>
    </div>
</div>
</div>
</body>
</html>