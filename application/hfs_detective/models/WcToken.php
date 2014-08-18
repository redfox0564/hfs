<?php

/**
 * This is the model class for table "wc_token".
 *
 * The followings are the available columns in table 'wc_token':
 * @property string $openid
 * @property string $access_token
 * @property string $refresh_token
 * @property string $expires_in
 * @property string $scope
 * @property string $is_del
 * @property integer $creation_date
 */
class WcToken extends Ar
{
    /**
     * 返回数据表所在的库名
     * @return 返回Token的数据库名
     */
    public $dbname = 'db';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WcToken the static model class
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
		return 'wc_token';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('openid, access_token, refresh_token, expires_in, scope, creation_date', 'required'),
			array('creation_date', 'numerical', 'integerOnly'=>true),
			array('openid', 'length', 'max'=>50),
			array('access_token, refresh_token', 'length', 'max'=>255),
			array('expires_in', 'length', 'max'=>15),
			array('scope', 'length', 'max'=>32),
			array('is_del', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('openid, access_token, refresh_token, expires_in, scope, is_del, creation_date', 'safe', 'on'=>'search'),
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
			'access_token'  => '微信用户 昵称',
			'refresh_token' => '微信用户 性别',
			'expires_in'    => '微信用户 省',
			'scope'         => '微信用户 市',
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
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('openid',$this->openid,true);
		$criteria->compare('access_token',$this->access_token,true);
		$criteria->compare('refresh_token',$this->refresh_token,true);
		$criteria->compare('expires_in',$this->expires_in,true);
		$criteria->compare('scope',$this->scope,true);
		$criteria->compare('is_del',$this->is_del,true);
		$criteria->compare('creation_date',$this->creation_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * 更新用户微信token信息
     * @author yanghongwei
     * @param  Int      $openId 用户openID
     * @param  Array    $data   数据
     * @return boolean
     */
    public function updateToken($openId, $data)
    {
        //  记录token数据
        $model = new WcToken();
        
        //  判断用户是否存在
        $model = $model->findByPk($openId);
        if (empty($model)) {
            $model = new WcToken();
        }
        $model->openid          = $openId;
        $model->access_token    = isset($data['access_token']) && !empty($data['access_token']) ? $data['access_token'] : $model->access_token;
        $model->refresh_token   = isset($data['refresh_token']) && !empty($data['refresh_token']) ? $data['refresh_token'] : $model->refresh_token;
        $model->expires_in      = isset($data['expires_in']) && !empty($data['expires_in']) ? $data['expires_in'] : $model->expires_in;
        $model->scope           = isset($data['scope']) && !empty($data['scope']) ? $data['scope'] : $model->scope;
        
        return $model->save() ? TRUE : FALSE;
    }
    
    /**
     * 获取用户微信token信息
     * @author yanghongwei
     * @param  Int      $openId 用户openID
     * @return array()
     */
    public function getTokenInfo($openId)
    {
        // 记录token数据
        $model = new WcToken();
        
        // 判断用户是否存在
        $model = $model->findByPk($openId);
        
        return !empty($model) && count($model) > 0 ? JYii::objectToArray($model): array();
    }
    
    /**
     * 删除用户授权Token信息
     * @param  Int 	  $openId 用户openID
     * @return Bool() true Success; false Failed.
     */
    public function deleteToken($openId)
    {
    	$model      = new WcToken();
    	$deleteRes  = $model->deleteByPk($openId);
    
    	return (count($deleteRes) > 0) ? TRUE : FALSE;
    }
    
}