<?php

/**
 * PostForm class.
 * PostForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class PostForm extends CFormModel
{
	public $offer_title;
	public $sale;
	public $pri_level;
	public $online_dt;
	public $app_name;
	public $company_name;
	public $ae;
	public $itunesurl;
	public $clk_link;
	public $send_type = array(1,2);
	public $active_mode = 1;
	public $active_mode_other;
	public $callback_period;
	public $api_type = 1;
	public $platform;
	public $system_version = 1;
	public $app_type = 1;
	public $note;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			//array('offer_title ,sale ,pri_level ,online_time ,app_name ,ae ,itunesurl ,clk_link ,send_type ,active_mode ,callback_period ,api_type ,platform ,system_version ,app_type', 'required'),
			array("offer_title","required","message"=>"<em style='color:red;display:block;'>**请输入offer的名称**</em>"),
			array("sale","required","message"=>"<em style='color:red;'>**请输入offer的名称**</em>"),
			array("ae","required","message"=>"<em style='color:red;'>**请输入AE的名称**</em>"),
			array("app_name","required","message"=>"<em style='color:red;'>**请输入应用的名称**</em>"),
			array("pri_level ,callback_period ,itunesurl ,clk_link ,online_dt ,company_name ,send_type ,active_mode ,active_mode_other ,api_type ,platform ,system_version ,app_type ,note","safe"),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array();
	}

	/**
	 * Declares the function to save data
	 */
	public function savedata($data)
	{
		try{
			$detailmodel = new OfferDetail();
			$detailmodel->attributes = $data;
			$detailmodel->send_type = is_array($data['send_type'])?array_sum($data['send_type']):0;
			$detailmodel->platform = is_array($data['platform'])?array_sum($data['platform']):0;
			$detailmodel->system_version = join('-',$data['system_version']);
			$detailmodel->sale = $data['sale'];
			$detailmodel->active_mode_other= $data['active_mode_other'];
			if(!$detailmodel->save())
			{
			     throw new Exception('insert detaildata is failed');
			}
			$listmodel = new OfferList();
			$listmodel->offer_title = $this->offer_title;
			$listmodel->sid = $detailmodel->id;
			$listmodel->pri_level  = $detailmodel->id;
			$listmodel->online_dt = strtotime($data['online_dt'].':00:00');
			$listmodel->commit_dt = time();
			if(!$listmodel->save())
			{   
				throw new Exception('insert detaildata is failed');
			}
			$sale = $detailmodel->psInfoSale->name;
			$title= $listmodel->offer_title;
			Yii::log(Yii::app()->user->name.' 提交了销售为：'.$sale.' 标题为：'.$title.' 的offer 状态为：[SUCESS]','INFO','OfferCpa');  
			return true;
		}catch(Exception $e){
			Yii::log(Yii::app()->user->name.' 提交了销售为：'.$sale.' 标题为：'.$title.' 的offer 状态为：[FAILED] INFO：'.$e->getMessage(),'ERROR','OfferCpa');  
		    	return false;
		}   
	}
	public function getPs()
	{
		$model = new PsInfo();
		$data = $model->findAll();
		$ps = array();
		$ps['sales'][0] = '请选择';
		$ps['aes'][0] = '请选择';
		foreach($data as $value)
		{
			if($value->ps_type == 2)
			{
				$ps['sales'][$value->id] = $value->name;	
			}else{
				$ps['aes'][$value->id] = $value->name;
			}
		}
		return $ps;
	}
}
