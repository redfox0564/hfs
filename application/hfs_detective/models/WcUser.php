<?php

/**
 * This is the model class for table "wc_user".
 *
 * The followings are the available columns in table 'wc_user':
 * @property string $openid
 * @property string $nickname
 * @property integer $sex
 * @property string $province
 * @property string $city
 * @property string $country
 * @property string $headimgurl
 * @property string $language
 * @property string $privilege
 * @property string $is_del
 * @property integer $creation_date
 */
class WcUser extends Ar
{
    /**
     * 返回数据表所在的库名
     * @return 返回Token的数据库名
     */
    public $dbname = 'db';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WcUser the static model class
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
		return 'wc_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('openid, creation_date', 'required'),
			array('sex, creation_date', 'numerical', 'integerOnly'=>true),
			array('openid, country', 'length', 'max'=>50),
			array('nickname', 'length', 'max'=>80),
			array('province, city', 'length', 'max'=>20),
			array('headimgurl', 'length', 'max'=>255),
			array('language', 'length', 'max'=>15),
			array('is_del', 'length', 'max'=>1),
			array('privilege', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('openid, nickname, sex, province, city, country, headimgurl, language, privilege, is_del, creation_date', 'safe', 'on'=>'search'),
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
			'openid'        => '微信用户 Openid',
			'nickname'      => '微信用户 昵称',
			'sex'           => '微信用户 性别',
			'province'      => '微信用户 省',
			'city'          => '微信用户 市',
			'country'       => '微信用户 国家',
			'headimgurl'    => '微信用户 头像',
			'language'      => '微信用户 语言',
			'privilege'     => '微信用户 Privilege',
			'is_del'        => '微信用户 是否删除',
			'creation_date' => '微信用户 创建时间',
		);
	}
    
	/**
	 * 属性类型(non-PHPdoc)
	 * @see Ar::attributeTypes()
	 */
	public function attributeTypes()
	{
		return array (
			'is_del'    => array (
				'Y'	=> '是',
				'N'	=> '否',
			),
        );
    }
    
	/**
	 * 验证前操作
	 * @see CModel::beforeValidate()
	 */
	public function beforeValidate()
	{
		// 如果是新增记录
		if ($this->getIsNewRecord())
		{
			$this->is_del			= 'N';
			$this->creation_date	= time();
		}
		return parent::beforeValidate() && !$this->hasErrors();
	}
	
	/**
	 * 验证后操作
	 * @see JActiveRecord::afterValidate()
	 */
	public function afterValidate()
	{
		return parent::afterValidate() && !$this->hasErrors();
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
		return parent::afterSave() && !$this->hasErrors();
	}
	
	/**
	 * 删除前操作
	 * @see CActiveRecord::beforeDelete()
	 */
	public function beforeDelete()
	{
		return parent::beforeDelete() && !$this->hasErrors();
	}
	
	/**
	 * 删除后操作
	 * @see CActiveRecord::afterDelete()
	 */
	public function afterDelete()
	{
		return parent::afterDelete() && !$this->hasErrors();
	}
    

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($num='10')
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('openid',$this->openid,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('headimgurl',$this->headimgurl,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('privilege',$this->privilege,true);
		$criteria->compare('is_del',$this->is_del,true);
		//  $criteria->compare('creation_date',$this->creation_date);
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
	 * 更新威信用户信息
     * @author yanghongwei
	 * @param  Int      $openid         用户openID
	 * @param  String   $accessToken    微信TOKEN
	 * @param  Array    $userInfo       用户信息
	 * @return boolean
	 */
	public function updateUser($openid, $accessToken = NULL, $userInfo = array())
	{
		if ( empty($userInfo) ) {
			//  获取最新微信用户信息
			$weChat = new WeixinSdk(Yii::app()->params['we_chat']['app_id'], Yii::app()->params['we_chat']['app_secret']);
			
		}
	
		$model = new WcUser();
		//  判断用户是否存在
		$model = $model->findByPk($openid);
		if (empty($model)) {
			$model = new WcUser();
		}
	
        //  字段列
		$model->openid      = $openid;
		$model->nickname    = isset($userInfo['nickname']) && !empty($userInfo['nickname']) ? $userInfo['nickname'] : $model->nickname;
		$model->sex         = isset($userInfo['sex']) && !empty($userInfo['sex']) ? $userInfo['sex'] : $model->sex;
		$model->province    = isset($userInfo['province']) && !empty($userInfo['province']) ? $userInfo['province'] : $model->province;
		$model->city        = isset($userInfo['city']) && !empty($userInfo['city']) ? $userInfo['city'] : $model->city;
		$model->country     = isset($userInfo['country']) && !empty($userInfo['country']) ? $userInfo['country'] : $model->country;
		$model->headimgurl  = isset($userInfo['headimgurl']) && !empty($userInfo['headimgurl']) ? $userInfo['headimgurl'] : $model->headimgurl;
		$model->language    = isset($userInfo['language']) && !empty($userInfo['language']) ? $userInfo['language'] : $model->language;
		$model->privilege   = isset($userInfo['privilege']) && !empty($userInfo['privilege']) ? $userInfo['privilege'] : $model->privilege;
	
		return $model->save() ? TRUE : FALSE;
	}
    
	/**
	 * 获取用户信息
     * @author yanghongwei
	 * @param  Int $openid
	 * @return Ambigous <CActiveRecord, mixed, NULL, multitype:, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:unknown >
	 */
	public function getUserInfo($openid)
	{
		$info = array();
		$data = $this->findByPk($openid);
		if ( !empty($data) ) {
			$info = JYii::objectToArray($data);
		}
	
		return $info;
	}
    
	public function getUserInfoByNick($nick)
	{
		$info = array();
		$data = $this->findByAttributes(array ('nickname' => $nick));
		if ( !empty($data) ) {
			$info = JYii::objectToArray($data);
		}
		return $info;
	}
    
    /**
     *  $Author     yanghongwei
     *  $param      NULL
     *  $Declare    in 条件 用户信息查询
     */
    public function getUserInIds($ids)
    {
        if ( is_array($ids) && count($ids) > 0 ) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('openid', $ids);
            $criteria->order = 'creation_date DESC';
            $data = $this->findAll($criteria);
        }

        return !empty($data) ? JYii::objectToArray($data) : array();
    }
    
    
}