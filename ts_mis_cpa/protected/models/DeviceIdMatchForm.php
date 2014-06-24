<?php

class DeviceIdMatchForm extends DFormModel
{
	public $fileName;
	public $downFileName;
	public function rules()
	{
	    return array(
		array('fileName', 'safe')
	    );
	}

	private function getBasePath(){
	    return Yii::app()->params['commandsRootDir'].'/deviceidMatch/';
	}

	private function getDownPath(){
	    return Yii::app()->params['downloadRootDir'].'/deviceidMatch/';
	}

	private function createFileName($type){
	    return "{$this->getBasePath()}dstDir/{$this->fileName}_{$type}.csv";
	}

	private function saveFile($type, $kname){
	    try{
		$upload = CUploadedFile::getInstanceByName($kname);
		if(!$upload->saveAs($this->createFileName($type), true))
		    throw new Exception();
		return true;
	    }catch(Exception $e){
		//var_dump($e->getMessage());
		$this->addError('saveFile', $kname.' 文件上传失败');
		return false;
	    }
	}

	private function shell(){
	    try{
		return shell_exec("cd {$this->getBasePath()} && python main.py {$this->fileName}");
	    }catch(Exception $e){
		$this->addError('shell', '命令调用错误');
		return false;
	    }
	}

	public function match(){
	    set_time_limit(0);
	    if($this->saveFile('clk', 'clkFile') && $this->saveFile('act' ,'actFile') && $res = $this->shell()) {
		Yii::app()->session['clkfilename'.$this->fileName] = $res;
		return $this->fileName;
		//return array('msg'=>urlencode($res), 'file'=>$this->fileName);
	    }else{
		Yii::app()->session['clkfilename'.$this->fileName] = 'fail';
		return false;
	    }
	}
	
	public function download($fileName){
	    $tmpFile  = $this->getDownPath().$fileName.'.zip';
	    $a2cFile  = $this->getBasePath().'srcDir/'.$fileName.'_a2c.csv';
	    $na2cFile = $this->getBasePath().'srcDir/'.$fileName.'_na2c.csv';
	    $zip = new ZipArchive;
	    if($zip->open($tmpFile, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== True) {
		throw new Exception('Cannot create zip file '. $tmpFile);
	    }
	    $zip->addFile($a2cFile, 'a2c.csv');
	    $zip->addFile($na2cFile, 'na2c.csv');
	    $zip->close();
	    header('Content-Type: application/zip');
	    header('Content-Length: '. filesize($tmpFile));
	    header('Content-Disposition: attachment;filename="'. $fileName .'_match.zip"');
	    header('Cache-Control: max-age=0');
	    header('Content-Transfer-Encoding: binary');

	    $foutput = fopen('php://output', 'a');
	    $fp = fopen($tmpFile, 'r');
	    $content = fread($fp, filesize($tmpFile));
	    fclose($fp);
	    fwrite($foutput, $content);
	    fclose($foutput);
	    //@unlink($tmpFile);
	}

	public function getDescribe(){
	    $msg = !empty(Yii::app()->session['clkfilename'.$this->fileName]) ? Yii::app()->session['clkfilename'.$this->fileName] : '';
	    $msg = trim($msg);
	    $code = '200';
	    if(empty($msg))
		$code = '101';
	    else if($msg == 'fail')
		$code = '102';
	    return array('code'=>$code, 'msg'=>$msg);
	} 

}
