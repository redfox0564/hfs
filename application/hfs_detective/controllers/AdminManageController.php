<?php
class AdminManageController extends Controller
{
    /**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public $layout = null;
	
	/**
	 * 权限规则
	 */
	public function accessRules() {
		return CMap::mergeArray(
			array(
				array(
					'allow',
					'users'=>array('*'),//任何用户都能使用login,error
				),
			),
			parent::accessRules()
		);
	}

    /**
	 * 默认页
	 */
	public function actionIndex() {
        $adminId = Yii::app()->params['admin_id'];
        $uid = Yii::app()->user->id;
        if(is_array($adminId) && $uid && in_array($uid, $adminId)){
            $this->redirect(Yii::app()->createUrl(Yii::app()->params['menuList'][0]['items'][0]['url']));
        }else if (!is_array($adminId) && $uid && strcmp($uid, $adminId) == 0) {
            $this->redirect(Yii::app()->createUrl(Yii::app()->params['menuList'][0]['items'][0]['url']));
        }
        $error = FALSE;
		if( !empty($_POST['userId']) && !empty($_POST['password']) ) {
            $params['userId']   = $_POST['userId'];
            $params['password'] = $_POST['password'];
            
            //  后台登陆
            $CustomLogin = new CustomLogin();
            $identity    = $CustomLogin->_admin;
            if ( $identity->authenticate($params, 'adminManage') ) {
                if ( Yii::app()->user->login($identity, 3600) ) {
                    $this->redirect(Yii::app()->createUrl(Yii::app()->params['menuList'][0]['items'][0]['url']));
                }
            }
        }
        if( !empty($_POST['userId']) && !empty($_POST['password']) ) 
            $error = TRUE;
        $this->renderPartial('index',array('error'=>$error));
	}
}