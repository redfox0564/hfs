<?php
Yii::import('sa_ext.kui.KuiData');
class LinkLogAdminController extends AdminController
{
    public function actionIndex()
    {
        $model = new LinkLog();
        $model->unsetAttributes();
        if (isset($_GET[get_class($model)])) {
            $model->_attributes = $_GET[get_class($model)];
        }
        $this->render('index', array('model' => $model));
    }
    public function actionAjaxDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $id = explode(',',$id);
        	if(is_array($id) && count($id)> 0){
        		foreach ($id as $k => $v)
        			$this->loadModel($v)->delete();
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
        $model = new LinkLog();
        $kuiData = new KuiData();
        $this->renderPartial('kuiData', array('model' => $model,'kuiData' => $kuiData));
    }
    /**
     * 导出excel数据
     *
     */
    public function actionGetExcelFile()
    {
        $model = new LinkLog();
        $model->unsetAttributes();
        if (isset($_GET[get_class($model)])) {
            $model->_attributes = $_GET[get_class($model)];
        }
        $this->renderPartial('excel', array('model'=>$model,));
    }
    public function loadModel($id)
    {
        $model = LinkLog::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
