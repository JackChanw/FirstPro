<?php

class CheckOwInfoController extends DController
{
	public function accessRules()
        {
            return array(
		array('allow', 
		    'actions'=>array('collocter'),
		    'users'=>array('@')
		)
            );
        }
	public function actionCollocter()
	{
		$model = new CheckOwInfoForm();
		if(Yii::app()->request->isPostRequest):
			$model->attributes = $_POST['CheckOwInfoForm'];
			if($model->validate() && $model->saveinfo()):
				Util::inform('OK,请耐心等待邮件~', 'info');
			else:
				Util::inform('Sorry,一定是哪里出错了~', 'error');
			endif;
		endif;
		$this->render('collocter',array('model'=>$model));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
