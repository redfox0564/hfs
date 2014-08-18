<?php
class SettingsAdminController extends AdminController {
    
    public function actionIndex(){
        $settings = Yii::app()->settings->get('site');

        if(isset($_POST['Settings'])){
            $data = $_POST['Settings'];
            Yii::app()->settings->set('site', $_POST['Settings']);
            $files = $this->uploadFiles($_FILES['SettingsFile']);
            Yii::app()->settings->set('site', $files);
            $this->refresh();
        }

        $this->render('index', array(
            'settings'=>$settings
        ));
    }

    private function uploadFiles($files){
        $count = count($files['name']);

        $ids = array();
        foreach($files['tmp_name'] as $name=>$tmpName){
            if(!empty($tmpName)){
                $id = $this->upload($tmpName);
                if($id) $ids[$name]="{$id}";
            }
        }
        return $ids;
    }

    private function upload($file){
        $fileName = uniqid('file-');
        $newpicid = 0;
        $res = ImageManage::putImage($newpicid, $file, $fileName);
        if($newpicid) return $newpicid;
        return 0;
    }

    public function actionImageUrl(){
        $id = Yii::app()->getquery('id');
        $width = 50;
        $height= 50;
        //Yii::app()->imageUrl($id, $width, $height);
        $url = Yii::app()->getImage($id, $width, $height);
        $this->redirect($url);
    }

}
