<?php

/**
 * This is the model class for table "offer_detail".
 *
 * The followings are the available columns in table 'offer_detail':
 * @property string $id
 * @property string $app_name
 * @property string $company_name
 * @property integer $ae
 * @property string $itunesurl
 * @property string $clk_link
 * @property integer $send_type
 * @property string $active_mode
 * @property string $callback_period
 * @property integer $api_type
 * @property string $platform
 * @property string $system_version
 * @property string $done_note
 * @property string $note
 */
class OfferDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'offer_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('app_name, ae send_type, active_mode, platform, system_version', 'required'),
			array('ae, send_type, api_type', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('app_name, company_name', 'length', 'max'=>50),
			array('itunesurl', 'length', 'max'=>100),
			array('clk_link', 'length', 'max'=>2048),
			array('active_mode, callback_period, platform, system_version', 'length', 'max'=>60),
			array('done_note, itunesurl, clk_link, callback_period, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, app_name, company_name, ae, itunesurl, clk_link, send_type, active_mode, callback_period, api_type, platform, system_version, done_note, note', 'safe', 'on'=>'search'),
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
			'psInfoSale'=>array(self::BELONGS_TO,'PsInfo','sale'),
			'psInfoAe'=>array(self::BELONGS_TO,'PsInfo','ae'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'app_name' => 'App Name',
			'company_name' => 'Company Name',
			'ae' => 'Ae',
			'itunesurl' => 'Itunesurl',
			'clk_link' => 'Clk Link',
			'send_type' => 'Send Type',
			'active_mode' => 'Active Mode',
			'callback_period' => 'Callback Period',
			'api_type' => 'Api Type',
			'platform' => 'Platform',
			'system_version' => 'System Version',
			'done_note' => 'Done Note',
			'note' => 'Note',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('app_name',$this->app_name,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('ae',$this->ae);
		$criteria->compare('itunesurl',$this->itunesurl,true);
		$criteria->compare('clk_link',$this->clk_link,true);
		$criteria->compare('send_type',$this->send_type);
		$criteria->compare('active_mode',$this->active_mode,true);
		$criteria->compare('callback_period',$this->callback_period,true);
		$criteria->compare('api_type',$this->api_type);
		$criteria->compare('platform',$this->platform,true);
		$criteria->compare('system_version',$this->system_version,true);
		$criteria->compare('done_note',$this->done_note,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfferDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
