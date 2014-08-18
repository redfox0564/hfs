<?php

/**
 * This is the model class for table "token".
 *
 * The followings are the available columns in table 'token':
 * @property string $sina_uid
 * @property string $oauth_token
 * @property string $remind_in
 * @property integer $expires_in
 * @property integer $creation_date
 */
class Token extends Ar
{
    /**
     * 返回数据表所在的库名
     * @return 返回Token的数据库名
     */
    public $dbname = 'db';
    /**
     * 返回指定的AR类的静态模型
     * @return Token the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string 相关的数据库表名
     */
    public function tableName()
    {
        return 'token';
    }

    /**
     * @return array 模型属性的验证规则
     */
    public function rules()
    {
        // 提示: 你只需要对用户输入的属性定义验证规则
        return array(
            array('sina_uid, oauth_token, remind_in, expires_in', 'required'),
            array('expires_in, creation_date', 'numerical', 'integerOnly'=>true),
            array('sina_uid', 'length', 'max'=>13),
            array('oauth_token', 'length', 'max'=>32),
            array('remind_in', 'length', 'max'=>10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('sina_uid, oauth_token, remind_in, expires_in, creation_date', 'safe', 'on'=>'search'),
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
            'sina_uid' => '新浪ID',
            'oauth_token' => '认证KEY',
            'remind_in' => '提醒时间',
            'expires_in' => '到期时间',
            'creation_date' => '创建时间',
        );
    }

    /**
     * 保存前操作
     * @see CActiveRecord::beforeSave()
     */
    public function beforeSave()
    {
        if ($this->getIsNewRecord())
        {
            $this->creation_date = time();
        }
        return parent::beforeSave() && !$this->hasErrors();
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

        $criteria->compare('sina_uid',$this->sina_uid,true);
        $criteria->compare('oauth_token',$this->oauth_token,true);
        $criteria->compare('remind_in',$this->remind_in,true);
        $criteria->compare('expires_in',$this->expires_in);
        $criteria->compare('creation_date',$this->creation_date);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
     * 更新用户微博token信息
     * @param  Int      $userId 用户ID
     * @param  Array $data     数据
     * @return boolean
     */
    public function updateToken($userId, $data)
    {
        // 记录token数据
        $model = new Token();
        // 判断用户是否存在
        $model = $model->findByPk($userId);
        if (empty($model)) {
            $model = new Token();
        }
        $model->sina_uid     = $userId;
        $model->oauth_token = $data['access_token'];
        $model->remind_in     = $data['remind_in'];
        $model->expires_in     = $data['expires_in'];
        return $model->save() ? true : false;
    }

    /**
     * 获取用户微博token信息
     * @param  Int      $userId 用户ID
     * @return array()
     */
    public function getTokenInfo($userId)
    {
        // 记录token数据
        $model = new Token();
        // 判断用户是否存在
        $model = $model->findByPk($userId);
        return !empty($model) && count($model) > 0 ? JYii::objectToArray($model): array();
    }
    
    /**
     * 删除用户授权Token信息
     * @param  Int 	 $userId 用户ID
     * @return Bool() true Success; false Failed.
     */
    public function deleteToken($userId)
    {
    	$model = new Token();
    	$deleteRes = $model->deleteByPk($userId);
    
    	return (count($deleteRes) > 0) ? true : false;
    }
}
