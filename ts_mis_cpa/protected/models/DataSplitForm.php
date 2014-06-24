<?php
class DataSplitForm extends CFormModel{
	private $files;				//上传的文件
	private $fileName;			//上传的文件名
	private $arr = array();			//上传内容
	private $error;				
	private $num_data;			//数据总数 
	private $type;				//类型
	private $data;				//拆分的数据
	private $check;				//功能选项 one/two/three
	private $newArr;		
	private $max;		
	private $new_arr;		
	private $contents;		

	public function splits($files, $max = 5000, $check = 'one'){
	    set_time_limit(0);
	    ini_set('memory_limit', '600M');
	    $this->files = $files;
	    $this->max = $max;
	    $this->fileName = $files['name'];
	    try{
		$this->readFiles();
		$this->dataTidy();
		$this->getMacIdfa($check);
		$this->download();
		$this->error();
	    }catch(Exception $e){
		$this->files['error'] = $e->getMessage();
		die($this->error());
	    }
	}

	/* 读取文件 */
	public function readFiles(){
	    //检查后缀
	    $ext = strtolower(strrchr($this->files['name'], '.'));
	    if($ext != '.csv'){
		$this->files['error'] = -1;
		die($this->error());
	    }
	    //检查大小  100M限制
	    if($this->files['size'] > 100*1024*1024){
		$this->files['error'] = -2;
		die($this->error());
	    }
	    //读取文件内容
	    $handle = fopen($this->files['tmp_name'], 'r');
	    while($data = fgetcsv($handle, 10000, ',')){
		$this->num_data = count($data);		//列数
		$this->arr[] = $data;
	    }

	}

	/* 数据整理 */
	private function dataTidy(){
	    $n = count($this->arr[0]);
	    for($i=0; $i<$n; $i++){
		switch(strtolower($this->arr[0][$i])){
		case 'mac'			:$this->type['mac_n'] = $i;		    	break;
		case 'idfa'			:$this->type['idfa_n'] = $i;			break;
		case 'time'	    		:$this->type['time_n'] = $i;			break;
		case 'macmd5'			:$this->type['macmd5_n'] = $i;			break;
		case 'mac_idfa'			:$this->type['mac_or_idfa_n'] = $i;		break;
		case 'macmd5_idfa'		:$this->type['macmd5_or_idfa_n'] = $i;	break;
		    default;	
		}
	    }
	    array_shift($this->arr);
	    array_filter($this->arr);
	}

	/* 拆分数据控制 */
	private function getMacIdfa($check){
	    $mac_n = isset($this->type['mac_n'])			    ? $this->type['mac_n']	    : null;
	    $idfa_n = isset($this->type['idfa_n'])			    ? $this->type['idfa_n']	    : null;
	    $time_n = isset($this->type['time_n'])			    ? $this->type['time_n']	    : null;	
	    $macmd5_n = isset($this->type['macmd5_n'])		    ? $this->type['macmd5_n']	    : null;	
	    $mac_or_idfa_n = isset($this->type['mac_or_idfa_n'])	    ? $this->type['mac_or_idfa_n']  : null;	
	    $macmd5_or_idfa_n = isset($this->type['macmd5_or_idfa_n'])  ? $this->type['macmd5_or_idfa_n'] : null;	
	    if($mac_n !== null){
		$this->splitData(1, $mac_n, $idfa_n, $time_n);  //有效值拆分
		$this->matching('mac', $mac_n);     //格式转换
		$this->amount('mac');     //按时间拆分数据
		if(isset($idfa_n)){
		    $this->matching('idfa', $idfa_n);
		    $this->amount('idfa'); 
		}
	    }else if($macmd5_n !== null && $mac_n === null){
		$this->splitData(2, $macmd5_n, $idfa_n, $time_n);
		$this->matching('macmd5', $macmd5_n);
		$this->amount('macmd5');
		if(isset($idfa_n)){
		    $this->matching('idfa', $idfa_n);
		    $this->amount('idfa');
		}
	    }else if($idfa_n !== null && $macmd5_n === null && $mac_n === null){
		$this->matching('idfa', $idfa_n);
		$this->amount('idfa');
	    }else if($mac_or_idfa_n !== null){
		$this->splitData(4, $mac_or_idfa_n, null, $time_n);
		if(isset($this->type['mac_n'])){
		    $this->matching('mac', $this->type['mac_n']);     //格式转换
		    $this->amount('mac');     //按时间拆分数据
		}
		if(isset($this->type['idfa_n'])){
		    $this->matching('idfa', $this->type['idfa_n']);
		    $this->amount('idfa'); 
		}
	    }else if($macmd5_or_idfa_n !== null && $mac_or_idfa_n === null){
		$this->splitData(5, $macmd5_or_idfa_n, null, $time_n);
		if(isset($this->type['macmd5_n'])){
		    $this->matching('macmd5', $this->type['macmd5_n']);     //格式转换
		    $this->amount('macmd5');     //按时间拆分数据
		}
		if(isset($this->type['idfa_n'])){
		    $this->matching('idfa', $this->type['idfa_n']);
		    $this->amount('idfa'); 
		}
	    }else{
		$this->files['error'] = -3;
		die($this->error());
	    }
	}

