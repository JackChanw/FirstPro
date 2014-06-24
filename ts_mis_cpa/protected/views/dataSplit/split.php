<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo yii::app()->baseUrl;?>/css/base.css"/>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/base.js"></script>
<style type="text/css">
#table .tab_list{
    height:40px;
    line-height:40px;
    padding-left:20px;
}
#table .tab_list:hover {
    background:none;
}
#table .power{
    height:150px;
}
#table .powergr{
    height:130px;
    margin:10px 0 10px -3px;
    width:300px;
}
.operate{
    margin:10px 0 10px 25px;    
}
.sub_button{
    width:70px;
    margin-left:20px;
}
em{
    margin-left:10px;
}
#loading{
    margin-left:10px;
}
#ts{
    width:250px;
    padding:10px;
    margin:10px 10px 10px 30px;
    border:1px solid #eee;
}
#ts li{
    height:23px;
    line-height:23px;
}
#ts span{
    margin-left:10px;
}
.check1{
    position:relative;
    top:8px;
    margin-left:20px;
    margin-bottom:20px;
}
.span1{
    margin-left:10px;
}
.check2{
    margin-left:135px;
}
</style>
<script type="text/javascript">
	var ctime = '<?php echo $ctime = mktime(); ?>';
	var expand = {
		init:function(){
			$('#submit').click(function(){
				if($('#actFile').val() !=''){
					$('#loading').show().delay(1000).hide(100);
				}else{
					alert('请选择匹配的文件！');
				}
			})	    
		}
	} 
</script>
</head>
<body>
<iframe src="" style="display:none;" name="upload"></iframe>
<div id="container">
	<div id="main" class="bor_div">
		<div class="title">iOS设备号整理</div>
		<?php echo $operateWarn = Yii::app()->user->getFlash('operateWarn'); ?>
		<?php $class = !empty($operateWarn['status']) && $operateWarn['status'] ? 'success' : 'error'; ?>
		<div id="operateWarn" class="<?php echo $class; ?>">
			<?php echo !empty($operateWarn['msg']) ? $operateWarn['msg'] : ''; ?>
		</div>
		<div class="content">
		<form action="<?php echo Yii::app()->createUrl('DataSplit/split')?>" method="post" target="upload" enctype="multipart/form-data">
			<input type="radio" class="check1" name="check" value="one" checked /><span class="span1">格式转换+设备号拆分<span>
			<span class="check2">拆分数据量：</span><input type="text" name="data_num" value="5000">
			<ul id="table">
				<li class="tab_list"><span>导入数据：</span><input type="file" id="actFile" name="splitFile" /><em>* CSV文件，务必按照说明中的格式</em></li>
				<input type="hidden" value="<?php echo $ctime; ?>" name="fileName"/>
			</ul>
			<div class="operate">
				<input type="submit" id="submit" class="sub_button" name="submit" value="提 交"/>
				<span style="display:none" id="loading"><img src="<?php echo Yii::app()->baseUrl;?>/images/subloading.gif"/></span>
			</div>
	    </form>
	    <ul id="explain">
			<li class="tab_title">使用提示：</li>
			<li class="tab_list">1、第一行必须填写<span style="color:blue">mac / idfa / macmd5 / mac_idfa / macmd5_idfa</span>,可选择填写<span style="color:blue">time</span>,不分顺序；</li>
			<li class="tab_list">2、转换后数据为 mac / macmd5 / idfa / [ time ] ;</li>
			<li class="tab_list">3、若超过一天，按天进行拆分；</li>
			<li class="tab_list">4、拆分数据量默认为5000，可以为空，也可自定义；</li>
	    </ul>
        </div>
    </div>
</div>
</body>
</html>
