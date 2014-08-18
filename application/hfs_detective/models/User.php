<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $sina_uid
 * @property string $idstr
 * @property string $screen_name
 * @property string $name
 * @property integer $province
 * @property integer $city
 * @property string $location
 * @property string $description
 * @property string $url
 * @property string $profile_image_url
 * @property string $cover_image
 * @property string $profile_url
 * @property string $domain
 * @property string $weihao
 * @property string $gender
 * @property string $followers_count
 * @property string $friends_count
 * @property string $statuses_count
 * @property string $favourites_count
 * @property string $created_at
 * @property string $following
 * @property string $allow_all_act_msg
 * @property string $geo_enabled
 * @property string $verified
 * @property string $verified_type
 * @property string $remark
 * @property string $status
 * @property string $allow_all_comment
 * @property string $avatar_large
 * @property string $verified_reason
 * @property string $follow_me
 * @property integer $online_status
 * @property integer $bi_followers_count
 * @property string $lang
 * @property integer $star
 * @property integer $mbtype
 * @property integer $mbrank
 * @property integer $block_word
 * @property string $is_del
 * @property integer $creation_date
 * @property integer $verified_my
 * @property string $regions
 */
yii::import('sa_ext.fun.JYii');
class User extends Ar
{
	/**
	 * 返回数据表所在的库名
	 * @return 返回User的数据库名
	 */
	public $dbname = 'db';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sina_uid', 'required'),
			array('province, city, online_status, bi_followers_count, star, mbtype, mbrank, block_word, creation_date, verified_my', 'numerical', 'integerOnly'=>true),
			array('sina_uid, weihao, followers_count, friends_count, statuses_count, favourites_count', 'length', 'max'=>10),
			array('idstr', 'length', 'max'=>15),
			array('screen_name, name, location, remark', 'length', 'max'=>50),
			array('description', 'length', 'max'=>150),
			array('url, profile_image_url, cover_image, profile_url, domain, avatar_large, verified_reason', 'length', 'max'=>255),
			array('gender, is_del', 'length', 'max'=>1),
			array('created_at', 'length', 'max'=>30),
			array('following, allow_all_act_msg, geo_enabled, verified, allow_all_comment, follow_me, lang', 'length', 'max'=>5),
			array('verified_type', 'length', 'max'=>4),
			array('regions', 'length', 'max'=>20),
			array('status', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sina_uid, idstr, screen_name, name, province, city, location, description, url, profile_image_url, cover_image, profile_url, domain, weihao, gender, followers_count, friends_count, statuses_count, favourites_count, created_at, following, allow_all_act_msg, geo_enabled, verified, verified_type, remark, status, allow_all_comment, avatar_large, verified_reason, follow_me, online_status, bi_followers_count, lang, star, mbtype, mbrank, block_word, is_del, creation_date, verified_my, regions', 'safe', 'on'=>'search'),
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
			'tokenInfo'=>array(self::BELONGS_TO, 'token', 'sina_uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'sina_uid'			=> '新浪用户ID',
            'idstr'				=> '新浪用户ID 字符串型',
            'screen_name'		=> '新浪昵称',
            'name'				=> '友好显示名称',
            'province'			=> '所在省级ID',
            'city'				=> '所在城市ID',
            'location'			=> '所在地',
            'description'		=> '个人描述',
            'url'				=> '博客',
            'profile_image_url'	=> '头像',
            'cover_image'		=> '背景图',
            'profile_url'		=> '用户微博统一URL',
            'domain'			=> '个性化域名',
            'weihao'			=> '微号',
            'gender'			=> '性别',
            'followers_count'	=> '粉丝数量',
            'friends_count'		=> '关注数量',
            'statuses_count'	=> '微博数量',
            'favourites_count'	=> '收藏数量',
            'created_at'		=> '注册时间',
            'following'			=> '暂未支持',
            'allow_all_act_msg'	=> '允许发私信',
            'geo_enabled'		=> '允许标识地理位置',
            'verified'			=> '是否认证用户',
            'verified_type'		=> '认证类型',
            'remark'			=> '用户备注信息',
            'status'			=> '最近一条微博信息',
            'allow_all_comment'	=> '允许对微博评论',
            'avatar_large'		=> '大头像',
            'verified_reason'	=> '认证原因',
            'follow_me'			=> '是否关注当前用户',
            'online_status'		=> '在线状态',
            'bi_followers_count'=> '互粉数',
            'lang'				=> '语言',
            'star'				=> '是否明星',
            'mbtype'			=> '暂无支持',
            'mbrank'			=> '暂无支持',
            'block_word'		=> '暂无支持',
            'is_del'			=> '是否删除',
            'creation_date'		=> '授权时间',
            'verified_my'		=> '自定义用户类型',
            'regions'			=> 'Regions',
        );
	}

