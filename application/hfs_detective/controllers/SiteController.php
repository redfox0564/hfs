<?php

class SiteController extends Controller
{
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public $layout = '//layouts/main';
    
    /**
     * 权限规则
     */
    public function accessRules() {
        return CMap::mergeArray(
            array(
                array(
                    'allow',
                    'actions'=>array('index', 'login', 'error', 'logout', 'deauthorize'),
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
    	$this->redirect(Yii::app()->createUrl(Yii::app()->defaultController, array('source'=>'local')));
    }
    
    /**
     * 登陆
     */
    public function actionLogin() {
        // 获取URL中的参数
        $queryString = Yii::app()->request->getQueryString();
        //parse_str(strtolower($queryString), $params);
        parse_str($queryString, $params);
        array_shift($params);
        
        Yii::app()->user->setReturnUrl(Yii::app()->createUrl(Yii::app()->defaultController, array('source'=>'local')));
        // 登陆验证
        $identity=new UserIdentity();
        if ($identity->authenticate($params, 'weibo')) {
            if (Yii::app()->user->login($identity, 86400)) {
                $this->redirect(Yii::app()->user->getReturnUrl());
            }
        } else {
            echo $identity->errorMessage;
        }
        Yii::app()->end();
    }


    /**
     * 登出
     */
    public function actionLogout() {
    	if(isset($_SERVER['HTTP_REFERER'])){
    		Yii::app()->user->setReturnUrl($_SERVER['HTTP_REFERER']);
    	}else{
    		Yii::app()->user->setReturnUrl(Yii::app()->createUrl(Yii::app()->defaultController, array('source'=>'local')));
    	}
    
    	Yii::app()->user->logout();
    	$this->redirect(Yii::app()->user->getReturnUrl());
    	Yii::app()->end();
    }
    
    /**
     *	取消授权 删除Token信息
     *	redirect home
     */
    public function actionDeauthorize() {
    	// 获取URL中的参数
    	$userId = Yii::app()->request->getPost('uid');
    
    	if ( !empty($userId) ) {
    		Token::model()->deleteToken($userId);
    	}
    
    	Yii::app()->end();
    }
    
    /**
	 * 网站错误提示
	 */
	public function actionError() {
	    if ($error=Yii::app()->errorHandler->error) {
            $this->redirect(Yii::app()->createUrl(Yii::app()->defaultController, array('source'=>'local')));die();
            /*
	    	if (Yii::app()->request->isAjaxRequest) {
	    		echo $error['message'];
	    	} else {
	        	$this->render('error', $error);
	    	}
	    	*/
	    }
	}
}