	/*	
	有效值拆分 
	$n 为mac 或者macmd5
	$m 为idfa
	 */
	private function splitData($int, $n, $m, $time_n){
	    $arr = $this->arr;
	    $i = 0;
	    //拆分有效mac和idfa
	    if($int == '1'){
		foreach($this->arr as $k => $v){
		    if($v[$n] == "02:00:00:00:00:00" || $v[$n] == "020000000000" || $v[$n] == "20000000000" || $v[$n] == '' || $v[$n] == "0"){
			$this->data['idfa'][$i][$m] = $v[$m];
			if(isset($time_n)){
			    $this->data['idfa'][$i][$time_n] = $v[$time_n];
			}
			unset($arr[$k]);
			++$i;
		    }	
		}
		$this->arraychange($arr, 'mac', $n, $time_n);
	    }else if($int == '2'){   //拆分macmd5和idfa
		foreach($this->arr as $k => $v){
		    $v[$n] = strtolower($v[$n]);
		    if($v[$n] === "0f607264fc6318a92b9e13c65db7cd3c" || $v[$n] == '' || $v[$n] == "df20b8d74af84a9fbc287d20c57f38b9"){
			$this->data['idfa'][$i][$m] = $v[$m];
			if(isset($time_n)){
			    $this->data['idfa'][$i][$time_n] = $v[$time_n];
			}
			unset($arr[$k]);
			++$i;
		    }	
		}
		$this->arraychange($arr, 'macmd5', $n, $time_n);
	    }else if($int == '4'){  //拆分在同一行的mac和idfa
		foreach($this->arr as $k => $v){
		    $long = strlen($v[$n]);
		    if($long == 32 || $long == 36){
			$this->data['idfa'][$i][0] = $v[$n];
			$this->type['idfa_n'] = 0;
			if(isset($time_n)){
			    $this->data['idfa'][$i][1] = $v[$time_n];
			}
			unset($arr[$k]);
			++$i;
		    }else if($long == 17 || $long == 12){
			if($v[$n] == '02:00:00:00:00:00' || $v[$n] == '020000000000' || $v[$n] == '20000000000'){
			    unset($arr[$k]);
			    ++$i;
			}
		    }	
		}
		if($arr){
		    $this->type['mac_n'] = 2;
		    $this->arraychange($arr, 'mac', $n, $time_n, 'mac');
		}
	    }else if($int == '5'){		//拆分在同一行的macmd5和idfa
		foreach($this->arr as $k => $v){
		    $long = strlen($v[$n]);
		    if($long == 36){
			$this->data['idfa'][$i][0] = $v[$n];
			$this->type['idfa_n'] = 0;
			if(isset($time_n)){
			    $this->data['idfa'][$i][$time_n] = $v[$time_n];
			}
			unset($arr[$k]);
			++$i;
		    }else if($long == 32){
			if(strtolower($v[$n]) == '0f607264fc6318a92b9e13c65db7cd3c'){
			    unset($arr[$k]);
			    ++$i;
			}
		    }	
		}
		if($arr){
		    $this->type['macmd5_n'] = 2;
		    $this->arraychange($arr, 'macmd5', $n, $time_n, 'mac');
		}
	    }
	}

