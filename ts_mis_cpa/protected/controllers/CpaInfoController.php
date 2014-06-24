<?php
class CpaInfoController extends DController
{
	public $isVerdict = false;	
	public function accessRules() 
	{
	    return array(
		array('allow',
		    'actions'=>array('dolist','list','index','createAppName','changeDeviceInfo','searchCallBack','insertData','editSave','edit','save','createQRcode','doSearch','search','appSearch','editSub','info','paramNabnormal','delete', 'addHistoryTestDevice', 'WorkOrder', 'AppEncrypt', 'CustomSign'), 
		    'users'=>array('@')
		),
		array('deny',
		    'users'=>array('*')
		)
	    );
	}
    /**
	 * Lists all models.
     */
	public function actionIndex()
	{
		$workOrderId = isset($_GET['id']) ? $_GET['id'] : '';	
		$DeviceInfo = new DeviceInfoForm();
		$info = $DeviceInfo->searchAllDeviceName();
		$username = yii::app()->user->name;
		if($workOrderId == ''){
			//$this->renderPartial('index', array('username'=>$username, 'deviceinfo'=>$info));
			$this->render('index', array('username'=>$username, 'deviceinfo'=>$info));
		}else{
			$model = new CpaOfferDetailForm($workOrderId);
			$workOrder = $model->getOfferList();
			//$this->renderPartial('index', array('username'=>$username, 'deviceinfo'=>$info, 'order'=>json_encode($workOrder)));
			$this->render('index', array('username'=>$username, 'deviceinfo'=>$info, 'order'=>json_encode($workOrder)));
		}		
	}


    /**
     * 根据占位符找到所需要的设备信息
     */
    public function actionChangeDeviceInfo()
    {
	$arr = array();
	$data = $_REQUEST;
	$DeviceInfo = new DeviceInfoForm();
	$info = $DeviceInfo->searchAllDeviceInfo($data);
	$rand = array($info[0]->DMAC_UPPER, $info[0]->IDFA);
	$arr = array(
	    'DMAC_UPPER' => $info[0]->DMAC_UPPER,
	    'DMAC_LOWER' => strtolower($info[0]->DMAC_UPPER),
	    'MD5_MAC' => strtoupper(md5($info[0]->DMAC_UPPER)),
	    'DMAC_PURE_NUM' => str_replace(':', '', $info[0]->DMAC_UPPER),
	    'DMAC_PURE_NUM_LOWER' => strtolower(str_replace(':', '', $info[0]->DMAC_UPPER)),
	    'IDFA' => $info[0]->IDFA,
	    'IDFA_LOWER' => strtolower($info[0]->IDFA),
	    'NOCOLONIDFA' => str_replace('-', '', $info[0]->IDFA),
	    'NOCOLONIDFA_LOWER' => strtolower(str_replace('-', '', $info[0]->IDFA)),
	    'OPEN_UDID_LOWER' => $info[0]->OPEN_UDID_LOWER,
	    'OPEN_UDID' => strtoupper($info[0]->OPEN_UDID_LOWER),
	    'TIMESTAMP' => time(),
	    'MAC_OR_IDFA' => $rand[mt_rand(0, 1)],
	    );
	echo "{'callback':'Ci.FindDeviceInfo', 'param':".json_encode($arr)."}";
    }



    /*
     * 查询回调
     */
    public function actionSearchCallBack(){
		$data = array();
		$data = $_REQUEST;
		//$this->actionParamNabnormal($data);
		if($data['link']){
			$model = new CpaInfo;
			$callback = $model->SearchCallBack($data['link']);
			if($callback != 'data is empty!')
				echo "{'callback':'Ci.FindCallBack', 'param':".$callback."}";
		}
    }


    /**
     * 提交数据
     */

    public function actionInsertData()
    {
		$model = new CpaInfo;
		echo $model->insertData($_POST, 2);
		if($_POST['offer_id']){
			$offerCpa = new SetActForm;
			$offerCpa->SetDone($_POST['offer_id']);		
		}
    }
    
    /**
     * 保存应用
     */
    public function actionSave()
    {
		if($_POST['offer_id']){
			$model = new SetActForm();
			$model->saveClaim($_POST['offer_id']);
		}
        $cpainfo = new CpaInfo;
		echo $cpainfo->insertData($_POST, 1);       

    }

    /**
     *编辑后保存
     */
    public function actionEditSave(){
        $cpainfo = new CpaInfo;
        echo $cpainfo->updateData($_POST, 1);       
    }

    /**
     *编辑后提交
     */
    public function actionEditSub($data){
        $cpainfo = new CpaInfo;
        return $cpainfo->updateData($data, 2);       
    }
    /**********************************************************对接应用列表（已对接的app）****************************************************************/

    /**
     * 已对接app列表
     */
    public function actionList(){
        $cpainfo = new CpaInfo();
        $arr = $cpainfo -> infoPage(25);
        $this->render('list',array(
                            'app'     => $arr['list'],
                            'pages'   => $arr['pages'],
                            'appid'   => '',
                            'appname' => '',
                        ));
                
    }

    /**
     * 对接中app列表
     */
    public function actionDoList(){
        $cpainfo = new CpaInfo;
        $arr = $cpainfo -> page('dt desc', 'status=1', 25);
        $this->render('dolist',array(
                            'app'     => $arr['list'],
                            'pages'   => $arr['page'],
                            'appid'   => '',
                            'appname' => '',
                        ));
    }

    /**
     * 删除app
     */
    public function actionDelete(){
        $id = $_GET['id'];
	$this->actionParamNabnormal($id);
        $cpainfo = new CpaInfo;
        $cpainfo->DeleteApp($id);
        $this->redirect(array('CpaInfo/dolist'));
    }


