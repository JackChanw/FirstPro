<?php

/**
 * This is the model class for table "exist_device".
 *
 * The followings are the available columns in table 'exist_device':
 * @property integer $ed_id
 * @property integer $itunes_id
 * @property string $device_id
 */
class ExistDeviceRecord extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ExistDeviceRecord the static model class
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
		return 'exist_device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itunes_id, device_id', 'required'),
			array('itunes_id', 'numerical', 'integerOnly'=>true),
			array('device_id', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ed_id, itunes_id, device_id', 'safe', 'on'=>'search'),
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
			'ed_id' => 'Ed',
			'itunes_id' => 'Itunes',
			'device_id' => 'Device',
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

		$criteria->compare('ed_id',$this->ed_id);

		$criteria->compare('itunes_id',$this->itunes_id);

		$criteria->compare('device_id',$this->device_id,true);

		return new CActiveDataProvider('ExistDeviceRecord', array(
			'criteria'=>$criteria,
		));
	}
}