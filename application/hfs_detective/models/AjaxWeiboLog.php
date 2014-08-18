<?php

/**
 * This is the model class for table "ajax_weibo_log".
 *
 * The followings are the available columns in table 'ajax_weibo_log':
 * @property string $id
 * @property string $weibo_id
 * @property string $user_id
 * @property integer $type
 * @property integer $match_id
 * @property string $status
 * @property string $is_del
 * @property string $creation_date
 */
class AjaxWeiboLog extends Ar
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AjaxWeiboLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ajax_weibo_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('type, match_id', 'numerical', 'integerOnly'=>true),
			array('weibo_id, mid', 'length', 'max'=>20),
			array('creation_date', 'length', 'max'=>10),
			array('user_id', 'length', 'max'=>13),
			array('is_del', 'length', 'max'=>1),
			array('status', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, weibo_id, mid, user_id, type, match_id, status, is_del, creation_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'        => 'ID',
			'weibo_id'  => '微博ID',
			'mid'       => '微博MID',
			'user_id'   => '用户新浪UID',
			'type'      => '微博分享类型',
			'match_id'  => '选项id',
			'status'    => '微博内容',
			'is_del'    => '是否删除',
			'creation_date' => '数据创建时间',
		);
	}
    
	/**
	 * 属性类型(non-PHPdoc)
	 * @see Ar::attributeTypes()
	 */
	public function attributeTypes()
	{
		return array(
			'type' => array (
				'1' => '抽奖分享(虚拟)',
				'2' => '抽奖分享(实物)',
				'3' => '宣言',
			),
		);
	}
    
	/**
	 * 保存前操作
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
		// 如果是新增记录
		if ($this->getIsNewRecord())
		{
			$this->is_del			= 'N';
			$this->creation_date	= time();
		}
		return parent::beforeSave() && !$this->hasErrors();
	}
	
	/**
	 * 保存后操作
	 * @see CActiveRecord::afterSave()
	 */
	public function afterSave(){
        
        //  更新mid
        //  $this->updateWeiboMid($this->weibo_id);
        
		return parent::afterSave() && !$this->hasErrors();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($num = 10)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('weibo_id',$this->weibo_id,true);
		$criteria->compare('mid',$this->mid,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('match_id',$this->match_id);
		$criteria->compare('status',$this->status,true);
		// $criteria->compare('is_del',$this->is_del,true);
		// $criteria->compare('creation_date',$this->creation_date,true);
        $criteria->addCondition("is_del = 'N'");
		if (!empty($this->creation_date['start']) && !empty($this->creation_date['end'])) {
			$criteria->addCondition("creation_date >= '".strtotime($this->creation_date['start'])."'");
			$criteria->addCondition("creation_date <= '".strtotime($this->creation_date['end'])."'");
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$num,
			),
			'sort'=>array(
				'defaultOrder'=>'creation_date DESC',
			),
		));
	}
    
    /**
     *  $Author      yanghongwei
     *  $Date        2013-05-20
     *  $Return      
     *  $Declare     添加微博分享日志
     *  $Type        Function
     */
    public function addWeiboLog($weiboId, $userId, $status, $weiboMsgKey)
    {
        if ( empty($userId) ) {
            return false;
        }
        $model = new AjaxWeiboLog();
        $model->weibo_id    = $weiboId;
        $model->mid         = '';
        $model->user_id     = $userId;
        $model->type        = $weiboMsgKey;
        $model->status      = $status;
        $model->is_del      = 'N';
        $model->creation_date = time();

        return $model->save() ? true : false;
    }
    
    /**
     *  $Author      yanghongwei
     *  $Date        2014-05-08
     *  $Return      
     *  $Declare     更新微博数据
     *  $Type        Function
     */
    public function updateWeiboMid($userId, $weiboId)
    {
        $midInfo= array ();
        $userId = Yii::app()->user->id;
        if ( !empty($userId) ) {
            $token    = Token::model()->getTokenInfo($userId);
            if ( is_array($token) && count($token) > 0 ) {
                $sdkObj   = new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey'], $token['oauth_token']);
                $midInfo  = $sdkObj->querymid($weiboId);
                $mid      = (isset($midInfo['mid']) && !empty($midInfo['mid'])) ? $midInfo['mid'] : '';

                $model = new AjaxWeiboLog();
                $model = $model->findByAttributes(
                    array (
                        'weibo_id' => $weiboId,
                        'user_id'  => $userId,
                    )
                );
                
                $model->weibo_id    = $model->weibo_id;
                $model->mid         = $mid;
                $model->user_id     = $model->user_id;
                $model->type        = $model->type;
                $model->status      = $model->status;
                $model->is_del      = $model->is_del;
                $model->creation_date = $model->creation_date;

                return $model->save() ? TRUE : FALSE;
            } else return FALSE;
        } else return FALSE;
    }
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    主键查
     */
    public function findWeiboByPk($priKey)
    {
        $data = AjaxWeiboLog::model()->findByPk($priKey);
        return (!empty($data)) ? JYii::objectToArray($data) : array (); 
    }
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    属性
     */
    public function findWeiboByAttr($weiboId)
    {
        $data = array ();
        if ( !empty($weiboId) ) {
            $data = AjaxWeiboLog::model()->findByAttributes(array ('weibo_id' => $weiboId));
        }
        
        return (!empty($data)) ? JYii::objectToArray($data) : array (); 
    }
}