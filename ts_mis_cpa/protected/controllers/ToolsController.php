<?php

class ToolsController extends DController
{

	public function accessRules() {
	    return array(
		array('allow',
		    'users'=>array('@')
		),
		array('deny',
		    'users'=>array('*'),
		),  
	    );  
	}  

	/*iOS设备号导出*/
	public function actionSplit(){
	    if(Yii::app()->request->isPostRequest){
		$file = $_FILES['splitFile'];
	//	$res = $_POST['check'];
		$res = 'aaaaaaaaaa';
	//	$split = new SplitForm();
	//	$res = $split->action($file);
	/*	if($res)){
		    $data = json_encode(array_merge($res,array('status'=>'200')));
		}else{
		    $data = json_encode(array('status'=>'500', 'msg'=>FuncLib::getErrorByFirst($model), 'file'=>''));
		}
	*/
		$this->render('aa.php', array('data'=>$file));
		//$this->render('split', array('data'=>$res));
	    }else{
		$this->render('split');
	    }
	}
}
