<?php

/**
 * This is the model class for table "cpa_info".
 *
 * The followings are the available columns in table 'cpa_info':
 * @property integer $id
 * @property string $appid
 * @property string $app_name
 * @property string $app_type
 * @property string $app_link
 * @property string $app_intunes
 * @property string $mac_type
 * @property string $source
 * @property string $send_mode
 * @property string $activate_mode
 * @property string $callback_period
 * @property integer $machine_id
 * @property string $dt
 * @property string $status
 * @property integer $user_id
 */
class CpaInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CpaInfo the static model class
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
		return 'cpa_info';
	}

	/** 
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{   
	    // NOTE: you should only define rules for those attributes that
	    // will receive user inputs.
	    return array(
		    array('app_name, appid, app_type, type, app_link, app_itunes, mac_type,send_mode,final_link,activate_mode,callback_period,dt,user_name,status,is_verify,note_info,app_version,custom_sign, offer_id', 'safe'),
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
			'appid' => 'Appid',
			'type' => 'Type',
			'app_name' => 'App Name',
			'app_type' => 'App Type',
			'app_link' => 'App Link',
			'app_itunes' => 'App Itunes',
			'mac_type' => 'Mac Type',
			'ifa' => 'Ifa',
			'ifa_type' => 'Ifa Type',
			'source' => 'Source',
			'send_mode' => 'Send Mode',
			'activate_mode' => 'Activate Mode',
			'callback_period' => 'Callback Period',
			'final_link' => 'Final Link',
			'machine_id' => 'Machine',
			'dt' => 'Dt',
			'status' => 'Status',
			'user_name' => 'User Name',
			'app_version' => 'App Version',
			'is_verify' => 'Is Verify',
			'custom_sign' => 'Custom Sign',
			'offer_id' => 'Offer Id',
		);
    }
    

    //插入数据
	public function insertData($data, $statusValue){    
		$newData = array();
		foreach($data as $k => $v){
			$newData[$k] = $this->actionUrlCode($v);
		}
		$repeat = $this->actionSearchRepeat($newData['appid'],$newData['appType'],$newData['appName']);
		$noedit = CpaInfo::model()->countBySql('select count(id) from cpa_info 
			where appid=:appid and app_name=:app_name and app_type=:app_type and status =1', 
			array(':appid'=>$newData['appid'], ':app_name'=>$newData['appName'], ':app_type'=>$newData['appType']));
		if($noedit <= 0){
			$cpainfo = new CpaInfo;
			$newData['dt'] = time();
			$newData['status'] = $statusValue;
			if($statusValue != 1){
				if($repeat == 0){
					$newData['app_version'] = 1;
				}else{
					$version = $this->Versioning($newData);
					$newData['app_version'] = $version + 1;
				}
			}
			$newData = $this->FieldCorresponding($newData);
			$cpainfo->attributes = $newData; 
			if($cpainfo->save()>0){
				if($statusValue == 1)
					return "{'callback':'Ci.AlertInfo', 'param':10000}";
				else
					return "{'callback':'Ci.AlertInfo', 'param':10004}";
			}else{
				return "{'callback':'Ci.AlertInfo', 'param':10003}";
			}
		}else{
			$newData = $this->FieldCorresponding($newData);
			$count = $this->createUpdate($newData, $statusValue);
			if($count>0){
				if($statusValue == 1)
					return "{'callback':'Ci.AlertInfo', 'param':10000}";
				else
					return "{'callback':'Ci.AlertInfo', 'param':10004}";
			}else{
				return "{'callback':'Ci.AlertInfo', 'param':10003}";
			}
	}
    }

    /**
     * 更新数据
     *
     */
     public function createUpdate($data, $status){
		if($status == 2){
			$version = $this->Versioning($data);
			if($version){
			$version = $version + 1;
			}else{
			$version = 1;
			}
		}else{
			$version = '';
		}
		$data['status'] = $status;
		$data['app_version'] = $version;
		$count = CpaInfo::model()->updateAll($data,
			'app_name=:app_name and appid=:appid and app_type=:app_type and app_version < 1',
			array(':app_name'=>$data['app_name'], ':appid'=>$data['appid'], 
				':app_type'=>$data['app_type']));	
		return $count;
     }

    /**
      * 编辑更新数据
      */
	public function updateData($data, $statusValue){

		$newData = array();
		foreach($data as $k => $v){
			$newData[$k] = $this->actionUrlCode($v);
		}
		$newData['status'] = $statusValue;
		$newData['app_version'] = 0; 
		$newData = $this->FieldCorresponding($newData);
		if($newData['offer_id']){
			$count = CpaInfo::model()->updateAll($newData,'offer_id=:offer_id',array(':offer_id'=>$newData['offer_id']));
		}else{
			$count = CpaInfo::model()->updateAll($newData,'app_version=0 and app_name=:app_name and appid=:appid and app_type=:app_type',array(':app_name'=>$newData['app_name'], 'appid'=>$newData['appid'], 'app_type'=>$newData['app_type']));
		
		}
		if($count>0){
			return "{'callback':'Ci.AlertInfo', 'param':10004}";
		}else{
			return "{'callback':'Ci.AlertInfo', 'param':10005}";
		}
	} 


   /**
     * 查找app是否重复
     */
    public function actionSearchRepeat($appid, $app_type, $app_name)
    {   
        //1代表已保存，2代表已存在
            $newStatus = CpaInfo::model()->countBySql('select count(id) from cpa_info 
		    where appid=:appid and app_name=:app_name and app_type=:app_type', 
                array(':appid'=>$appid, ':app_name'=>$app_name, ':app_type'=>$app_type));
         return $newStatus;
    }

    /**
     * 对数据进行urlcode编码替换
     */
    public function actionUrlCode($url){
        return str_replace('~','&',$url);
    }

    /**
     * 查找出所有的app
     */
    public function SelectApp($status){
        return CpaInfo::model()->findAll('status=:status',array(':status'=>$status));
    }

    /**
     * 删除app
     */
    public function DeleteApp($id){
        $cpainfo = CpaInfo::model()->deleteAll('id=:id',array(':id'=>$id));
    }

    /**
     * 查找单个app
     */
    public function SelectOneApp($id){
        return CpaInfo::model()->find('id=:id', array(':id'=>$id));
    }
	
    /**
     * 查找当前app下面的所有版本
     */
    public function SelectCurrentVersionAllApp($id){
        $app = CpaInfo::model()->findBySql('select app_name, app_type, appid from cpa_info where id=:id', array(':id'=>$id));
	return $allVersionApp = CpaInfo::model()->findAllBySql('select * from cpa_info where status = 2 
						and app_name=:app_name and app_type=:app_type and appid=:appid', 
					array(':app_name'=>$app->app_name, ':app_type'=>$app->app_type, ':appid'=>$app->appid));
		
    }

    /**
     * 分页
     *
     * @order       string 排序
     * @where       string 筛选条件
     * @pageSize    inter  每一页的项目数量。默认是10
     */
    public function page($order, $where, $pageSize){
        $criteria=new CDbCriteria;
        $criteria->order = $order;
        $criteria->addCondition($where);
        $total = CpaInfo::model()->count($criteria);
        $pages=new CPagination($total);
        $pages->pageSize= !empty($pageSize) ? $pageSize : 10;
        $pages->applyLimit($criteria);
        $list = CpaInfo::model()->findAll($criteria);
        return array('page'=>$pages, 'list'=>$list);
    }


    /**
     * sql分页
     *
     * @order       string 排序
     * @where       string 筛选条件
     * @pageSize    inter  每一页的项目数量。默认是10
     */
    public function infoPage($pageSize){
	$sql = "select * from (select * from cpa_info where status = 2 order by app_version desc) a group by appid,app_name,app_type order by dt desc";    
        $criteria=new CDbCriteria;
	$result = Yii::app()->db->createCommand($sql)->query();
	$pages=new CPagination($result->rowCount);
	$pages->pageSize=$pageSize; 
	$pages->applyLimit($criteria); 
	$result=Yii::app()->db->createCommand($sql." LIMIT :offset,:limit"); 
	$result->bindValue(':offset', $pages->currentPage*$pages->pageSize); 
	$result->bindValue(':limit', $pages->pageSize); 
	$list=$result->query();
	//查出来的是数组
        return array('pages'=>$pages, 'list'=>$list);
    }


    /**
     * 版本处理
     * @param	    array 提交上来的数据数组
     */
	public function Versioning($param){
		// appid appname apptype
		$param = $this->FieldCorresponding($param);
		$ver = CpaInfo::model()->findBySql('select app_version from cpa_info where appid=:appid and app_name=:app_name and 
			app_type=:app_type order by app_version desc limit 1',
			array(':appid'=>$param['appid'], ':app_name'=>$param['app_name'], ':app_type'=>$param['app_type']));
		if($ver === NULL)
			return false;
		else
			return $ver->app_version; 
    }

    /**
     * 字段对应
     */
    public function FieldCorresponding($data){
	$arr = array(
	    'appName' => 'app_name',
	    'appType' => 'app_type',
	    'extendLink' => 'app_link',
	    'itunes' => 'app_itunes',
	    'mac_type' => 'mac_type',
	    'activate' => 'activate_mode',
	    'callback' => 'callback_period',
	    'sendStyle' => 'send_mode',
	    'createLink' => 'final_link',
	    'noteinfo' => 'note_info',
	    'username' => 'user_name',
	    'verify' => 'is_verify',
	    'customsign' => 'custom_sign',
	);
	foreach($data as $k => $v){
	    if(array_key_exists($k, $arr))
		$newData[$arr[$k]] = $v;    
	    else
		$newData[$k] = $v;
	}
	return $newData;
    
    }

   /*
    * 查询回调
    */
    public function SearchCallBack($appid){
	    $date  = date('Ymd',time());
	     //取的条数
	    $num   = 50; 

	    date_default_timezone_set('PRC');
	    //设置页面字符集
	    header("content-type:text/html;charset=utf-8");
	    
	    include_once('/home/ts/htdocs/ts/service/connDb/db.class.php');
	    //实例化(数据库服务器名, 要调用的数据库)
	    $db = new Db('offerWallDb');
	    //生成一个对象
	    $db->mysql();

	    $sql="select *,from_unixtime(act_time,'%H:%i:%s') time from `ow_act` where dt={$date} and appid= '".$appid."' order by actid desc limit {$num}";
	    $result=mysql_query($sql);
	    if(mysql_affected_rows()>0){
		while($arr=mysql_fetch_assoc($result)){
			$val[] = $arr;
		}
		return  json_encode($val);
	    }else{
		     return  json_encode('data is empty!');
	    }
			
   }

}
