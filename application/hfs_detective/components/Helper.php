<?php
//  emoji表情库
$emojiPath = dirname(__FILE__) . '/' . '../../../library/shiquTech/shiquTechExt/Emoji.php';
@include($emojiPath);
/**
 * 公用扩展类
 *
 * @Author      yanghongwei
 * Declare      助手类
 */
class Helper /* extends CApplicationComponent */ {
//------------------------------------------------------------------------
//  类初始
    //  属性
    private $_plat  = NULL; //  移动端类型 weibo / wechat
    
    //  Init
    public function init()
    {
        //  客户端处理
        $md = Yii::app()->mobile;
        if ( $md->isMobile() && $md->is('weixin') ) {
            //  微信
            $this->_plat = 'wechat';
        } else {
            //  微博(PC || WAP)
            $this->_plat = 'weibo';
        }
        
        //  parent::init();
    }
    
//------------------------------------------------------------------------
//  抽奖配置
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    执行抽奖
     */
    public function lotteryExec($lotteryId, $uid)
    {
        if ( !empty($lotteryId) ) {
            $lottery    = MLotteryInfo::model()->findByPk($lotteryId);      //  获取实例
            $filters    = $lottery->filters;
            $checker    = MLotteryFilters::instance($lottery);			    //  这里需要给出抽奖的id或者MLotteryInfo的实例
            $result     = $checker->check($filters);
            $status     = $result->status;

            if ( $status == 30 || $status == 40 ) {
                //  将被存入数据库 (再接再厉 | 中奖)
                $win        = new MLotteryWinner();
                if ( $uid ) {
                    switch ($this->_plat) {
                        case 'wechat':
                            $user   = WcUser::model()->findByAttributes(array(
                                'openid'  => $uid,
                            ));
                            $win->user_id   = $uid;
                            $win->sina_nick = (isset($user->nickname)) ? $user->nickname : '微信网友';
                            $win->fans_num  = (isset($user->friends_count)) ? $user->friends_count : 0;
                            break;
                        case 'weibo':
                            $user   = User::model()->findByAttributes(array(
                                'sina_uid'  => $uid,
                            ));
                            $win->user_id   = $uid;
                            $win->sina_nick = (isset($user->screen_name)) ? $user->screen_name : '微博网友';
                            $win->fans_num  = (isset($user->friends_count)) ? $user->friends_count : 0;
                            break;
                        default:
                            $user   = User::model()->findByAttributes(array(
                                'sina_uid'  => $uid,
                            ));
                            $win->user_id   = $uid;
                            $win->sina_nick = (isset($user->screen_name)) ? $user->screen_name : '微博网友';
                            $win->fans_num  = (isset($user->friends_count)) ? $user->friends_count : 0;
                            break;
                    }
                }
                
                //  奖品
                $prize              = JArray::deep_get($result->result, 'prize');
                if(!$prize) {
                    //  获取属于这个抽奖的默认奖品
                    $prize          = $lottery->defaultPrize->attributes;
                }
                $win->prize_id      = $prize['id'];
                $win->lottery_id    = $lotteryId;
                $win->is_ch         = 0;
                //if ( $win->save() ) {
                //    echo 111;
                //} else {
                //    print_r($win->errors);
                //}
                //exit;

                //  保存
                if ( $win->save() ) {
                    //  当为抽奖时候而不是投票或者分享微博获得卡牌，执行下面的区间
                    //  Yii::app()->user->setState('winner_id', $win->id);
                    //  return array ('prize_id' => $win->prize_id, 'default_prize' => $lottery->defaultPrize->attributes['id']);
                    $Mprize    = new MLotteryPrize();
                    $prizeInfo = $Mprize->getPrizeInfoById($win->prize_id);
                    if ( is_array($prizeInfo) && count($prizeInfo) > 0 ) {
                        unset($prizeInfo['probablity']);
                        unset($prizeInfo['quantity']);
                        unset($prizeInfo['eachone']);
                        return array ('code' => $status, 'prize' => $prizeInfo);
                    } else 
                        return array ('code' => $status, 'prize' => array ());
                } else {
                     return array ('code' => $status, 'prize' => array ());    //  数据保存错误
                }
            } else 
                return array ('code' => $status, 'prize' => array ());
        }
    }
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    更新中奖用户信息
     */
    public function updateWinnerInfoByUid($userId, $info)
    {
        if ( !empty($userId) && is_array($info) && count($info) > 0 ) {
            $Mwinner = new MLotteryWinner();
            return $Mwinner->updateWinnerInfo($userId, $info);
        } else 
            return FALSE;
    }
    
//------------------------------------------------------------------------
//  投票配置
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    创建新的前台用户投票，返回的投票id存储于投票对象
     */
    public function setNewCustomVote($userId)
    {
        //  初始化
        $voteId = NULL;

        //  逻辑
        if ( !empty($userId) ) 
            $voteId = Vote::newVote($userId);
        return !empty($voteId) && $voteId != 0 ? $voteId : NULL;
    }
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    进行投票
     */
    public function execVote($userId, $voteId, $option)
    {
        //  初始化
        $voteRes = FALSE;
        
        //  逻辑
        if ( !empty($option) && !empty($option) ) {
            //  投票模块处理
            $vote = new STVote();
            $vote = $vote->findByPk($voteId);
            if ( empty($vote) ) 
                return FALSE;
            //  投票结果
            $voteResult = unserialize($vote->vote_results);
            if ( isset($voteResult[$option]['vote_num']) ) {
                $voteResult[$option]['vote_num'] = $voteResult[$option]['vote_num'] + 1;   
            }
            $vote->vote_results = serialize($voteResult);
            //  总票数
            $vote->total_num    = $voteResult[$option]['vote_num'] + $voteResult[$option]['virtual_vote_num'];
            $voteRes = $vote->save() ? TRUE : FALSE;
            if ( $voteRes ) {
                //  投票日志
                return STVoteLog::model()->setVotelog($userId, $voteId, $option);
            } else 
                return FALSE;
        } else 
            return FALSE;
    }
    
//------------------------------------------------------------------------
//  微博操作
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    关注官微
     */
    public function currentFllow()
    {
        //  初始化
        $followUid  = Yii::app()->params['weibo_uid'];
        $userId     = Yii::app()->user->id;
        //  逻辑
        if ( $userId ) {
            $token  = Token::model()->getTokenInfo($userId);
            if ( is_array($token) && count($token) > 0 ) {
                $sdkObj   = new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey'], $token['oauth_token']);
                $sendRes  = $sdkObj->follow_by_id($followUid);
                if (empty($sendRes['error']) && !empty($sendRes)) return TRUE;
                else return FALSE;
            } else return FALSE;
        } else return FALSE;
    }
    
//------------------------------------------------------------------------
//  框架设置相关方法
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    设置Cookie
     */
    public function setCookie($key, $value, $timer)
    {
        $result = FALSE;
        $timer  = !empty($timer) ? $timer : 86400;
        if ( !empty($key) && !empty($value) ) {
            $cookie = new CHttpCookie($key, $value);
            $cookie->expire = $timer;
            $result = Yii::app()->request->cookies[$key] = $cookie;
        }
        return $result;
    }
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    清除Cookie
     */
    public function cleanCookie($key)
    {
        $result = FALSE;
        if ( !empty($key) ) {
            $value  = '';
            $cookie = new CHttpCookie($key, $value);
            $cookie->expire = time()-60*60*24*30;
            $result = Yii::app()->request->cookies[$key] = $cookie;
        }
        return $result;
    }
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    过滤emoji表情
     */
    public function emojiFilter($msg)
    {
        $res = iconv('utf-8', 'utf-8//ignore', $msg);
        return preg_replace('/[^\pL\pN\pP\pZ]/u', '', $res);
        //$cleanText = emoji_docomo_to_unified($msg);
        //return emoji_unified_to_html($cleanText);
    }
    

}