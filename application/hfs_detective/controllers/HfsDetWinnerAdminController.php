<?php
Yii::import('sa_ext.kui.KuiData');
class HfsDetWinnerAdminController extends AdminController
{
    public function actionIndex()
    {
        $model = new HfsDetWinner();
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
        $model = new HfsDetWinner();
        $kuiData = new KuiData();
        $this->renderPartial('kuiData', array('model' => $model,'kuiData' => $kuiData));
    }
    /**
     * 导出excel数据
     *
     */
    public function actionGetExcelFile()
    {
        $model = new HfsDetWinner();
        $model->unsetAttributes();
        if (isset($_GET[get_class($model)])) {
            $model->_attributes = $_GET[get_class($model)];
        }
        $this->renderPartial('excel', array('model'=>$model,));
    }
    public function loadModel($id)
    {
        $model = HfsDetWinner::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
