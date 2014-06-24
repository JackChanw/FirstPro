<?php

/**
 * This is the model class for table "device_info".
 *
 * The followings are the available columns in table 'device_info':
 * @property integer $id
 * @property string $machine_name
 * @property string $DMAC_UPPER
 * @property string $DMAC_LOWER
 * @property string $DMAC_PURE_NUM
 * @property string $DMAC_PURE_NUM_LOWER
 * @property string $MD5_MAC
 * @property string $OPEN_UDID
 * @property string $OPEN_UDID_LOWER
 * @property string $IDFA
 * @property string $NOCOLONIDFA
 * @property string $IDFA_LOWER
 * @property string $NOCOLONIDFA_LOWER
 * @property string $MAC_OR_IDFA
 */
class DeviceInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeviceInfo the static model class
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
		return 'device_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DMAC_PURE_NUM, DMAC_PURE_NUM_LOWER, MD5_MAC, OPEN_UDID, OPEN_UDID_LOWER, IDFA, NOCOLONIDFA, IDFA_LOWER, NOCOLONIDFA_LOWER, MAC_OR_IDFA', 'required'),
			array('machine_name', 'length', 'max'=>30),
			array('DMAC_UPPER, DMAC_LOWER, DMAC_PURE_NUM, DMAC_PURE_NUM_LOWER, MD5_MAC, OPEN_UDID, OPEN_UDID_LOWER, IDFA, NOCOLONIDFA, IDFA_LOWER, NOCOLONIDFA_LOWER, MAC_OR_IDFA', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, machine_name, DMAC_UPPER, DMAC_LOWER, DMAC_PURE_NUM, DMAC_PURE_NUM_LOWER, MD5_MAC, OPEN_UDID, OPEN_UDID_LOWER, IDFA, NOCOLONIDFA, IDFA_LOWER, NOCOLONIDFA_LOWER, MAC_OR_IDFA', 'safe', 'on'=>'search'),
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
			'machine_name' => 'Machine Name',
			'DMAC_UPPER' => 'Dmac Upper',
			'DMAC_LOWER' => 'Dmac Lower',
			'DMAC_PURE_NUM' => 'Dmac Pure Num',
			'DMAC_PURE_NUM_LOWER' => 'Dmac Pure Num Lower',
			'MD5_MAC' => 'Md5 Mac',
			'OPEN_UDID' => 'Open Udid',
			'OPEN_UDID_LOWER' => 'Open Udid Lower',
			'IDFA' => 'Idfa',
			'NOCOLONIDFA' => 'Nocolonidfa',
			'IDFA_LOWER' => 'Idfa Lower',
			'NOCOLONIDFA_LOWER' => 'Nocolonidfa Lower',
			'MAC_OR_IDFA' => 'Mac Or Idfa',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('machine_name',$this->machine_name,true);
		$criteria->compare('DMAC_UPPER',$this->DMAC_UPPER,true);
		$criteria->compare('DMAC_LOWER',$this->DMAC_LOWER,true);
		$criteria->compare('DMAC_PURE_NUM',$this->DMAC_PURE_NUM,true);
		$criteria->compare('DMAC_PURE_NUM_LOWER',$this->DMAC_PURE_NUM_LOWER,true);
		$criteria->compare('MD5_MAC',$this->MD5_MAC,true);
		$criteria->compare('OPEN_UDID',$this->OPEN_UDID,true);
		$criteria->compare('OPEN_UDID_LOWER',$this->OPEN_UDID_LOWER,true);
		$criteria->compare('IDFA',$this->IDFA,true);
		$criteria->compare('NOCOLONIDFA',$this->NOCOLONIDFA,true);
		$criteria->compare('IDFA_LOWER',$this->IDFA_LOWER,true);
		$criteria->compare('NOCOLONIDFA_LOWER',$this->NOCOLONIDFA_LOWER,true);
		$criteria->compare('MAC_OR_IDFA',$this->MAC_OR_IDFA,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}