	//mac、macmd5数据整理
	private function arraychange($arr, $type, $n, $time_n, $or = ''){
	    $i = 0;
	    foreach($arr as $v){
		if(strlen($v[$n])>5){
		    if($or == 'mac'){
			$data[$i][2] = $v[$n];
		    }else{
			$data[$i][$n] = $v[$n];
		    }
		    if(isset($time_n)){
			$data[$i][$time_n] = $v[$time_n];
		    }
		}
		++$i;
	    }
	    return $this->data[$type] = $data;
	} 

	/* 格式转换 */
	private function matching($type, $n){
	    if($type == 'mac'){
		$len1 = count($this->data['mac']);
		for($i=0; $i<$len1; $i++){
		    $str1 = $this->data['mac'][$i][$n];
		    $strlong1 = strlen($str1);
		    if($strlong1 == 12){//无冒号    
			$this->data['mac'][$i][$n] = $this->s_mac($str1);
		    }else if($strlong1 == 17){
			$this->data['mac'][$i][$n] = strtoupper($str1);
		    }else if($strlong1 == 11){  //第一位是0被省略
			$this->data['mac'][$i][$n] = $this->s_mac('0'.strtoupper($str1));
		    }else if(preg_match('/^[0-9]{1,3}\.[0-9]{2}E\+[0-9]{1,2}$/',$str1)){//匹配科学计数法数字
			$this->data['mac'][$i][$n] = $this->s_mac(number_format($str1,'0','',''));
		    }
		}
	    }else if($type == 'macmd5'){
		$len2 = count($this->data['macmd5']);
		for($i=0; $i<$len2; $i++){
		    $str2 = $this->data['macmd5'][$i][$n];
		    $this->data['macmd5'][$i][$n] = strtoupper($str2);
		}
	    }else if($type == 'idfa'){
		$len3 = count($this->data['idfa']);
		for($j=0; $j<$len3; $j++){
		    $str3 = $this->data['idfa'][$j][$n];
		    $strlong3 = strlen($str3);
		    if($strlong3 == 32){//无冒号
			$this->data['idfa'][$j][$n] = $this->s_idfa($str3);
		    }else if($strlong3 == 36){
			$this->data['idfa'][$j][$n] = strtoupper($str3);
		    }
		}
	    }
	}

	//无横线idfa转换
	private  function s_idfa($str){
	    $arr_n = str_split($str,1);
	    for($i=7;$i<20;$i+=4){
		$arr_n[$i] = $arr_n[$i].'-';
	    }
	    return strtoupper(implode('',$arr_n));
	}

	//无冒号mac转换
	private function s_mac($str){
	    $arr_n = str_split($str,1);
	    for($i=1;$i<10;$i+=2){
		$arr_n[$i] = $arr_n[$i].':';
	    }
	    return strtoupper(implode('',$arr_n));
	}

	/*  
	按时间拆分数据
	 */
	private function amount($type){
	    $time = isset($this->type['time_n']) ? $this->type['time_n'] : null;
	    if(!empty($time) || $time === 0){
		$days = $this->organizingTime($type);
		$first = $days['0'];
		$last = $days[count($days) - 1];
		$long = $last - $first + 1;
		foreach($this->data[$type] as $v){
		    $day = $this->getDay($v[$this->type['time_n']]);
		    for($i=0; $i<count($days); $i++){
			if($day == $days[$i]){
			    $this->newArr[$type][$i][] = $v;
			}
		    }
		}
		for($j=0; $j<count($days); $j++){
		    $this->measure($this->newArr[$type][$j], $type, $j);
		}
	    }else{
		$this->newArr[$type][0] = $this->data[$type];
		$this->measure($this->newArr[$type][0], $type);
	    }
	    $this->storeFile($type);
	} 

	//按量拆分数据
	private function measure($arr, $type, $j = 'no'){
	    $length = count($arr);
	    $n = ceil($length/$this->max);
	    if($j === 'no'){
		if($n > 1){
		    $this->new_arr[$type][0] = array_chunk($arr, $this->max);
		}else{
		    $this->new_arr[$type][0][0] = $arr;
		}
	    }else{
		if($n > 1){
		    $this->new_arr[$type][$j] = array_chunk($arr, $this->max);
		}else{
		    $this->new_arr[$type][$j][0] = $arr;
		}
	    }
	}

