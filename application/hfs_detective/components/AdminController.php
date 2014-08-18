<?php
Yii::import('sa_ext.fun.JYii');
class AdminController extends Controller
{
    public $layout='//layouts/admin';
    public $breadcrumbs = '';
    
    public function filters()
    {
        return array(
            'accessControl', 
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'expression'=>'$user->isAdmin()',
            ),
            
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    //后台图片上传
    public function actionImageUpload()
    {
        $error = "";
        if(!empty($_FILES['fileToUpload']['error']))
        {
            JYii::endJsonMsg(2, '上传文件失败！');
        }elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
        {
            JYii::endJsonMsg(2, '上传文件失败！');
        }else 
        {
            $filetype = substr($_FILES['fileToUpload']["name"],strrpos($_FILES['fileToUpload']["name"],'.'));
            $filetype = strtolower($filetype);
            $allowFileType = array('.jpg','.gif','.png','.bmp');//上传文件类型
            if(!in_array($filetype,$allowFileType)){
                $msg = '文件类型不正确!请上传'.join('|',$allowFileType).'格式文件';
                JYii::endJsonMsg(2, $msg);
            }
            $newpicid = 0;
            if($_FILES['fileToUpload']['tmp_name']){
                $file = $_FILES['fileToUpload']['tmp_name'];
                $fileName = $_FILES['fileToUpload']['name'];
                $res = ImageManage::putImage($newpicid, $file, $fileName);
            }
            @unlink($_FILES['fileToUpload']);
            $pic_id = $newpicid ? $newpicid : '';
            if($pic_id){
                $src = $newpicid ?  ImageManage::image_url($newpicid,50,50) : '';
                JYii::endJsonMsg(1, '上传文件成功！',array('pic_id'=>$pic_id,'src'=>$src));
            }else{
                JYii::endJsonMsg(2, '上传文件失败！');
            }
        }
    }
}
