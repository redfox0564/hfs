<?php
/**
 *  Weixin User Login Fro WeixinSdk in shiqu Yii FrameWork
 *  @Author     yanghongwei
 *  @E-Mail     jsyanghongwei@hotmail.com
 *  @Date       2014/06/09
 *  @Update     NULL
 *  @Version    1.0
 *  @copyright  Copyright © 2013 ShiQu Tech Co.,Ltd. All rights reserved
 */
class WeChatIdentity {
    //  属性列
    public  $weChat   = NULL;
    
    //  __construct
    public function __construct()
    {
        $this->weChat = new WeixinSdk(Yii::app()->params['we_chat']['app_id'], Yii::app()->params['we_chat']['app_secret']);
    }

    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    微信验证
     */
    public function weChatIdent()
    {
        //  初始列
        $accessToken= array ();
        $userInfo   = array ();
        $tokenAdd   = FALSE;
        $userAdd    = FALSE;

        //  已登陆
        if ( Yii::app()->user->id ) { return TRUE; }
        
        //  未登陆
        $code   = Yii::app()->request->getQuery('code');
        $state  = Yii::app()->request->getQuery('state');
        if ( !empty($code) && $state == Yii::app()->params['we_chat']['state'] ) {
            //  $_step2 获取微信用户Access_token
            $accessToken = $this->weChat->oauth->getAccessToken($code);
            if ( !isset($accessToken['errcode']) && is_array($accessToken) && count($accessToken) > 0 ) {
                //  记录 weChat Token
                $tokenData = array (
                    'access_token'  => $accessToken['access_token'],
                    'refresh_token' => $accessToken['refresh_token'],
                    'expires_in'    => $accessToken['expires_in'],
                    'scope'         => $accessToken['scope'],
                );
                $tokenAdd = WcToken::model()->updateToken($accessToken['openid'], $tokenData);

                //  $_step4 获取用户基本信息
                if ( $tokenAdd ) {
                    $userInfo         = $this->weChat->getUserInfo($accessToken['access_token'], $accessToken['openid'], FALSE, FALSE);
                    if ( !isset($accessToken['errcode']) && is_array($accessToken) && count($accessToken) > 0 ) {
                        //  记录 weChat 用户信息
                        $userAdd      = WcUser::model()->updateUser($userInfo['openid'], $accessToken['access_token'], $userInfo);
                        if ( $userAdd ) {
                            //  微信用户登陆验证
                            $identity   = new WeChatUserIdentity();
                            $identity->authenticate($userInfo['openid']);
                            Yii::app()->user->setReturnUrl(Yii::app()->createUrl('home/wapIndex', array('source'=>'local')));
                            if ( Yii::app()->user->login($identity, 86400) ) {
                                Yii::app()->getRequest()->redirect(Yii::app()->user->getReturnUrl());
                                Yii::app()->end();
                            } else { self::weChatLogin(); }
                        } else throw new Exception("user update failed");
                    } else { self::weChatLogin(); }
                } else throw new Exception("token update failed");
            } else { self::weChatLogin(); /* return $accessToken; Yii::app()->end(); */ }
        }

        //  $_step1 微信用户跳转登陆页
        self::weChatLogin();
    }
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    $_step1 微信用户跳转登陆页
     */
    public function weChatLogin()
    {
        $authUrl    = $this->weChat->oauth->getAuthorizeURL('snsapi_userinfo', array ( 'redirect_uri' => Yii::app()->params['we_chat']['redirect_uri']));
        if ( !empty($authUrl) ) {
            Yii::app()->getRequest()->redirect($authUrl);
            Yii::app()->end();
        } else throw new Exception("wrong auth url");
    }
}

class WeChatUserIdentity extends JUserIdentity {
    //  $_id
    private $_id;

    //  __construct
    public function __construct() {}
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    微信用户验证
     */
    public function authenticate($openId = '')
    {
        $this->_id = $openId;
    }
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    
     */
    public function getId()
    {
        return $this->_id;
    }
}
