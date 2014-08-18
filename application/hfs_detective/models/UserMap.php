<?php

/**
 * This is the model class for table "user_map".
 *
 * The followings are the available columns in table 'user_map':
 * @property string $sina_uid
 * @property string $ot_uid
 * @property integer $type
 * @property string $is_del
 * @property integer $creation_date
 */
class UserMap extends Ar
{
	/**
	 * 返回数据表所在的库名
	 * @return 返回User的数据库名
	 */
	public $dbname = 'db';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserMap the static model class
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
		return 'user_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sina_uid, ot_uid', 'required'),
			array('type, creation_date', 'numerical', 'integerOnly'=>true),
			array('sina_uid', 'length', 'max'=>13),
			array('ot_uid', 'length', 'max'=>32),
			array('is_del', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sina_uid, ot_uid, type, is_del, creation_date', 'safe', 'on'=>'search'),
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
			'sina_uid'      => '新浪用户ID',
			'ot_uid'        => '其他社交ID',
			'type'          => '对应类型',
			'is_del'        => '是否删除',
			'creation_date' => '创建日期',
		);
	}
    
	/**
	 * 属性类型(non-PHPdoc)
	 * @see Ar::attributeTypes()
	 */
	public function attributeTypes()
	{
        return array (
            'type' => array (
                1 => 'Sina微博 To 微信',
            ),
			'is_del'=>array(
				'Y'	=> '是',
				'N'	=> '否',
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
		return parent::afterSave() && !$this->hasErrors();
	}
    
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($num = '10')
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sina_uid',$this->sina_uid,true);
		$criteria->compare('ot_uid',$this->ot_uid,true);
		$criteria->compare('type',$this->type);
		//$criteria->compare('is_del',$this->is_del,true);
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
}