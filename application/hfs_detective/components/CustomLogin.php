<?php
/**
 *  User Login Fro shiqu Yii FrameWork
 *  @Author     yanghongwei
 *  @E-Mail     jsyanghongwei@hotmail.com
 *  @Date       2014/06/13
 *  @Update     NULL
 *  @Version    1.0
 *  @copyright  Copyright © 2013 ShiQu Tech Co.,Ltd. All rights reserved
 */
class CustomLogin {
    //  属性
    private $_type      = NULL; //  移动端类型 weibo / wechat
    private $_browser   = NULL; //  浏览器类型
    public  $_admin     = NULL; //  是否后台登陆

    //  __construct
    public function __construct()
    {
        $md = Yii::app()->mobile;
        if ( $md->isMobile() ) {
            //  移动端
            $this->_browser = 'mobile';
            if ( $md->is('weixin') ) {
                $this->_type      = 'weixin';
            } else { $this->_type = 'weibo'; }
        } else {
            //  PC端
            $this->_browser = 'pc';
            $this->_type    = 'weibo';
        }
        
        //  后台登陆
        $site = Yii::app()->controller->id;
        if ( $site == 'adminManage' ) 
            $this->_admin = new AdminLogin();
    }

    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    用户验证
     */
    public function login()
    {
        //  条件执行登陆
        if ( $this->_browser == 'pc' ) {
            //  PC外链跳转
            if ( !JYii::isMobileClient() ) {
                $source  = Yii::app()->request->getQuery('source');
                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                if ( !stristr($referer, 'http://apps.weibo.com') && empty($source) ) {
                    $weiboUrl = 'http://apps.weibo.com/' . Yii::app()->params['weibo_uid'] . '/' . Yii::app()->params['app_signed'];
                    Yii::app()->getRequest()->redirect($weiboUrl);
                    Yii::app()->end();
                }
            }
            
            //  PC - 微博用户登录验证
            Yii::app()->weibo->login();
        } else if ( $this->_browser == 'mobile' ) {
            switch ( $this->_type ) {
                case 'weibo':
                    //  WAP - 微博用户登录验证
                    Yii::app()->weibo->login();
                    break;
                case 'weixin':
                    //  WAP - 微信用户登录验证
                    $weChat = new WeChatIdentity();
                    $weChat->weChatIdent();
                    break;
            }
        } else {
            throw new Exception("No Identity found for browser: {$this->_browser}");
        }
    }    
}


/**
 *  后台管理登陆
 *  @Author     yanghongwei
 *  @E-Mail     jsyanghongwei@hotmail.com
 *  @Date       2014/06/18
 *  @Update     NULL
 *  @Version    1.0
 *  @copyright  Copyright © 2013 ShiQu Tech Co.,Ltd. All rights reserved
 */
class AdminLogin extends JUserIdentity {
    //  属性
    private $_id;

    //  __construct()
    public function __construct() {}
    
    /**
     * 权限验证
     * @see CUserIdentity::authenticate()
     * @look yanghongwei
     */
    public function authenticate($params = array (), $site='weibo')
    {
        if ( $site == 'adminManage' ) {
            $adminId  = Yii::app()->params['admin_id'];
            $password = Yii::app()->params['admin_password'];
            if ( is_array($adminId) && in_array($params['userId'], $adminId) && strcmp($params['password'], $password) == 0 ) {
                 $this->_id = $params['userId'];
                 return TRUE;
            }else if (!is_array($adminId) && strcmp($params['userId'], $adminId) == 0 && strcmp($params['password'], $password) == 0) {
                 $this->_id = $params['userId'];
                 return TRUE;
            } else { return FALSE; }
        } else {
            $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
            return !$this->errorCode;
        }
    }
    
    public function getId()
    {
        return $this->_id;
    }
}