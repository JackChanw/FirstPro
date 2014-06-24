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
class DeviceInfoForm extends DeviceInfo
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
	
	public function searchAllDeviceName()
	{
	    return DeviceInfo::model()->findAllBySql("select * from device_info");
	}

	public function searchAllDeviceInfo($info)
	{
	    $id = $info[0];
	    return DeviceInfo::model()->findAllBySql('select DMAC_UPPER, IDFA, OPEN_UDID_LOWER from device_info where id=:id', array(':id'=>$id));
	}

}
