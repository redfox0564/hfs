<?php $this->layout = false;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>APP错误</title>
<style>
/* 公共样式 */
body,ul,ol,li,p,h1,h2,h3,h4,h5,h6,form,label,dl,dt,dd,fieldset {margin:0;padding:0;}
body,fieldset,th,td,select,input,textarea {font-size:12px;font-family:Arial, "微软雅黑", "宋体", sans-serif; color:#666;}

a:link,a:visited,a:active {text-decoration:none; color:#999;}
a:hover {text-decoration:none; color:#488fce;}

/*框架*/
.u_box {width:600px; height:500px; background:#eaeaec; overflow:hidden; margin:0 auto;}
.u_box .box {border:1px solid #d6d6d7; border-bottom:2px solid #d6d6d7; border-top:none; height:430px; padding:10px; margin:10px; background:#fff;} 

/*错误页*/
.error {display:block; width:500px; height:50px; line-height:50px; background:#ffe9ad 80px center no-repeat; border:1px solid #fab418; font-size:16px; text-align:center; margin:100px auto 10px;}
.err_a {line-height:30px; text-align:center;}
.err_a a {color:#488fce; margin:0 6px; text-decoration:underline;}
</style>
</head>
<body>
    <div class="u_box">
        <div class="container">
            <div class="box">
            <p class="error"><?php echo CHtml::encode($message); ?>(错误码：<?php  echo $code; ?>)</p>
            <p class="err_a"><?php echo CHtml::link('返回首页', $this->createUrl('index'))?></p>
          </div>
        </div>
    <div>
</body>
</html>