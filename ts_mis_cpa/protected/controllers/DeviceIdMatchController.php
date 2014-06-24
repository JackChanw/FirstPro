<?php

class DeviceIdMatchController extends DController
{

	public function accessRules() {
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

	public function actionIndex() {
	    if(Yii::app()->request->isPostRequest){
		$model = new DeviceIdMatchForm();
		$model->attributes = $_POST;
		if($res = $model->match()){
		    $model->download($res);
		    //$sta = json_encode(array_merge($res, array('status'=>'200'))); 
		}else{
		    $sta = json_encode(array('status'=>'500', 'msg'=>FuncLib::getErrorByFirst($model), 'file'=>''));
		    $this->render('down', array('sta'=>$sta));
		}
	    }else{
		$this->render('match');
	    }
	}

	public function actionDescribe(){
	    $model = new DeviceIdMatchForm();
	    $model->attributes = $_GET;
	    echo CJSON::encode($model->getDescribe());
	}
	
}