	/**
	 * 属性类型(non-PHPdoc)
	 * @see Ar::attributeTypes()
	 */
	public function attributeTypes()
	{
		return array(
			'gender'=>array(
				'm' => '男',
				'f' => '女',
				'n' => '未知',
			),
			'allow_all_act_msg'=>array(
				'true'	=> '允许',
				'false'	=> '不允许',
			),
			'geo_enabled'=>array(
				'true'	=> '允许',
				'false'	=> '不允许',
			),
			'verified'=>array(
				'true'	=> '是',
				'false'	=> '否',
			),
			'allow_all_comment'=>array(
				'true'	=> '允许',
				'false'	=> '不允许',
			),
			'follow_me'=>array(
				'Y'	=> '是',
				'N'	=> '否',
			),
			'online_status'=>array(
				'1'	=> '在线',
				'0'	=> '不在线',
			),
			'online_status'=>array(
				'zh-cn'	=> '简体中文',
				'zh-tw'	=> '繁体中文',
				'en'	=> '英语',
			),
			'verified_my'=>array(
				'1'	=> '普通用户',
				'2'	=> '达人用户',
				'3'	=> '名人用户',
				'4'	=> '企业用户',
			),
			'is_del'=>array(
				'Y'	=> '是',
				'N'	=> '否',
			),
			'province'=>CHtml::listData(Province::model()->findAll(), 'id', 'province_name'),
		);
	}
	
