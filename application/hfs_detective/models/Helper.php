<?php
/**
 * 公用扩展类
 *
 * @Author      yanghongwei
 * Declare      助手类
 */
class Helper {
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
                    $user   = User::model()->findByAttributes(array(
                        'sina_uid'  => $uid,
                    ));
                    $win->sina_id   = $uid;
                    $win->sina_nick = (isset($user->screen_name)) ? $user->screen_name : '网友';
                    $win->fans_num  = (isset($user->friends_count)) ? $user->friends_count : 0;
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
//  官微操作
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

}