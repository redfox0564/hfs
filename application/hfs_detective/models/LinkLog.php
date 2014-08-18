<?php

/**
 * This is the model class for table "link_log".
 *
 * The followings are the available columns in table 'link_log':
 * @property string $id
 * @property string $user_id
 * @property integer $link_id
 * @property string $is_del
 * @property integer $creation_date
 */
class LinkLog extends Ar
{
	/**
	 * dbNAME
	 * @var unknown_type
	 */
	public $dbname = 'db';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LinkLog the static model class
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
		return 'link_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link_id', 'required'),
			array('link_id, other_id, creation_date', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>50),
			array('is_del', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, link_id, other_id, is_del, creation_date', 'safe', 'on'=>'search'),
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
			'id' => '编号',
			'user_id' => '用户ID',
			'link_id' => '链接ID',
			'other_id' => '产品列表',
			'is_del' => '是否删除',
			'creation_date' => '点击时间',
		);
	}

	/**
	 * 属性类型(non-PHPdoc)
	 * @see Ar::attributeTypes()
	 */
	public function attributeTypes()
	{
		return array(
			'link_id'=>array(
                1 => '点击1',
                2 => '点击2',
                3 => '点击3',
			),
            'other_id' => CHtml::listData(ProductSet::model()->findAll(), 'id', 'product_name'),
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
			$this->is_del 			= 'N';
			$this->creation_date 	= time();
		}
		return parent::beforeSave() && !$this->hasErrors();
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($num=10)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('link_id',$this->link_id);
		$criteria->compare('other_id',$this->other_id);
		//$criteria->compare('creation_date',$this->creation_date);
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
	 * 添加超链接点击日志
	 * 
	 * @author TianLongZhe
	 * 
	 * @param  Int $linkId 超链接ID
	 * @param  Int $otherId 备用ID - 产品ID
	 * @return boolean
	 */
	public function addLinkLog($userId, $linkId, $otherId = 0) {
		if ( empty($userId) || empty($linkId)) {
			return false;
		}
	
		$model = new LinkLog();
		$model->user_id = $userId;
		$model->link_id = $linkId;
		$model->other_id = intval($otherId);
        
        /* if (!$model->save()) {
            error_log(print_r($model->errors, true)."\n", 3, '/tmp/huasu'.date('Y-m-d'));
        } */
        
		return $model->save() ? true : false;
	}
    
    /**
     *  update By yanghongwei @2014/06/03
     *  产品 - 统计
     */
    public function countLinkByAttr($linkId = NULL, $productId)
    {
        if ( !empty($productId) ) {
            $criteria = new CDbCriteria;
            if ( !empty($linkId) ) {
                $criteria->addCondition("link_id = '{$linkId}'");
            }
            $criteria->addCondition("other_id = '{$productId}'");
            $criteria->addCondition('is_del = "N"');
            $count    = $this->count($criteria);
            return !empty($count) ? $count : 0;
        } else 
            return 0;
    }
}