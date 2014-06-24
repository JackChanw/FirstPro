<?php

class DataSplitController extends DController
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
	    $max = $_POST['data_num'];
	    $split = new DataSplitForm;
	    $res = $split->splits($file, $max);
	}else{
	    $this->render('split');
	}
    }
}
