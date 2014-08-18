<?php

Yii::import('sa_shiquTechExt.SinaSdk', true);

class WeiboLogin extends CApplicationComponent {

    public $appkey;
    public $seckey;
    private $oauth = NULL;
    public $mustLogin = false;
    public $appurl;
    public $regJs = true;
    public  $auto       = true;

    public function init(){
        parent::init();
        Yii::app()->attachEventHandler('onBeginRequest', array($this, 'login'));
        $this->setKeys();
        if($this->regJs){
            $this->regScripts();
        }
    }

    private function setKeys(){
        if(empty($this->appkey) || empty($this->seckey) || empty($this->appurl)){
            $this->appkey = Yii::app()->params['wb_akey'];
            $this->seckey = Yii::app()->params['wb_skey'];
            $this->appurl = Yii::app()->params['weibo_url'];
        }
    }

    protected function regScripts(){
        if(!$this->regJs) return;
        $src = 'http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js';
        $cs = Yii::app()->getclientScript();
        $cs->registerScriptFile($src, CClientScript::POS_END);
        $this->regJs = false;
    }

    public function login(){
        //  if ( Yii::app()->user->id ) return TRUE;
        
        /**
         *  update by yanghongwei@social-touch.com @2014/06/13
         *  微博授权区分
         *
         */
        if ( JYii::isMobileClient() ) {
            if ( Yii::app()->user->id ) return TRUE;
            //  WAP 授权
            $code   = Yii::app()->request->getQuery('code');
            if ( !empty($code) ) {
                //  授权回调
                $OauthToken = $this->getUserToken($code);
                if ( isset($OauthToken['access_token']) && !empty($OauthToken['access_token']) ) {
                    //  登陆
                    $data['oauth_token']= $OauthToken['access_token'];
                    $data['user_id']    = $OauthToken['uid'];
                    $data['expires']    = $OauthToken['expires_in'];
                    $data['remind_in']  = $OauthToken['remind_in'];
                    $id = $this->updateUser($data);
                    return Yii::app()->getuser()->login($id);
                }
            } else {
                //  注册静态，去往授权地址
                $this->regWeiboJS();
                return;
            }
        } else {
            //  PC 授权
            $signed = Yii::app()->request->getPost('signed_request');
            if ( empty($signed) ) { //  站外
                if ( $this->mustLogin ) { $this->tryLogin(); }
                return;
            }

            //  站内
            $this->oauth = new SaeTOAuthV2($this->appkey, $this->seckey);
            $data = $this->oauth->parseSignedRequest($signed);
            if ( $data == '-2' ) {
                Yii::log("can't parse signed_request.");
                return;
            } else {
                Yii::log(CVarDumper::dumpAsString($data));
                if ( isset($data['user_id']) ) {    //  logged in
                    //  已有登陆账号
                    if ( Yii::app()->user->id ) {
                        if ( Yii::app()->user->id != $data['user_id'] ) {
                            Yii::app()->user->logout(); //  登陆账号不一致
                        } else return TRUE; //  登陆一致
                    }
                    //  未有登陆账号 - 直接登陆更新
                    //  NULL

                    //  更新信息 - 应用执行登陆
                    $id = $this->updateUser($data);
                    return Yii::app()->getuser()->login($id);
                } else {
                    //  清空当前用户
                    Yii::app()->user->logout();
                    //  新浪微博 - 登陆执行框
                    if ( $this->mustLogin ) { $this->tryLogin(); }
                }
            }
        }
    }

    public function tryLogin(){
        $agent = $this->getClient();
        if($agent == 'mobile'){
            $this->redirectLogin();
        }else{
            $this->popupLogin();
        }
    }

    protected function redirectLogin(){
        // $url = 
        // Yii::app()->redirect($this->appurl);
    }

    protected function popupLogin(){
        if ( Yii::app()->user->id ) {
            return true;
        }
        $this->regScripts();
        $cs = Yii::app()->getclientScript();
        $script=<<<EOF
App.trigger('login', {
    'redirect_uri' : encodeURIComponent('{$this->appurl}')
});
EOF;
        $cs->registerScript(__CLASS__.'PopupLogin', $script);


    }

    protected function updateUser($data){
        //update user token
        $token = array(
            'access_token'=> $data['oauth_token'],
            'uid'         => $data['user_id'],
            'expires_in'  => $data['expires'],
            'remind_in'   => 0 //todo any value?
        );
        Token::model()->updateToken($data['user_id'], $token);
        User::model()->updateUser($data['user_id'], $data['oauth_token']);
        $id = new WeiboUserIdentity($data['user_id']);
        $id -> authenticate();

        return $id;
    }

    public function getClient()
    {
    	$isMobile       = FALSE;
    	$isMobile       = JYii::isMobileClient();
    	switch ( $isMobile ) {
    		case TRUE:
    			$client = 'mobile';
    			break;
    		case FALSE:
    			$client = 'default';
    			break;
    		default:
    			$client = 'mobile';
    	}
    
    	return !empty($client) ? $client : 'default';
    }
    
//  Update By yanghongwei@social-touch.com @2014/06/13
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    文件注册
     */
    public function regWeiboJS()
    {
        $sdk = new SinaSdk( Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey'] );
        $url = $sdk->oauth->getAuthorizeURL(Yii::app()->params['redirect_uri'], 'code', "index", 'mobile');
        $js  = "var _redirect_uri = '$url';\n";
        $src = 'http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js';
        $cs  = Yii::app()->getclientScript();
        $cs->registerScriptFile($src, CClientScript::POS_END);

        if ( !$this->auto ) {
            $js.='$("a").attr("href", "#");';
            $js.= "$(document).click(function(){window.location=_redirect_uri;return true;});";
            $cs->registerScript('redirect_login', $js);
        } else { Yii::app()->request->redirect($url); }
    }
    
    /**
     *  $Author     yanghongwei
     *  $Date       2013-09-09
     *  $Param      $codes
     *  $Return     array ()
     *  $Declare    获取跳转用户Token
     *  $Type       Function
     */
    public function getUserToken($codes)
    {
        header('P3P: CP=CAO PSA OUR');
        $tokenInfo      = array ();
        $akey           = Yii::app()->params['wb_akey'];
        $skey           = Yii::app()->params['wb_skey'];
        $redirectUrl    = Yii::app()->params['redirect_uri'];
        
        if ( !empty($codes) && !empty($akey) && !empty($skey) && !empty($redirectUrl) ) {
            $sdkObj     = new SinaSdk($akey, $skey);
            $code       = array("code" => $codes, "redirect_uri" => $redirectUrl);
            $tokenInfo  = $sdkObj->oauth->getAccessToken('code', $code);            
        }

        return !empty($tokenInfo) ? $tokenInfo : array ();
    }
    
}

class WeiboUserIdentity extends JUserIdentity {

    private $_id;
    private $_name;
    public $data = array();

    public function __construct($uid=NULL){
        $this->data  = User::model()->getUserInfo($uid);
        $this->_id   = $this->data['sina_uid'];
        $this->_name = $this->data['screen_name'];
    }

    public function authenticate($user = array()){
        $this->errorCode = self::ERROR_NONE;
        return true;
    }

	public function getPersistentStates()
	{
		return $this->data;
	}

    public function getId(){
        return $this->_id;
    }

    public function getName(){
        return $this->_name;
    }
}
