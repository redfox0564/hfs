<?php
/**
 * 用户登录同步
 * 
 */
class UserSync
{
    public function syncUserInfo()
    {
        //  判断是否微博页面访问APP
        $cid            = Yii::app()->request->getQuery('cid');
        $ifmID          = Yii::app()->request->getQuery('ifmID');
        $url            = Yii::app()->request->getQuery('url');
        $sub_appkey     = Yii::app()->request->getQuery('sub_appkey');
        $viewer         = Yii::app()->request->getQuery('viewer');
        $tokenString    = Yii::app()->request->getQuery('tokenString');
        $source         = Yii::app()->request->getQuery('source');
        //  跳转授权 code 参数 By Get With access_token, remind_in, expires_in, uid In It
        $code           = Yii::app()->request->getQuery('code');

        self::makeCookie('viewer', $viewer);
        
        //  CID与SUBKEY存入cookie中
        if ( $cid && $sub_appkey ) {
            //  CID
            self::makeCookie('cid', $cid);

            //  SUB_KEY
            self::makeCookie('sub_appkey', $sub_appkey);
        }

        if ( !empty($code) ) {
            /*
             *  跳转授权
             */
            $OauthToken = self::getUserToken($code);
            if ( isset($OauthToken['access_token']) && !empty($OauthToken['access_token']) ) {
                $params = array(
                    'code'              => $code,
                    'source'            => 'local',
                    //  'client'            => $client,
                    'data[uid]'         => $OauthToken['uid'],
                    'data[access_token]'=> $OauthToken['access_token'],
                    'data[remind_in]'   => $OauthToken['remind_in'],
                    'data[expires_in]'  => $OauthToken['expires_in'],
                );
                Yii::app()->getRequest()->redirect(Yii::app()->createUrl('site/login', $params));
                Yii::app()->end();
            }
        } else {
        	//  访问客户端判断
        	if (JYii::isMobileClient() && empty(Yii::app()->user->id)) {
        		Yii::app()->getRequest()->redirect(Yii::app()->createUrl('home/wapIndex'));
        		//Yii::app()->getRequest()->redirect(Yii::app()->createUrl('site/login'));
        	} else if (JYii::isMobileClient() && !empty(Yii::app()->user->id)) {
        		return true;
        	}
            
            /*
             *  弹层授权
             */
            if ($cid && $ifmID && $url && $sub_appkey && $viewer && ($viewer != Yii::app()->user->id)) {
                $tokenInfo  = self::decodeUserToken($tokenString);
                if (!empty($tokenInfo->oauth_token)) {
                    $params = array(
                        'code'              => 'home',
                        'source'            => 'local',
                        //  'client'            => $client,
                        'data[uid]'         => $tokenInfo->user_id,
                        'data[access_token]'=> $tokenInfo->oauth_token,
                        'data[remind_in]'   => $tokenInfo->expires,
                        'data[expires_in]'  => $tokenInfo->expires,
                    );
                    Yii::app()->getRequest()->redirect(Yii::app()->createUrl('site/login', $params));
                    Yii::app()->end();
                }
            }

            if ($cid && $ifmID && $url && $sub_appkey && Yii::app()->user->id && !$viewer) {
                Yii::app()->getRequest()->redirect(Yii::app()->createUrl('site/logout',array('source'=>'local')));
                Yii::app()->end();
            }

            if ((empty($cid) || empty($ifmID) || empty($url) || empty($sub_appkey)) && !JYii::isMobileClient()) {
                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                if(!stristr($referer,'http://e.weibo.com') && empty($source)) {
                    $cookie   = Yii::app()->request->getCookies();
            		$weiboUrl = !empty($cookie['cid']->value) ? 'http://e.weibo.com/'.$cookie['cid']->value.'/app_'.Yii::app()->params['wb_akey'] : Yii::app()->params['weibo_url'];
            		Yii::app()->getRequest()->redirect($weiboUrl);
            		Yii::app()->end();
                }
            }
        }
    }
    
   /**
    * 验证用户是否授权
    * 
    * @author tianlongzhe
    * 
    * @param  String $tokenString
    * @return boolean
    */
    private function decodeUserToken($tokenString) {
           // 拆分token串
        $tokenArr = explode('.', $tokenString);
        if (!empty($tokenArr['1'])) {
            // 解码获取用户授权信息
            $tokenInfo = json_decode(base64_decode($tokenArr['1']));
            return $tokenInfo;
        }

        return false;
    }
    
    /**
     *  $Author     yanghongwei
     *  $Date       2013-09-09
     *  $Param      $codes
     *  $Return     array ()
     *  $Declare    获取跳转用户Token
     *  $Type       Function
     */
    private function getUserToken($codes)
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


    /**
     *  $Author     yanghongwei
     *  $Date       2013-09-12
     *  $Param      
     *  $Return     Bool
     *  $Declare    授权信息cid、sub_key 写cookie
     *  $Type       Function
     */
    public function makeCookie($key, $value)
    {
        $cookie = new CHttpCookie($key, $value);
        $cookie->expire = time()+60*60*24*30;
        $result = Yii::app()->request->cookies[$key] = $cookie;

        return $result;
    }



}
