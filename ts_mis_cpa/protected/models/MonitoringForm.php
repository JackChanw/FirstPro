<?php

/**
 * PostForm class.
 * PostForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class MonitoringForm extends CFormModel
{
	public $urlOne;
	public $urlTwo;
	public $tracker;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			//array('offer_title ,sale ,pri_level ,online_time ,app_name ,ae ,itunesurl ,clk_link ,send_type ,active_mode ,callback_period ,api_type ,platform ,system_version ,app_type', 'required'),
			array("urlOne","required","message"=>"<em style='color:red;display:block;'>**请输入第三方监测url**</em>"),
			#array("urlTwo","required","message"=>"<em style='color:red;'>**请输入landing**</em>"),
			#array("urlTwo","url","message"=>"<em style='color:red;'>**请输入offer的名称**</em>"),
			#array("tracker","required","message"=>"<em style='color:red;'>**请输入offer的名称**</em>"),
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
}
