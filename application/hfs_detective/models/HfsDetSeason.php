<?php

/**
 * This is the model class for table "hfs_det_season".
 *
 * The followings are the available columns in table 'hfs_det_season':
 * @property string $id
 * @property string $season
 * @property string $answer
 * @property string $starttime
 * @property string $endtime
 * @property string $answer_pub_time
 * @property string $uptime
 */
class HfsDetSeason extends Ar
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HfsDetSeason the static model class
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
		return 'hfs_det_season';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('season, answer, starttime, endtime, answer_pub_time, uptime', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, season, answer, starttime, endtime, answer_pub_time, uptime', 'safe', 'on'=>'search'),
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
	
	public function attributeTypes()
	{
		return array(
			'season' => array(
					1=>'第一季',
					2=>'第二季',
					3=>'第三季',
					4=>'第四季',
			),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'season' => '季',
			'answer' => '答案',
			'starttime' => '开始时间',
			'endtime' => '结束时间',
			'answer_pub_time' => '答案发布时间',
			'uptime' => '更新时间',
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
		$criteria->compare('season',$this->season,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('starttime',$this->starttime,true);
		$criteria->compare('endtime',$this->endtime,true);
		$criteria->compare('answer_pub_time',$this->answer_pub_time,true);
		$criteria->compare('uptime',$this->uptime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
