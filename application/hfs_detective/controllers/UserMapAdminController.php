<?php
Yii::import('sa_ext.kui.KuiData');
class UserMapAdminController extends AdminController
{
    public function actionIndex()
    {
        $model = new UserMap();
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
        $model = new UserMap();
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
        $model = new UserMap();
        $kuiData = new KuiData();
        $this->renderPartial('kuiData', array('model' => $model,'kuiData' => $kuiData));
    }
    /**
     * 导出excel数据
     *
     */
    public function actionGetExcelFile()
    {
        $model = new UserMap();
        $model->unsetAttributes();
        if (isset($_GET[get_class($model)])) {
            $model->_attributes = $_GET[get_class($model)];
        }
        $this->renderPartial('excel', array('model'=>$model,));
    }
    public function loadModel($id)
    {
        $model = UserMap::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
