<?php

class MonitoringController extends DController
{

	public function accessRules(){
		return array(
			array('allow',
				'actions'=>array('index', 'describe'),
				'users'=>array('@')
			),
			array('deny',
				'users'=>array('*'),
			),  
		);    
	}  

	public function actionIndex(){
		$model = new MonitoringForm();
		if(Yii::app()->request->isPostRequest){
			//$message = new Combine();
			$model->attributes = $_POST;
			if($model->validate()){
				$this->redirect(array('index'));
			}
			//$message -> main();
		/*	$model = new DeviceIdMatchForm();
			if($res = $model->match()){
				$model->download($res);
			}else{
				$sta = json_encode(array('status'=>'500', 'msg'=>FuncLib::getErrorByFirst($model), 'file'=>''));
				$this->render('down', array('sta'=>$sta));
			}
		*/
		}
		$this->render('index', array('model'=>$model,));
	}

	public function actionDescribe(){
	    $model = new DeviceIdMatchForm();
	    $model->attributes = $_GET;
	    echo CJSON::encode($model->getDescribe());
	}
}
