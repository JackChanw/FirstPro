<?php
#########################################################################
# Author: ts (zhangli1@domob.cn)
# Created Time: 2014-05-19 16:23:56
# File Name: CheatStatisticsForm.php
# Description: 
#########################################################################

class CheatStatisticsForm extends CFormModel {
	public $csvFile;
	public $mediaUpdate;
	public $appid;
	public $startDate;
	public $endDate;
	public $execFileName;

	public function rules()
	{
		return array(
			array('csvFile', 'file', 'types'=>'csv'),
			array('mediaUpdate,appid,startDate,endDate,execFileName', 'safe'),
		);
	}

	//上传文件
	public function upload(){
		if(!$this->checkParam()) return false;
		$upload = CUploadedFile::getInstanceByName('cheatStatistics');
		if($upload === NULL){
			$this->fileAddr();
			return $this->myCommand(true);
		}else if($this->validate() && $this->saveFile()){
			return $this->myCommand();
		}else{
			$this->setErr('saveFile');
			return false;
		}
	}


	//调用python脚本
	public function myCommand($directStatistics=false){
		$comm = Yii::app()->params['commandsRootDir'];
		if($this->mediaUpdate == 'yes') $mediaUpdate = "True";
		else $mediaUpdate="False";
		$dbFile = sprintf('%s_%s_%s',$this->startDate, $this->endDate, str_replace('/', '_', $this->appid));
		if($directStatistics == true){
			$this->execFileName = $dbFile;
		}
		try{
			$cmd = sprintf('cd '.$comm.'/cheatDataStatistics && nohup /usr/local/bin/python2.7 cheatDataStatistics.py "%s" "%s"  "%s" "2,1" %s %s "%s" %s &', Yii::app()->user->userName, 
					$this->execFileName, $dbFile, $this->startDate, $this->endDate, $this->appid, $mediaUpdate);				
			Yii::log($cmd, 'info', 'CheatStatisticsForm.myCommand');
			pclose(popen($cmd, "r"));
			return true;
		}catch(Exception $e){
			Yii::log($e, 'error', 'CheatStatisticsForm.myCommand');
			return false;
		}
	
	}


	//参数判断
	public function checkParam(){
		if(!$this->appid){
			$this->setErr('saveFile', 'appid not is empty');
			return false;
		}
		if(strtotime($this->startDate) > strtotime($this->endDate)){
			$this->setErr('saveFile', 'startDate is unable greater than endDate');
			return false;
		}
		$this->csvFile = CUploadedFile::getInstanceByName('cheatStatistics');
		return true;
	}


	//返回保存文件的地址
	public function fileAddr(){
		$uploadDir = Yii::app()->params['downloadRootDir'];
		$this->execFileName=date('YmdHis',time()).'.csv';
		return $upload.'/source/'.$this->execFileName;	
	}

	//上传文件
	public function saveFile(){
		try{
			$upload = CUploadedFile::getInstanceByName('cheatStatistics');
			if(!$upload->saveAs($this->fileAddr(), true)){
				$this->setErr('saveFile', $upload->name.' upload error');
				return false;
			}
			return true;
	    }catch(Exception $e){
			$this->setErr('saveFile', $upload->name.' upload error');
			return false;
	    }

	} 

	
	//错误处理
	public function setErr($type, $errContent=false){
		if(!$errContent){
			foreach($this->getErrors() as $v){
				$err = preg_replace('/\"/','\'', $v[0]);
			}
		}else{
			$err = $errContent;
		}
		Yii::log($type.' '.$err, 'error', 'CheatStatisticsForm.setErr');
		Yii::app()->user->setFlash($type, $err);
	}


	//生成标准的提示信息
	public function createHint($content, $status=false){
		if($status)
			printf('<script>window.parent.warn("warn", "%s", true)</script>', $content);
		else
			printf('<script>window.parent.warn("warn", "%s", false)</script>', $content);
	}

} 

# vim: set noexpandtab ts=4 sts=4 sw=4 :
