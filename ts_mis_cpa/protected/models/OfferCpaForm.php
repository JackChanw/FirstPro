<?php

/**
 * OfferCpaUpdateForm class.
 * OfferCpaUpdateForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class OfferCpaForm extends DFormModel
{
	public $offer_title;
	public $sale;
	public $saleName;
	public $pri_level;
	public $online_dt;
	public $app_name;
	public $company_name;
	public $ae;
	public $itunesurl;
	public $clk_link;
	public $send_type = array(1,2); //修改了此字段的意思,代表设备类型 iPhone iPad
	public $active_mode = 1;
	public $active_mode_other;
	public $callback_period = 1;
	public $api_type = 1;
	public $platform = array(1);
	public $system_version = 1;
	public $app_type = 1;
	public $note;

	public $isNewRecord = True;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			//array('offer_title ,sale ,pri_level ,online_time ,app_name ,ae ,itunesurl ,clk_link ,send_type ,active_mode ,callback_period ,api_type ,platform ,system_version ,app_type', 'required'),
			array("offer_title","required","message"=>"**请输入offer的名称**"),
			array("sale","required","message"=>"**请选择负责的销售**"),
			array("sale","numerical","min"=>1,"tooSmall"=>"**请选择负责的销售**"),
			array("ae","required","message"=>"**请选择负责的AM**"),
			array("ae","numerical","min"=>1,"tooSmall"=>"**请选择负责的AM**"),
			array("app_name","required","message"=>"**请输入应用的名称**"),
			array("pri_level, callback_period, itunesurl, clk_link, online_dt, company_name, send_type, active_mode, active_mode_other, api_type, platform, system_version, app_type, note","safe"),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'offer_title'=>'工单标题',
			'sale'=>'负责销售',
			'ae'=>'负责AM',
			'api_type'=>'对接方式',
			'app_name'=>'应用名称',
			'company_name'=>'公司名称',
			'itunesurl'=>'app下载地址',
			'clk_link'=>'点击接口',
			'note'=>'备注信息',
			);
	}


	public function saveOffer(){
		try{
			$detailModel = new OfferDetail();
			$listModel = new OfferList();

			$detailModel->attributes = $this->attributes;
			$listModel->attributes = $this->attributes;

			$detailModel->sale = $this->sale;
			$detailModel->platform = array_sum($this->platform);
			$detailModel->send_type = array_sum($this->send_type);
			
			$listModel->offer_title = $this->offer_title;
			$listModel->status = 0;
			$listModel->commit_dt = time();
			$listModel->online_dt = strtotime($this->online_dt);

			if(!$detailModel->save())
				throw new Exception(Util::getErrorByFirst($detailModel)); 
			$listModel->sid = $detailModel->id;
			$listModel->pri_level = $detailModel->id;
			if(!$listModel->save())
				throw new Exception(Util::getErrorByFirst($listModel)); 
			Util::log('OfferCpa', Yii::app()->user->name.'提交了一次工单,标题为:'.$this->offer_title.',销售为:'.$detailModel->psInfoSale->name, 'info');
			return True;
		}catch(Exception $e){
			Util::log('OfferCpa', Yii::app()->user->name.'提交工单失败了,错误为:'.$e->getMessage(), 'info');
		}
	}


	public function updateOffer($id){
		try{
			$listModel = OfferList::model()->findByPk($id);
			$detailModel = OfferDetail::model()->findByPk($listModel->sid);

			$detailModel->attributes = $this->attributes;
			$listModel->attributes = $this->attributes;

			$detailModel->platform = empty($this->platform) ? 0 : array_sum($this->platform);
			$detailModel->send_type = empty($this->send_type) ? 0 : array_sum($this->send_type);
			
			$listModel->offer_title = $this->offer_title;
			$listModel->online_dt = strtotime($this->online_dt);

			if(!$detailModel->save())
				throw new Exception(Util::getErrorByFirst($detailModel)); 

			if(!$listModel->save())
				throw new Exception(Util::getErrorByFirst($listModel)); 
			Util::log('OfferCpa', Yii::app()->user->name.'修改了一次工单,标题为:'.$this->offer_title.',销售为:'.$detailModel->psInfoSale->name, 'info');
			return True;
		}catch(Exception $e){
			Util::log('OfferCpa', '更新数据出错,标题为:'.$this->offer_title.',错误为:'.$e->getMessage(), 'warning');
			return False;
		}
	}


	public function getMyAttributes($id){
		$platformArr = array(
				0=>array(),
				1=>array(1),
				2=>array(2),
				3=>array(1,2),
				4=>array(4),
				5=>array(1,4),
				6=>array(2,4),
				7=>array(1,2,4),
			);
		$sendTypeArr = array(
				0=>array(),
				1=>array(1),
				2=>array(2),
				3=>array(1,2),
			);
		$listModel = OfferList::model()->findByPk($id);
		$detailModel = OfferDetail::model()->findByPk($listModel->sid);
		$this->attributes = $listModel->attributes;   
		$this->attributes = $detailModel->attributes;   
		$this->platform = $platformArr[$detailModel->platform];   
		$this->send_type = $sendTypeArr[$detailModel->send_type];   
		$this->online_dt = date('Y-m-d', $listModel->online_dt);   
	}


	public function getAllSales()
	{
		$preSaleArr = PsInfo::model()->findAllByAttributes(array('ps_type'=>2));
		$saleArr = array(0=>'请选择');
		foreach ($preSaleArr as $key) {
			$saleArr[$key->id] = $key->name;
		}
		return $saleArr;
	}


	public function getAllAes()
	{
		$preAeArr = PsInfo::model()->findAllByAttributes(array('ps_type'=>1));
		$aeArr = array(0=>'请选择');
		foreach ($preAeArr as $key) {
			$aeArr[$key->id] = $key->name;
		}
		return $aeArr;
	}
}
