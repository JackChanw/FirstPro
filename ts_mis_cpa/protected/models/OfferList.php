<?php

/**
 * This is the model class for table "offer_list".
 *
 * The followings are the available columns in table 'offer_list':
 * @property string $id
 * @property integer $sale_id
 * @property integer $sid
 * @property integer $pri_level
 * @property integer $status
 * @property integer $commit_dt
 * @property integer $online_dt
 * @property integer $claim_dt
 * @property integer $done_dt
 */
class OfferList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'offer_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, pri_level, commit_dt, online_dt, claim_dt', 'required'),
			array('sid, pri_level, status, commit_dt, online_dt, claim_dt, done_dt', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sid, pri_level, status, commit_dt, online_dt, claim_dt, done_dt', 'safe', 'on'=>'search'),
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
			'offerDetail'=>array(self::BELONGS_TO,'OfferDetail','sid'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sid' => 'Sid',
			'pri_level' => 'Pri Level',
			'status' => 'Status',
			'commit_dt' => 'Commit Dt',
			'online_dt' => 'Online Dt',
			'claim_dt' => 'Claim Dt',
			'done_dt' => 'Done Dt',
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
		$criteria->compare('sid',$this->sid);
		$criteria->compare('pri_level',$this->pri_level);
		$criteria->compare('status',$this->status);
		$criteria->compare('commit_dt',$this->commit_dt);
		$criteria->compare('online_dt',$this->online_dt);
		$criteria->compare('claim_dt',$this->claim_dt);
		$criteria->compare('done_dt',$this->done_dt);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfferList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
