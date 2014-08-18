<?php
/**
 * AJAX公共方法文件
 *
 * @Author 	田龙哲
 * @E-Mail  tianlongzhe@shiqutech.com
 * @Date    2013-05-20
 * @Update 	2013-05-21
 * @version 1.0
 * @WebSite	http://app.shiqutech.com
 * @copyright © 2013 Social Touch Co.,Ltd. All rights reserved
 */
class AjaxWeiboController extends Controller 
{
	/**
	 * 加载默认使用的布局
	 */
	public $layout = false;
	
	/**
	 * 权限规则
	 */
	public function accessRules() {
		return CMap::mergeArray(
			array(
				array(
					'allow',
					'actions'=>array('ajaxUserClickLink', 'ajaxVoteWeiboShare', 'ajaxFollow', 'AjaxWeiboSend', 'at'),
					'users'=>array('*'),
				),
			),
			parent::accessRules()
		);
	}	

	public function actionIndex() {
		
	}
	
	/**
	 *  $Author      yanghongwei
	 *  $Date        2013-05-20
	 *  $weiboMsgKey : 文案数组键,
	 *  $isRand      : 是否文案随机    true    是    |    false 否
	 *  $Return      String
	 *  $Declare     微博内容文案
	 *  $Type        Function
	 */
	public static function getWeiboMsgContent($weiboMsgKey, $isRand = false) {
		if (empty($weiboMsgKey)) {
			return false;
		}
	
		$weiboMsg = array (
			/*'1' => array (
				// Msg1
				'Public Weibo Test By Message Content_1',
				// Msg2
				'Public Weibo Test By Message Content_2',
				// Msg3
				'{$0} go to {$1} by {$2}, but Yet {$3} now divined that he was not with his {$4}!',
			),*/
			// ...
            '1' => array (
                // Msg1
                '#选你所属# 我刚刚得到了很喜欢的 @{$0} 限量版爱尔康隐形眼镜！真的好开心！喜欢TA的朋友快来免费申领哦~',
            ),
            '2' => array (
                // Msg1
                '#选你所属# @{$0} ，我想对你说：{$1}。刚刚在@爱尔康视力保健俱乐部 发现可以免费申领爱尔康隐形眼镜送给好友。我帮你挑了一款，是@{$2} 的限量版，快去填收货地址试试手气吧！ {$3}',
            ),
            '3' => array (
                // Msg1
                '',
            ),
            
            /*
            '3' => array (
                // Msg1
                '#海飞丝NBA实力宝贝# 【{$0}站】 三分球大赛、3V3实力对决，'.
                '这些还不够给力？别忘了还有我们的海飞丝实力宝贝！'.
                '赚足眼球的就是她们！希望你支持的美女成为NBA中国赛的人拉拉队员吗？'.
                '投出你神圣的一票吧！@海飞丝实力派',
                // Msg2
                '#海飞丝NBA实力宝贝# 【{$0}站】 激情似火的夏日怎能少了篮球的陪伴，'.
                '没有NBA球赛，就来篮球国度挥洒你的汗水吧！'.
                '别忘了给你支持的实力宝贝投上一票，'.
                '她就有可能出现在NBA中国赛拉拉队的队伍中！@海飞丝实力派',
            ),
            '5' => array (
                // Msg1
                '#海飞丝NBA实力宝贝#@{$0}  默默关注你很久了，'.
                '觉得你的条件符合小海的要求，推荐你成为海飞丝实力宝贝，'.
                '快来报名吧！@海飞丝实力派',
            ),
            */
		);

		// 是否随机
		switch ($isRand) {
			case true:
				$rand_key = array_rand($weiboMsg[$weiboMsgKey], 1);
				$sendMsg  = $weiboMsg[$weiboMsgKey][$rand_key];
				break;
			case false:
				$sendMsg  = $weiboMsg[$weiboMsgKey][0];
				break;
		}
	
		return empty($sendMsg) ? '' : $sendMsg;
	}
	