	/**
	 * 验证前操作
	 * @see CModel::beforeValidate()
	 */
	public function beforeValidate()
	{
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

		$criteria->compare('sina_uid',$this->sina_uid);
		$criteria->compare('idstr',$this->idstr,true);
		$criteria->compare('screen_name',$this->screen_name,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('province',$this->province);
		$criteria->compare('city',$this->city);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('profile_image_url',$this->profile_image_url,true);
		$criteria->compare('cover_image',$this->cover_image,true);
		$criteria->compare('profile_url',$this->profile_url,true);
		$criteria->compare('domain',$this->domain,true);
		$criteria->compare('weihao',$this->weihao,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('followers_count',$this->followers_count,true);
		$criteria->compare('friends_count',$this->friends_count,true);
		$criteria->compare('statuses_count',$this->statuses_count,true);
		$criteria->compare('favourites_count',$this->favourites_count,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('following',$this->following,true);
		$criteria->compare('allow_all_act_msg',$this->allow_all_act_msg,true);
		$criteria->compare('geo_enabled',$this->geo_enabled,true);
		$criteria->compare('verified',$this->verified,true);
		$criteria->compare('verified_type',$this->verified_type,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('allow_all_comment',$this->allow_all_comment,true);
		$criteria->compare('avatar_large',$this->avatar_large,true);
		$criteria->compare('verified_reason',$this->verified_reason,true);
		$criteria->compare('follow_me',$this->follow_me,true);
		$criteria->compare('online_status',$this->online_status);
		$criteria->compare('bi_followers_count',$this->bi_followers_count);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('star',$this->star);
		$criteria->compare('mbtype',$this->mbtype);
		$criteria->compare('mbrank',$this->mbrank);
		$criteria->compare('block_word',$this->block_word);
		$criteria->compare('verified_my',$this->verified_my);
		$criteria->compare('regions',$this->regions,true);
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
	 * 更新微博用户信息
	 * @param  Int         $userId         用户ID
	 * @param  String     $accessToken 微博TOKEN
	 * @param  Array    $userInfo     用户信息
	 * @return boolean
	 */
	public function updateUser($userId, $accessToken, $userInfo=array())
	{
		if (empty($userInfo)) {
			// 获取最新微博用户信息
			$oauth		= new SinaSdk(Yii::app()->params['wb_akey'], Yii::app()->params['wb_skey'], $accessToken);
			$userInfo   = $oauth->show_user_by_id($userId);
		}
	
		$model = new User();
		// 判断用户是否存在
		$model = $model->findByPk($userId);
		if (empty($model)) {
			$model = new User();
		}
	
		$userInfo['verified_my']	= !empty($userInfo['verified_my']) ? $userInfo['verified_my'] : '1';
		$userInfo['regions']		= !empty($userInfo['regions']) ? $userInfo['regions'] : '';
	
		$model->sina_uid			= $userId;
		$model->idstr				= $userInfo['idstr'];
		$model->screen_name			= $userInfo['screen_name'];
		$model->name				= $userInfo['name'];
		$model->province			= $userInfo['province'];
		$model->city				= $userInfo['city'];
		$model->location			= $userInfo['location'];
		$model->description			= $userInfo['description'];
		$model->url					= $userInfo['url'];
		$model->profile_image_url	= $userInfo['profile_image_url'];
		$model->cover_image			= $userInfo['cover_image'];
		$model->profile_url			= $userInfo['profile_url'];
		$model->domain				= $userInfo['domain'];
		$model->weihao				= $userInfo['weihao'];
		$model->gender				= $userInfo['gender'];
		$model->followers_count		= $userInfo['followers_count'];
		$model->friends_count		= $userInfo['friends_count'];
		$model->statuses_count		= $userInfo['statuses_count'];
		$model->favourites_count	= $userInfo['favourites_count'];
		$model->created_at			= $userInfo['created_at'];
		$model->following			= $userInfo['following'];
		$model->allow_all_act_msg	= $userInfo['allow_all_act_msg'];
		$model->geo_enabled			= $userInfo['geo_enabled'];
		$model->verified			= $userInfo['verified'];
		$model->verified_type		= $userInfo['verified_type'];
		$model->remark				= $userInfo['remark'];
		$model->status				= $userInfo['status'];
		$model->allow_all_comment	= $userInfo['allow_all_comment'];
		$model->avatar_large		= $userInfo['avatar_large'];
		$model->verified_reason		= $userInfo['verified_reason'];
		$model->follow_me			= $userInfo['follow_me'];
		$model->online_status		= $userInfo['online_status'];
		$model->bi_followers_count	= $userInfo['bi_followers_count'];
		$model->lang				= $userInfo['lang'];
		$model->star				= $userInfo['star'];
		$model->mbtype				= $userInfo['mbtype'];
		$model->mbrank				= $userInfo['mbrank'];
		$model->block_word			= $userInfo['block_word'];
		$model->verified_my			= $userInfo['verified_my'];
		$model->regions				= $userInfo['regions'];
	
		return $model->save() ? true : false;
	}
	
	/**
	 * 获取用户信息
	 * @param  Int $userId
	 * @return Ambigous <CActiveRecord, mixed, NULL, multitype:, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:unknown >
	 */
	public function getUserInfo($userId)
	{
		$info = array();
		$data = $this->findByPk($userId);
		if (!empty($data)) {
			$info = JYii::objectToArray($data);
		}
	
		return $info;
	}
	
	/**
	 *  Note   :    获取条最新用户信息
	 *  Author : songyanjun
	 *  prarm  :    $num (获取的条数)
	 *  return ：     array()
	 *  Date   : 2013.03.20
	 */
	public function getUserList($num='10') {
		$criteria=new CDbCriteria;
		$criteria->select = 'sina_uid, screen_name, profile_image_url';
		if(!empty($num)) {
			$criteria->limit = $num;
		}
		$criteria->addCondition("is_del = 'N'");
		$criteria->order = 'creation_date DESC';
		$data = $this->findAll($criteria);
	
		return !empty($data) ? JYii::objectToArray($data) : array();
	}
	
	/**
	 * 获取信息异常用户列表
	 *
	 * @return Array <multitype:, multitype:NULL >
	 */
	public function getErrorUserList()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("screen_name IS NULL");
		$data = $this->findAll($criteria);
	
		return !empty($data) ? JYii::objectToArray($data) : array();
	}
}