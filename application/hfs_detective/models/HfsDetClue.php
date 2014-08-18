<?php

/**
 * This is the model class for table "hfs_det_clue".
 *
 * The followings are the available columns in table 'hfs_det_clue':
 * @property string $id
 * @property string $clue_id
 * @property string $season_id
 * @property integer $clue_type
 * @property string $clue_addr
 * @property string $starttime
 * @property string $uptime
 */
class HfsDetClue extends Ar
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HfsDetClue the static model class
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
		return 'hfs_det_clue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clue_type', 'numerical', 'integerOnly'=>true),
			array('clue_id', 'length', 'max'=>11),
			array('season_id, starttime, uptime', 'length', 'max'=>128),
			array('clue_addr', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, clue_id, season_id, clue_type, clue_addr, starttime, uptime', 'safe', 'on'=>'search'),
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
			'clue_id' => '线索id',
			'season_id' => '季',
			'clue_type' => '线索类型',
			'clue_addr' => '线索地址',
			'starttime' => '开始时间',
			'uptime' => '更新时间',
		);
	}

	public function attributeTypes()
	{ 
		return array(
			'clue_id' => array(
				'1' => '第一条',
				'2' => '第二条',
				'3' => '第三条',
			),
			'season_id' => array(
				1=>'第一季',
				2=>'第二季',
				3=>'第三季',
				4=>'第四季',
			),
			'clue_type' => array(
				1=>'图片',
				2=>'视频',
			),
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
		$criteria->compare('clue_id',$this->clue_id,true);
		$criteria->compare('season_id',$this->season_id,true);
		$criteria->compare('clue_type',$this->clue_type);
		$criteria->compare('clue_addr',$this->clue_addr,true);
		$criteria->compare('starttime',$this->starttime,true);
		$criteria->compare('uptime',$this->uptime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