    public static function makeWeiboSend($userId, $weiboMsgKey, $isRand = FALSE, $publicParam = '', $weiboImg = '', $isShareUrl = TRUE)
    {
        $weiboMsg  = self::getWeiboMsgContent($weiboMsgKey, $isRand);
		// 短链 & 时间值
        if ( $isShareUrl ) {
            $weiboMsg .= ' '.Yii::app()->params['share_url'] . '&t=' . time();
        }

		// 微博变量替换
		$weiboMsg  = self::mgParamPreg($weiboMsg, $publicParam);

		// 微博发送
		$res = self::weiboSendExec($userId, $weiboMsgKey, $weiboMsg, $weiboImg);
		return $res;
    }
    
	/**
	 * $Author      yanghongwei
	 * $Date        2013-05-20
	 * $Param       NULL
	 * $Return
	 * $Declare     AJAX 调取Action 发送微博
	 * $Type        Action
	 */
	public function actionAjaxWeiboSend() {
		// 参数
		$code = 404;
		$msg  = 'Weibo Send Error';
		$weiboMsgKey = Yii::app()->request->getPost('weiboMsgKey');     // 微博内容数组键
		$weiboImg    = Yii::app()->request->getPost('weiboImg');        // 微博图像 (没有传空)
		$isRand      = Yii::app()->request->getPost('isRand');          // 是否随机取文案
		$publicParam = Yii::app()->request->getPost('publicParam');     // 公用参数 (微博文案中动态值, 想要变化的参数)
		$content     = Yii::app()->request->getPost('content');         // 微博自定义内容 存在则文案取此内容

        //  debug
        //  $content = 'test test' . time();
        
        if ( empty($weiboImg) ) {
            //  $weiboImg = Yii::app()->params['static_url'].'/images/babyshare.jpg';
        }

		// 用户处理
		$userId    = Yii::app()->user->id;
		if (empty($userId)) {
			$code  = 401;
			$msg   = 'NO User Login';
			JYii::endJsonMsg($code, $msg);
		}
	
		// 微博KEY 检测
		//if (empty($weiboMsgKey)) {
		//	$code  = 402;
		//	$msg   = 'NO MsgArray Key';
		//	JYii::endJsonMsg($code, $msg);
		//}
	
		// 微博文案获取
        if ( empty($content) ) {
            $weiboMsg  = self::getWeiboMsgContent($weiboMsgKey, $isRand);
        } else {
            $weiboMsg  = $content;
        }

		// 短链 & 时间值
		$weiboMsg .= ' '.Yii::app()->params['share_url'];
	
		// 微博变量替换
		$weiboMsg  = self::mgParamPreg($weiboMsg, $publicParam);

		// 微博发送
		$res = self::weiboSendExec($userId, $weiboMsgKey, $weiboMsg, $weiboImg);
		$code= $res['code'];
		$msg = $res['msg'];
		JYii::endJsonMsg($code, $msg);
	}
	
	/**
	 * $Author      yanghongwei
	 * $Date        2013-05-20
	 * $Param       NULL
	 * $Return      NONE
	 * $Declare     微博发送
	 * $Type        Function
	 */
	public static function weiboSendExec($userId, $weiboMsgKey, $sendMsg, $weiboImg) {
		// 参数
		$code = 404;
		$msg  = 'Weibo Send Error';
	
		// Token & SDK OBJ
		$token    = Token::model()->getTokenInfo($userId);
		if (empty($token)) {
			$code = 405;
			$msg  = 'Weibo Token Error';
			return array ('code' => $code , 'msg' => $msg);
		}

		// 发送部分
		$sdkObj   = new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey'], $token['oauth_token']);
		if (!empty($weiboImg)) {
			$sendRes = $sdkObj->upload($sendMsg, $weiboImg);
		} else {
			$sendRes = $sdkObj->update($sendMsg);
		}
	
		if (empty($sendRes['error']) && !empty($sendRes)) {
			// 日志写库
			$weiboId = $sendRes['id'];
			$status  = $sendRes['text'];
			$logRes  = AjaxWeiboLog::model()->addWeiboLog($weiboId, $userId, $status, $weiboMsgKey);
            
            // 更新mid
            AjaxWeiboLog::model()->updateWeiboMid($userId, $weiboId);
	
			$code = 1;
			$msg  = 'weibo Send Success';
			return array ('code' => $code , 'msg' => $msg, 'weibo_id' => $weiboId);
		} else {
			$code = $sendRes['error_code'];
			$msg  = $sendRes['error'];
			return array ('code' => $sendRes['error_code'] , 'msg' => $sendRes['error']);
		}
	}
	
