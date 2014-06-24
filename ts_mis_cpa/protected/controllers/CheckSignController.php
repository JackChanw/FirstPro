<?php
#########################################################################
# Author: Kayin Sun 
# Created Time: 2014-04-02 13:47:26
# File Name: CheckSignController.php
# Description: 
#########################################################################

class CheckSignController extends DController {
	
	// 视图默认布局
	//public $layout = false; 
	
	/**
	 * 访问权限控制
	 * @return array 包含自定义权限控制规则的数组
	 */
	public function accessRules() {
		return array(
			array('allow',
				'users' => array('@')
			),
			array('deny',
				'users' => array('*')	
			)	
		);
	}

	public function actionIndex() {
	
		// 判断是否是POST请求
		if(Yii::app()->request->isPostrequest) {
			$model = new CheckSignForm();
			$model->attributes = $_POST;

			// 数据校验，执行操作并返回结果
			if($model->validate() && $result = $model->check()) {
				echo CJSON::encode($result);	
			} else {
				echo CJSON::encode(array('code'=>'500', 'msg'=>FuncLib::getErrorByFirst($model))); 
			} 
		} else {
			$this->render('index'); // 非POST请求，不做任何处理
		}
	}
} 
# vim: set noexpandtab ts=4 sts=4 sw=4 :
