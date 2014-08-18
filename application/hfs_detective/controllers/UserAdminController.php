<?php
Yii::import('sa_ext.kui.KuiData');
class UserAdminController extends AdminController
{
    /**
     * 列表
     */
    public function actionIndex()
    {
        $model = new User();
        $model->unsetAttributes();
        if (isset($_GET[get_class($model)])) {
            $model->_attributes = $_GET[get_class($model)];
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * 查看详情
     */
    public function actionView($id) {
        $this->layout = '//layouts/ajaxAdmin';
        $this->render('view',array('model'=>$this->loadModel($id)));
    }
    
    /**
     * 更新操作
     */
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
    
    /**
     * 删除操作
     */
    public function actionAjaxDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();
        } else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }
    
    /**
     * CKuiGridNew 数据
     */
    public function actionKuiGridData()
    {
        $model = new User();
        $kuiData = new KuiData();
        $this->renderPartial('kuiData', array('model' => $model,'kuiData' => $kuiData));
    }
    
    /**
     * 导出excel数据
     *
     */
    public function actionGetExcelFile()
    {
    	$model = new User();
    	$model->unsetAttributes();
    	if (isset($_GET[get_class($model)])) {
    		$model->_attributes = $_GET[get_class($model)];
    	}
    	$this->renderPartial('excel', array('model'=>$model,));
    }

    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}