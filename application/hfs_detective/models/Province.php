<?php

/**
 * This is the model class for table "province".
 *
 * The followings are the available columns in table 'province':
 * @property string $id
 * @property string $province_name
 * @property string $longitude
 * @property string $latitude
 * @property string $topic_count
 * @property string $false_count
 * @property string $is_del
 * @property string $creation_date
 */
class Province extends Ar
{
	/**
	 * 返回数据表所在的库名
	 * @return 返回Province的数据库名
	 */
	public $dbname = 'db';
	/**
	 * 返回指定的AR类的静态模型
	 * @return Province the static model class
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
		return 'province';
	}

	/**
	 * @return array 模型属性的验证规则
	 */
	public function rules()
	{
		// 提示: 你只需要对用户输入的属性定义验证规则
		return array(
			array('id, province_name, longitude, latitude, creation_date', 'required'),
			array('id, province_name, longitude, latitude, topic_count, false_count, creation_date', 'length', 'max'=>10),
			array('is_del', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, province_name, longitude, latitude, topic_count, false_count, is_del, creation_date', 'safe', 'on'=>'search'),
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
			'id' => '省份ID',
			'province_name' => '省份名称',
			'longitude' => '经度',
			'latitude' => '纬度',
			'topic_count' => '省份话题总数',
			'false_count' => '虚拟话题总数',
			'is_del' => 'Is Del',
			'creation_date' => '创建时间',
		);
	}
	
	/**
	 * 属性类型(non-PHPdoc)
	 * @see Ar::attributeTypes()
	 */
	public function attributeTypes()
	{
		return array(
			'is_del'=>array(
				'N'=>'否',
				'Y'=>'是',
			),
			'id'=>CHtml::listData($this->findAll(), 'id', 'province_name'),
		);
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('province_name',$this->province_name,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('topic_count',$this->topic_count,true);
		$criteria->compare('false_count',$this->false_count,true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->addCondition("is_del = 'N'");
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
