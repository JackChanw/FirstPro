<?php

/*
 * 对接工单详情
 */

class CpaOfferDetailForm extends DFormModel {

	#offerid
	public $offerid;
	#app名称
	public $appName = '';			
	#itunes地址
	public $itunesUrl = '';			
	#点击链接
	public $clkLink = '';				
	#激活定义
	public $activeMode = array(
		1=>'启动应用',
		2=>'进入游戏',
		3=>'注册成功',
		4=>'创建角色',
		5=>'其他'
	);
	#回调周期
	public $callbackperiod = array(
		0=>'请 选 择',
		1=>'实时回调',
		2=>'5分钟',
		3=>'其他',
		4=>'其他',
		5=>'其他',
		6=>'其他',
		7=>'其他',
		404=>'其他'	
	);
			
	#备注信息
	public $note = '';				

	public $data;



	public function __construct($id){
		$this->offerid = $id;
	}


	/*
     * 处理工单 
     */
    public function WorkOrderDispose(){
		$listdata = $this->getOfferList();	
		return $this->insertCpaInfo();
	}


	public function getOfferList(){
		$connection = Yii::app()->db;  
		$sql = "SELECT 
					l.id, d.app_name, d.itunesurl, d.clk_link, d.active_mode, d.callback_period, d.note 
				FROM 
					offer_list l, offer_detail d 
				WHERE 
					d.id =  l.sid and l.id = {$this->offerid}";
		try{
			$command = $connection->createCommand($sql);  
			$result = $command->queryAll();  
			$this->data = $result[0];
			return $this->transform();
		}catch(Exception $e){
			Yii::log($e->getMessage(), 'error, warning', 'cpaOfferDetailForm.WorkOrderDispose');
		}

	}


	/*
	 * 将编号转为对应的文字描述
	 */
	private function transform(){
		$arr = array();
		$arr['offer_id'] = $this->data['id'];
		$arr['app_name'] = $this->data['app_name'];
		$arr['app_itunes'] = $this->data['itunesurl'];
		$arr['app_link'] = $this->data['clk_link'];
		$arr['activate_mode'] = $this->activeMode[$this->data['active_mode']];
		$arr['callback_period'] = $this->callbackperiod[$this->data['callback_period']];
		$arr['note_info'] = preg_replace('/\r\n/',';', $this->data['note']);
		return $arr;
	}
}
