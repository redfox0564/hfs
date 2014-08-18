<?php

/**
 * This is the model class for table "hfs_det_pubwinner".
 *
 * The followings are the available columns in table 'hfs_det_pubwinner':
 * @property string $id
 * @property string $name
 * @property string $phone
 * @property string $type
 * @property string $win_seasonid
 * @property string $win_time
 */
class HfsDetPubwinner extends Ar
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HfsDetPubwinner the static model class
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
		return 'hfs_det_pubwinner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, phone, type, win_seasonid, win_time', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, phone, type, win_seasonid, win_time', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'name' => '微信昵称',
			'phone' => '手机号',
			'type' => '中奖类型',
			'win_seasonid' => '猜中季',
			'win_time' => '猜中时间',
		);
	}
	
	public function attributeTypes()
	{
		return array(
			'win_seasonid' => array(
					1=>'第一季',
					2=>'第二季',
					3=>'第三季',
					4=>'第四季',
			),
			'type' => array(1=>'实力音乐侦探',2=>'金牌实力音乐侦探',3=>'神探“海”尔摩斯'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('win_seasonid',$this->win_seasonid,true);
		$criteria->compare('win_time',$this->win_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
