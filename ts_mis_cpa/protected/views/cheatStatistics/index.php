<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo yii::app()->baseUrl;?>/css/base.css"/>
<style type="text/css">
.con {
	margin-left:15px;
	width:400px;
	float:left;
}
.con .leftMenu {
	float:left;
	width:30%;
}
.con .rightContent {
	float:left;
	width:50%;
}
.con .rightContent .media span{
	margin-right:8px;
	margin-left:3px;
}
.con .rightContent .media input{
	position:relative;
	top:-2px;
}
ul li {
	line-height:30px;
}
ul li #cheatStatistics {
	width:208px;
	line-height:normal;
	padding-top:6px;
	height:23px;
}

</style>
</head>

<body>
<div id="container">
    <div id="main" class="bor_div">
        <div class="title">作弊统计</div>
	<div class="warn" style="display:none">提示</div>
     	<iframe id="frame" src="" frameborder="0" width="100%"  scrolling="no" height="0px" name="upload"></iframe>
        <div class="content">
	    <form action="<?php echo Yii::app()->createUrl('CheatStatistics/index')?>" method="post" target="upload" enctype="multipart/form-data">
		  <div class="con">	
			<ul class="leftMenu">
				<li>是否更新媒体文件</li>
				<li>请填写内部<b>appid</b></li>
				<li>开始日期</li>
				<li>结束日期</li>
				<li>上传要核对的文件</li>
			</ul>
			<ul class="rightContent">
				<li class="media"><input type="radio" name='mediaUpdate' value="yes" /><span>是</span>
					<input type="radio" name="mediaUpdate" checked="checked" value="no"/><span>否</span>
				</li>
				<li><input type="text" name='appid' /></li>
				<li> 
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'name'=>'startDate',
						'attribute'=>'startDate',
						'language'=>'zh_cn',  
						'id'=>'prev',
						'value'=>date('Ymd', time()),
						'options' => array(
							 'showAnim' => 'fold', 
							'dateFormat'=>'yymmdd', //database save format
							'maxDate'=>'new Date()',
						),
						'htmlOptions'=>array(
							'readonly'=>'readonly',
						)
					));?>
				</li>
				<li> 
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'name'=>'endDate',
						'attribute'=>'startDate',
						'language'=>'zh_cn',  
						'value'=>date('Ymd', time()),
						'id'=>'next',
						'options' => array(
							'showAnim' => 'fold', 
							'dateFormat'=>'yymmdd', //database save format
							'maxDate'=>'new Date()',
						),
						'htmlOptions'=>array(
							'readonly'=>'readonly',
						)
					));?>
				</li>
				<li><input type="file" id ="cheatStatistics" name='cheatStatistics' /></li>
			</ul>
			<div style="clear:both"></div>
			<div class="operate">
				<input type="submit" id="submit" class="sub_button" name="submit" value="提 交"/>
			</div>
		  </div>
		</form>
		<div style="clear:both"></div>
	    <ul id="explain">
		<li class="tab_title">使用提示：</li>
		<li class="tab_list">1、上传核对的文件必须是csv格式，目前暂时不支持其他格式数据。</li>
		<li class="tab_list">2、文件里面字段顺序依次为IDFA、MAC、其它字段来排列。</li>
		<li class="tab_list">3、如果不上传文件，默认就是统计按照条件导出的数据的分媒体数据。</li>
		<li class="tab_list">4、</a>如有疑问请联系 <a href="mailto:zhangli1@domob.cn">zhangli1@domob.cn</a></li>
	    </ul>
        </div>
    </div>
		<div style="clear:both"></div>
</div>
</body>
<script>
//提示
function warn(className, msg, statuss){
    var c;
    c = $('.' + className);
    c.css('width', '99%');
    c.css('line-height', '25px');
    c.css('padding-left', '15px');
    c.css('margin', '2px 2px');
    if(statuss){
	c.css('color', '#5F8D00');
	c.css('background', '#E7F9AD');
	c.show().delay(5000).hide(2000);
    }else{
	c.css('color', '#CB3D3D');
	c.css('background', '#FFCFCF');
	c.show();
    }
	
    c.html(msg);
}
</script>
</html>
