<?php
class Controller extends JController
{
	public function init(){
		parent::init();
	
		//  Yii::app()->user->id = 10489;
	}
	
    /**
     * 权限过滤
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    
    /**
     * 过滤规则 '*'任何用户,'@'已验证用户,'?'匿名用户
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index'),
                //'expression'=>'$user->isAdmin()',
            ),
            
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}