	//时间整理 
	private function organizingTime($type){
	    foreach($this->data[$type] as $v){
		if($v[$this->type['time_n']]){
		    $arr_time[] = $this->getDay($v[$this->type['time_n']]);
		}
	    }
	    $arr_times = (array_unique($arr_time));
	    sort($arr_times);
	    return $arr_times;

	}
	
	//取日期
	private function getDay($times){
	    return date('Ymd',strtotime($times));
	}

	/* 文件组装 */
	private function storeFile($type){
	    $name = $this->createFileName();
	    $n =  count($this->new_arr[$type]);
	    for($i=0; $i<$n; $i++){
		$arr = $this->new_arr[$type][$i];
		if(isset($this->type['time_n'])){
		    $time = $this->getDay($this->new_arr[$type][$i][0][0][$this->type['time_n']]);
		}else{
		    $time = date('Ymd');
		}
		for($j=0; $j<count($arr); $j++){
		    $fileName = $type."_".$time.'_'.$name."_".$i."_".$j.'_'.time().".csv";
		    $filePath = $this->getBasePath()."/".$fileName;
		    $this->contents[] = $filePath; 
		    $fp = fopen($filePath,"a"); //打开csv文件，如果不存在则创建
		    if(count($arr[$j]) ==  1){
			if(!empty($arr)){
			    fputcsv($fp,$arr[$j][0]);
			}
		    }else{
			foreach($arr[$j] as $v){
			    if(!empty($v)){
				fputcsv($fp,$v);
			    }
			}
		    }
		}
	    }
	}

	//路径
	private function getBasePath(){
	    return Yii::app()->basePath.'/ZIPfile';
	}

	//生成新无后缀文件名
	private function createFileName(){
	    $document = substr($this->fileName,0,-4);
	    if($document){
		if(strlen($document)>32){
		    return $document = substr($document,0,20);
		}else{
		    return $document = $document;
		}
	    }else{
		return $document = time();
	    }
	    return	$document;
	}

	/* 压缩下载 */
	public function download(){
	    $tmpFile  = $this->getBasePath().'/'.$this->createFileName().'_'.time().'_iOS.zip';
	    $zip = new ZipArchive;
	    if($zip->open($tmpFile, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== True) {
		throw new Exception('Cannot create zip file '. $tmpFile);
	    }
	    foreach($this->contents as $v){
		$file_name = strtolower(strrchr($v,'/'));
		$zip->addFile($v,$file_name);
	    }
	    $zip->close();
	    header('Content-Type: application/zip');
	    header('Content-Length: '. filesize($tmpFile));
	    header('Content-Disposition: attachment;filename="'.$this->createFileName().'_'.time().'_iOS.zip');
	    header('Cache-Control: max-age=0');
	    header('Content-Transfer-Encoding: binary');

	    $foutput = fopen('php://output', 'a');
	    $fp = fopen($tmpFile, 'r');
	    $content = fread($fp, filesize($tmpFile));
	    fclose($fp);
	    fwrite($foutput, $content);
	    fclose($foutput);
	    @unlink($tmpFile);   //删除压缩文件
	    foreach($this->contents as $v){
		@unlink($v);
	    }	
	}

	/* 错误 */
	private function error(){
	    switch($this->files['error']){
	    case -1 : echo $error = "亲，你的文件类型不合法，请用.csv文件！";	break;
	    case -2 : echo $error = "亲，你的文件太大！";						break;
	    case -3 : echo $error = "亲，请将excel表格第一行写明数据类型！";	break;
	    case 1  : echo $error = "文件超过了php.ini中规定的大小！";			break;
	    case 2  : echo $error = "文件超过了HTML表单规定的大小！";			break;
	    case 3  : echo $error = "文件部分被上传！";							break;
	    case 4  : echo $error = "文件没有上传！";							break;
	    default	: echo $error = "未知错误！";								break;
	    }
	    if($error){
		echo "<script type='text/javascript'>alert('".$error."')</script>";
		die();
	    }
	}
}	
?>
