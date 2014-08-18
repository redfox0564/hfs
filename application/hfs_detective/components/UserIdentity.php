<?php
/**
 * 用户身份验证
 * 
 */
class UserIdentity extends JUserIdentity
{
    private $_id;
    
    public function __construct() {}
    
    /**
     * 权限验证 跳转到对应的社交平台进行登陆验证
     * @see CUserIdentity::authenticate()
     */
    public function authenticate($params=array(), $site='weibo')
    {    
        // 新浪微博登陆验证
        if ($site == 'weibo') {
            $returnUrl = Yii::app()->params['redirect_uri'];
            if (!empty($params['code'])) {
                $code    = $params['code'];
                $state	= isset($params['state']) ? $params['state'] : '';
                $data	= isset($params['data']) ? $params['data'] : '';
                 
                if (empty($data) || count($data) != 4) {
                	// 判断认证信息是否正确
                	$oauth 	= new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey']);
                	$code	= array('code'=>$code, 'redirect_uri'=>$returnUrl);
                	$data	= $oauth->oauth->getAccessToken('code', $code);
                }
                 
                if (!empty($data) && count($data)==4) {
                    $this->_id = $data['uid'];
                    
                    // 记录token数据
                    Token::model()->updateToken($this->_id, $data);
                    
                    // 记录user数据
                    User::model()->updateUser($this->_id, $data['access_token']);
                    return true;
                }
            } else {
            	//  访问客户端判断
                $client = self::getClient();
                if($client == 'mobile') {
                    $key = !empty($params['key']) ? $params['key'] : '';
                    $cid = !empty($params['cid']) ? $params['cid'] : '';

                    $oauth    = new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey']);
                    $code     = $oauth->oauth->getAuthorizeURL($returnUrl, 'code', "index|{$key}", 'mobile');
                    if (!empty($code)) {
                        // 跳转到新浪微博认证页面
                        Yii::app()->getRequest()->redirect($code);
                    }
                } else {
                    // 默认登录都去访问首页进行自动登录操作
                    $cookie   = Yii::app()->request->getCookies();
            		$weiboUrl = !empty($cookie['cid']->value) ? 'http://e.weibo.com/'.$cookie['cid']->value.'/app_'.Yii::app()->params['wb_akey'] : Yii::app()->params['weibo_url'];
            		Yii::app()->getRequest()->redirect($weiboUrl);
                }
            	
                $key	= !empty($params['key']) ? $params['key'] : '';
                $cid	= !empty($params['cid']) ? $params['cid'] : '';
                $client = !empty($params['client']) ? $params['client'] : 'default';
                
                $oauth	= new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey']);
                $code	= $oauth->oauth->getAuthorizeURL($returnUrl, 'code', "index|{$key}", $client);
                if (!empty($code)) {
                    // 跳转到新浪微博认证页面
                    Yii::app()->getRequest()->redirect($code);
                }
            }
        } else if ($site == 'adminManage') {
            $adminId = Yii::app()->params['admin_id'];
            $password = Yii::app()->params['admin_password'];
            if(is_array($adminId) && in_array($params['userId'], $adminId) && strcmp($params['password'], $password) == 0){
                 $this->_id = $params['userId'];
                 return true;
            }else if (!is_array($adminId) && strcmp($params['userId'], $adminId) == 0 && strcmp($params['password'], $password) == 0) {
                 $this->_id = $params['userId'];
                 return true;
            } else {
                return false;
            }
        }
        
        $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     *  $Author     yanghongwei
     *  $Date       2013-09-12
     *  $Param
     *  $Return     String
     *  $Declare    客户端判断，getAuthorizeURL client 参数
     *  $Type       Function
     */
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
}