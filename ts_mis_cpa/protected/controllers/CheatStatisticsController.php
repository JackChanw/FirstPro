<?php

class CheatStatisticsController extends DController
{
	public function accessRules() 
		{
			return array(
				array('allow',
					'actions'=>array('index'), 
					'users'=>array('@')
				),
				array('deny',
					'users'=>array('*')
				)
			);
		}

	public function actionIndex()
	{
		$cheatStatistics = new CheatStatisticsForm;  		     
		if(Yii::app()->request->isPostRequest)
		{
			$cheatStatistics->attributes =$_POST;
			if(!$cheatStatistics->upload()){
				$error = Yii::app()->user->getFlash('saveFile');
				$cheatStatistics->createHint($error, false);
			}else{
				$cheatStatistics->createHint('ok, please wait email', true);
			}
		}else{
			$this->render('index');
		}
	}

	
}
