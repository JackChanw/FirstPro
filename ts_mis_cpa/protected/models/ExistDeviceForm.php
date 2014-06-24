<?php


class ExistDeviceForm extends CFormModel
{
    public $itunes_id; 
    public $device_id;
    
    public function rules()
    {
	return array(
	    array('itunes_id, device_id', 'required'),
	    array('itunes_id', 'length', 'max'=>10), 
	    array('device_id', 'length', 'max'=>45),	    
	    );
    }


    //update
    public function update($device_id) {
	$arr = explode(',', $device_id);
	if (!in_array($this->device_id, $arr)) {
	    array_push($arr, $this->device_id);
	    $deviceIdList = join(',', $arr);
	    $count = ExistDeviceRecord::model()->updateAll(array('device_id'=>$deviceIdList), 'itunes_id=:itunes_id', array('itunes_id'=>$this->itunes_id));
	    if ($count<=0) 
		return false;
	}
	return true;
    }


    //dispatch
    public function dispatch(){
	$device = $this->findExistDevice();
	if($device === NULL){
	    return $this->save();
	}
	return $this->update($device->device_id);	
    }

    //findExistDevice
    public function findExistDevice(){
	$criteria=new CDbCriteria; 
	$criteria->select='device_id'; 
	$criteria->condition='itunes_id=:itunes_id'; 
	$criteria->params=array(':itunes_id'=>$this->itunes_id);
	return ExistDeviceRecord::model()->find($criteria);
    }


    //save
    public function save(){
	$existDevice = new ExistDeviceRecord;
	$existDevice->attributes = $this->getAttributes();
	if($existDevice->save()>0){
	    return true;
	}
	return false;
    }

    //get itunes id
    public function getItunesId($itunes){
		preg_match('/id\d{9,}/', $itunes, $id);
		if(!empty($itunes) && !empty($id)){
			return substr($id[0], 2);
		}else{
		    #为了支持广告主对接时itunes不存或不合法，特意加上一个临时itunes地址
		    $tmpItunes = 'https://itunes.apple.com/cn/app/domob-test-ts/id000000000?mt=8';
			preg_match('/id\d{9,}/', $tmpItunes, $id);
			return substr($id[0], 2);
			//throw new Exception('itunes invalid'); 
		    }

    }



}
