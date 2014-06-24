<?php

class ClkActDataSearchController extends DController
{

        public function accessRules()
	{
	    return array(
		array('allow',
		    'actions'=>array('dodata', 'index', 'act', 'clkact'),
		    'users'=>array('@')
		),
		array('deny',
		    'users'=>array('*')
		)
	    );    
	}
 
	public function actionIndex()
	{
		$this->render('index');
	}


	public function actionAct()
	{
		$this->render('act');
	}

	public function actionClkact()
	{
		$this->render('clkact');
	}

	public function actionDodata(){
		set_time_limit(0);
		$data = $_POST;
		$type = $data['type'];
		$idType = $data['argument'];
		$id = trim($data['inputdata']);
		$startTime = $data['startTime'];
		$endTime = $data['endTime'];
		$status = isset($data['status']) ? $data['status'] : '';
		$find = $data['find'];

		if($idType == 'offerid'){
			$idType = 'cid';
		}
		$sday = date('Ymd',$startTime);
		$stime = date('H:i:s',$startTime);
		$start_time = urlencode(date('Ymd H',$startTime));

		$eday = date('Ymd',$endTime);
		$etime = date('H:i:s',$endTime);
		if($etime == '00:00:00' && $stime == '00:00:00'){
			$start_time = $sday;
			$end_time = $eday;
		}else{
			$end_time = urlencode(date('Ymd H',$endTime));
		}
		if($status === '3'){
			$one = strpos($find, ',');
			$first = substr($find, 0, $one);
			if($first == 'act_time'){
				$find = substr($find,$one + 1).',act_time';
			}
		} 
	
		try{
			$username = yii::app()->user->userName;
			if($username != ''){
				$param = '"'.$username.'" "'.$type.'" "'.$idType.'" "'.$id.'" "'.str_replace('+', ' ', $start_time).'" "'.str_replace('+', ' ', $end_time).'" "'.$find.'"';
				if($status === '0' || $status === '1' || $status === '3'){
					$param = $param." ".(int)$status;
				}
			}
			Yii::log(sprintf('actionDodata mode: %s', $param), 'info', 'offerwallDataSearch');
			
			pclose(popen('cd /home/ts/htdocs/ts/dataSearch && nohup /usr/local/bin/python2.7 main.py '.$param.' &', "r"));  
			echo 'ok';
		} catch (Exception $e) {
			Yii::log(sprintf('actionDodata mode: %s', $e->getMessage()), 'error, warning, info', 'system.web.CController.Dodata');
		}
	}
}
