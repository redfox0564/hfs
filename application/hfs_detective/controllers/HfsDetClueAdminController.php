<?php
Yii::import('sa_ext.kui.KuiData');
class HfsDetClueAdminController extends AdminController
{
    public function actionIndex()
    {
        $model = new HfsDetClue();
        $model->unsetAttributes();
        if (isset($_GET[get_class($model)])) {
            $model->_attributes = $_GET[get_class($model)];
        }
        $this->render('index', array('model' => $model));
    }
    public function actionView($id) {
        $this->layout = '//layouts/ajaxAdmin';
        $this->render('view',array('model'=>$this->loadModel($id)));
    }
    public function actionCreate() {
        $this->layout = '//layouts/ajaxAdmin';
        $model = new HfsDetClue();
        if (isset($_POST[get_class($model)])) {
            $model->attributes = $_POST[get_class($model)];
            if ($model->save()) {
                $this->redirect(array('view','id'=>$model->primaryKey));
            }
        }
        $this->render('create',array('model'=>$model,));
    }
    public function actionUpdate($id) {
        $this->layout = '//layouts/ajaxAdmin';
        $model = $this->loadModel($id);
        if (isset($_POST[get_class($model)])) {
            $model->attributes = $_POST[get_class($model)];
            if ($model->save()) {
                $this->redirect(array('Update', 'id'=>$id));
            }
        }
        $this->render('update', array('model'=>$model,));
    }
    public function actionAjaxDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $id = explode(',',$id);
        	if(is_array($id) && count($id)> 0){
        		foreach ($id as $k => $v) {
                    $model = $this->loadModel($v);
                    $model->is_del = 'Y';
                    $model->save();
                }
        			//$this->loadModel($v)->delete();
        	}
        } else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }
    /**
     * CKuiGridNew 数据
     */
    public function actionKuiGridData()
    {
        $model = new HfsDetClue();
        $kuiData = new KuiData();
        $this->renderPartial('kuiData', array('model' => $model,'kuiData' => $kuiData));
    }
    /**
     * 导出excel数据
     *
     */
    public function actionGetExcelFile()
    {
        $model = new HfsDetClue();
        $model->unsetAttributes();
        if (isset($_GET[get_class($model)])) {
            $model->_attributes = $_GET[get_class($model)];
        }
        $this->renderPartial('excel', array('model'=>$model,));
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
    
    public function loadModel($id)
    {
        $model = HfsDetClue::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