	/**
	 * $Author      yanghongwei
	 * $Date        2013-05-20
	 * $Param       NULL
	 * $Return
	 * $Declare     AJAX 调取Action 关注
	 * $Type        Action
	 */
	public function actionAjaxFollow() {
		// 参数
		$code = 404;
		$msg  = 'Fllow Error';
	
		// 用户处理
		$followUid= Yii::app()->request->getPost('followUid');
		$userId   = Yii::app()->user->id;
        // $userId   = 3535437867;
		if (empty($userId)) {
			$code = 401;
			$msg  = 'NO User Login';
			JYii::endJsonMsg($code, $msg);
		} else if ( empty($followUid) ) {
			$code = 401;
			$msg  = 'NO Fllow User';
			JYii::endJsonMsg($code, $msg);
		}
	
		// Token & SDK OBJ
		$token    = Token::model()->getTokenInfo($userId);
		if (empty($token)) {
			$code = 401;
			$msg  = 'User Token Error';
			JYii::endJsonMsg($code, $msg);
		}
	
		// 发送
		$sdkObj   = new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey'], $token['oauth_token']);
		$sendRes  = $sdkObj->follow_by_id($followUid);
		if (empty($sendRes['error']) && !empty($sendRes)) {
			$code = 1;
			$msg  = 'Fllow Success';
		} else {
            $code = $sendRes['error_code'];
            $msg  = $sendRes['error'];
        }
	
		JYii::endJsonMsg($code, $msg);
	}
    
	/**
	 * $Author      yanghongwei
	 * $Date        2014-06-16
	 * $Param       NULL
	 * $Return
	 * $Declare     AJAX 调取 at 好友联想
	 * $Type        Action
	 */
    public function actionAt()
    {
        //  初始化
        $code   = 2;
        $msg    = 'get friends list failed';
        $atList = array ();
        $userId = Yii::app()->user->id;
        empty($userId) ? JYii::endJsonMsg(-1, 'user not exists', array ()) : TRUE;
        
        //  参数
        $keyword= Yii::app()->request->getPost('keyword');
        //  $keyword= urlencode($keyword);

        //  逻辑
		$token  = Token::model()->getTokenInfo($userId);
        empty($token) ? JYii::endJsonMsg(-2, 'user token error', array ()) : TRUE;
		
        $sdkObj = new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey'], $token['oauth_token']);
		$atList = $sdkObj->search_at_users($keyword);
        
        //  返回值
        if ( is_array($atList) && count($atList) > 0 ) {
            JYii::endJsonMsg(1, 'user list', $atList);
        } else JYii::endJsonMsg(-3, 'sina api error', $atList);
    }
	
	/**
	 * 保存用户点击超链接日志
	 * 
	 * @author TianLongZhe Update By wuqingyu
	 */
	public function actionAjaxUserClickLink() {
		// 获取传递过来的变量
		$callback = Yii::app()->request->getPost('callback');
		$linkId = Yii::app()->request->getPost('link_id');
		$otherId = Yii::app()->request->getPost('other_id'); // 备用ID

		if (empty($linkId)) {
			JYii::endJsonMsg(2, '链接ID为空', array(), $callback);
		}
		
		// 添加链接点击日志
		if (LinkLog::model()->addLinkLog($linkId, $otherId)) {
			JYii::endJsonMsg(1, '保存成功', array(), $callback);
		} else {
			JYii::endJsonMsg(2, '保存失败', array(), $callback);
		}
	}
	
	/**
	 * $Author      yanghongwei
	 * $Date        2013-05-20
	 * $Param       NULL
	 * $Return      String
	 * $Declare     微博文本动态值替换
	 * $Type        Function
	 */
	public static function mgParamPreg($weiboMsg, $publicParam) {
		$paramArr    = array ();
		$paramReplace= array ();
		$paramArr    = explode('|', $publicParam);
	
		$weiboMsg    = preg_replace('|\{\$(.*)\}|iseU', '$paramArr["$1"]', $weiboMsg);
	
		return empty($weiboMsg) ? '' : $weiboMsg;
	}

    
}