	/**
	 * 编辑app 
	 */
	public function actionEdit(){
	    $id = $_GET['id'];
		$this->actionParamNabnormal($id);
	    $cpainfo = new CpaInfo;
	    $oneApp  = $cpainfo->SelectOneApp($id);

	    $DeviceInfo = new DeviceInfoForm();
	    $info = $DeviceInfo->searchAllDeviceName();

	    $model = new ExistDeviceForm;
	    $model->itunes_id = $model->getItunesId($oneApp->app_itunes);
	    $eid = $model->findExistDevice();
	    if($eid !== NULL)
			$ExistDeviceId = explode(',', $eid->device_id);
	    else
			$ExistDeviceId = '';
	    $username = yii::app()->user->name;
	    $this->render('edit',array('edit'=> $oneApp, 'username'=>$username, 'deviceinfo'=>$info, 'ExistDeviceId'=>$ExistDeviceId));
	}
	

	 /**
	 * app详情
	 */
	public function actionInfo(){
	    $id = $_GET['id'];
	    $this->actionParamNabnormal($id);
	    $cpainfo = new CpaInfo();
	    //$oneApp  = $cpainfo->SelectOneApp($id);
	    $versionApp  = $cpainfo->SelectCurrentVersionAllApp($id);
	    $DeviceInfo = new DeviceInfoForm();
	    $info = $DeviceInfo->searchAllDeviceName();
	    $username = yii::app()->user->name;
	    $this->render('info',array(
					'edit'=> $versionApp,
					'username'=>$username,
					'deviceinfo'=>$info
		));
	}

	/**
	 * 查找已对接完成app
	 */
	public function actionAppSearch($where, $status, $view){
	    $appid   = !empty($where['appid'])    ? $where['appid']    : '';
	    $appname = !empty($where['app_name']) ? $where['app_name'] : '';
	    $val = array_shift($where);
	    list($k,$v) = each($where);

	    if($v == '') 
			$where = '';
	    else if($k == 'app_name') 
			$where = ' and '.$k.' like '."'%$v%'";
	    else 
			$where = ' and '.$k.'='."'$v'";
     
	    $cpainfo = new CpaInfo();
	    $status = 'status='.$status;
	    $arr = $cpainfo -> page('dt desc', $status.$where, 15);
	    $this->render($view, array(
					    'app'     => $arr['list'], 
					    'pages'   => $arr['page'],
					    'appid'   => $appid,
					    'appname' => $appname,)
				    );
	}

	/**
	 * 对接完的app搜索
	 */
	public function actionSearch(){
	    $this->actionAppSearch($_GET, 2, 'list');
	}
	
	/**
	 * 对接中的app搜索
	 */
	public function actionDoSearch(){
	    $this->actionAppSearch($_GET, 1, 'dolist');
	}

	/**
	 * 生成app名称
	 */
	public function actionCreateAppName(){
		$data = $_REQUEST;
		$itunes = str_replace('~', '&',$data['itunes']);
		$rv = $this->actionCurl($itunes);	
		//$file = file_get_contents($itunes);
		if($rv != ''){
			preg_match('/<h1>(.*)<\/h1>/',$rv,$str);
			if(!empty($str)){
				echo "{'callback':'Ci.createAppName', 'param':".json_encode(mb_substr($str[1], 0, 15, 'utf-8'))."}";
			}else{
				echo "{'callback':'Ci.createAppName', 'param':".json_encode('data is empty')."}";
			}
		}else{
			exit("{'callback':'Ci.AlertInfo', 'param':10007}");				
		}
	}

	/**
	 * curl工具
	 */	
	public function actionCurl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$r = curl_exec($ch);
		return $r;
		curl_close($ch);
	}	

	/**
	 * 生成二维码
	 */
	public function actionCreateQRcode(){
	    include_once('phpqrcode/qrlib.php');
	    $QRcode = $_REQUEST['QRcode'];
	    QRcode::png($QRcode, false, 'L', 5.4, 2);  
	}
	
	/**
	 * 对参数异常进行处理
	 */
	
         public function actionParamNabnormal($param){
	 	if(empty($param)){
			exit("{'callback':'Ci.AlertInfo', 'param':10002}");				
		}
         }

	/**
	 * 添加到历史测试设备
	 */

	public function actionaddHistoryTestDevice(){
	    $model = new ExistDeviceForm();
	    $model->attributes = $_POST;
	    if($model->validate() && $model->dispatch()) 
	    {
		echo '保存成功';
	    }else{
		echo '失败';
	    }

	}

	/**
	 * 将外部字段转为内部字段
	 */

	public function outFields2inFields($data)
	{
	    $arr = array(
		'appName' => 'app_name',
		'deviceId' => 'device_id',
		    );

	    foreach($data as $k => $v){
	       $finalData[$arr[$k]] = $v; 
	    }
	    
	    return $finalData;
	    
	}

	/*
	 * appid进行加密，生成可以进行加密的标识符
	 */
	public function actionAppEncrypt(){
	    $appid = isset($_GET['appid']) ? $_GET['appid'] : ''; 
	    $prefix="lk2s#a1d@j8if";
	    echo md5($prefix.$appid);
	}

	/*
	 * 自定义签名
	 */
	public function actionCustomSign(){
	    $sign = isset($_GET['sign']) ? $_GET['sign'] : '';
	    try{
		$str = sprintf('echo %s;', urldecode($sign));
		eval($str);
	    }catch(Exception $e){
		Yii::log($e, 'error', 'system.web.CController.Cpainfo.CustomSign');	
	    }
	}



}
