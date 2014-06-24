<?php
class CheckOwInfoForm extends CFormModel
{

	public $owinfo;
	public $fileName;

	public function rules()
	{
	    return array(
		// name, text, url, reqjs, casescheme and regdata are required
		array("owinfo","file", "types"=>"csv", "wrongType"=>"Only csv allowed"),
	    );  
	}

	public function attributeLabels()
	{
	    return array(
		'owinfo'=>'',
		);
	}

	public function saveinfo()
	{
		try{
			if(empty($_FILES['CheckOwInfoForm']['tmp_name']['owinfo']))
			{
				throw new Exception("上传文件错误!");
			}
			$upload = CUploadedFile::getInstance($this,'owinfo');
			$this->fileName = basename($upload->Name, '.csv');
			if(!$upload->saveAs($this->createFileName(), true))
				throw new Exception('上传保存文件失败!');
			if(!$this->shell())
				throw new Exception('调用脚本程序失败!');
			Util::log('checkOwInfo',Yii::app()->user->name.'提交查询成功~' ,'info');
			return True;
		}catch(Exception $e){
			Util::log('checkOwInfo', $e->getMessage(), 'error');
			return False;
		}
	}


	//定义方法,调用脚本文件
	private function shell(){
        try{
			set_time_limit(0);
			$userName = Yii::app()->user->userName;
			$cmd = "cd {$this->getBaseDir()} && python checkowinfo.py {$this->fileName} {$userName} &";
			pclose(popen($cmd, "r"));
			return true;
        }catch(Exception $e){
			Util::log('checkOwInfo', $e->getMessage(), 'error');
			return false;
        }   
    }   
	//定义方法获取脚步所需的根目录
	private function getBaseDir()
	{
		return DOMOB_INSIDE_BASE_DIR.'/commands/checkOwInfo/';
	}
	

	//定义方法,创建上传文件存放路径
	private function createFileName()
	{
		$currentTime = time();
		$this->fileName = "{$this->fileName}_{$currentTime}.csv";
		return "{$this->getBaseDir()}source/{$this->fileName}";
	}
}
?>
