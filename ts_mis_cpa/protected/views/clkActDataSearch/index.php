<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo yii::app()->baseUrl;?>/css/expand.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo yii::app()->baseUrl;?>/css/jquery-ui-1.8.17.custom.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo yii::app()->baseUrl;?>/css/jquery-ui-timepicker-addon.css"/>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript">
$(function () {
    $(".ui_timepicker").datetimepicker({
    showSecond: true,
    timeFormat: 'hh:mm',
    //timeFormat: 'hh:mm:ss',
    stepHour: 1,
    stepMinute: 1,
    stepSecond: 1
    })
})
</script>
<style type="text/css">
.bottom{
	margin-top:10px;    
}
.con_top{
    background:white;
    border:none;
}
ul{
    margin-top:8px;
}
li{
    height:30px;
    line-height:30px;
    padding:0 10px;
}
.content{
	padding:10px 0;	
}
.con_top{
    height:400px;
}
.find_i{
    position:relative;
    top:8px;
    margin-right:5px;
    margin-left:20px;
}
.fun_button{
	margin-left:10px;   
}
.timedata{
    padding-left:20px;
}
.find_left{
    margin-left:92px;
}
.findSearch{
    position:relative;
    left:20px; 
}
.find5{
    margin-left:45px; 
}
.find2{
    margin-left:39px;
}
.find6{
    margin-left:30px;
}
.find9{
    margin-left:23px;
}
.buttom{
    margin-top:60px;
}
.remind, .remind2{
    font-size:10px;
    display:none;
    background:#E7F9AD;
    color:#5F8D00;
    margin:5px 5px 0 5px;
    padding:5px 10px;
}
.buttom p{
    line-height:20px;
    margin-left:50px;
}
.buttom a{
    color:blue;
    text-decoration:none;
}
.find8{
    margin-left:67px;
}
</style>
</head>
<body>
    <div id="container">
	<div id="main" class="bor_div">
	    <div class="title">点击数据查询</div>
		<div class="content">
		    <div class="remind">正在查询中，请注意查收邮件!</div>
		    <div class="remind2" style="color:red">亲，开始时间必须小于结束时间！</div>
		    <div class="con_top" style="margin:0 10px;">
			<span>查询项：</span>
			    <select class="argument">
				<option selected>广告主账号</option>
				<option>offerid</option>
				<option>planid</option>
				<option>appid</option>
			    </select>
			<span style="margin-left:20px;" title="eg: KNOG7A==">查询输入：</span><input class="inputdata" title="eg: KNOG7A==" type="text" value="" />
			<span class="timedata">开始时间：</span><input type="text" class="startTime ui_timepicker" value="<?php echo date('Y-m-d',time()); ?>" />
			<span class="timedata">结束时间：</span><input type="text" class="endTime ui_timepicker" value="<?php echo date('Y-m-d',time()); ?>" /><br/>
			查询字段：　<input class="find_i find0" type="checkbox" name="find" value="clk_time" checked disabled><span title="eg: 20140101" name="find[5]">clk_time(点击时间)</span>
			<input class="find_i find1" type="checkbox" name="find" value="idfa" checked><span name="find[2]">idfa(idfa)</span>
			<input class="find_i find2" name="find" type="checkbox" value="dmac" checked><span title="eg: 88:CB:87:6A:C7:E2" name="find[0]">dmac(原始mac)</span>
			<input class="find_i find3" type="checkbox" name="find" value="macmd5" checked><span title="eg: 97AA2F9380422E499155900B7B85C927" name="find[1]">macmd5(加密mac)</span><br/>
			<input class="find_i find4 find_left" type="checkbox" name="find" value="planid" checked><span name="find[4]">planid(计划id)</span>
			<input class="find_i find5" type="checkbox" name="find" value="cid" checked><span name="find[3]">cid(offerid)</span>
			<input class="find_i find6" type="checkbox" name="find" value="pub_mediaid" checked><span title="eg: 1000675" name="find[6]">pub_mediaid(媒体id)</span><br>
			<input class="find_i find_left" type="checkbox" name="find" value="ip">ip(点击IP)
			<input class="find_i find8" type="checkbox" name="find" value="clkid">clkid(点击id)
			<input class="find_i find9" type="checkbox" name="find" value="isspam">isspam(是否作弊)<br>
		    <div class="submit"><span class="sub_button findSearch" style="margin-left:15px;height:22px;">　提 交　</span></div>
		    <div class="buttom">使用提示：<br/>
			<p>1、若查询一天数据,开始时间等于结束时间；</p>
			<p>2、时间精确到小时：  直接输入小时数；或点击小时滚动按钮；</p>
			<p>3、超过一天就只能查询整天数据，请将小时数删除；</p>
			<p>4、导出的数据按照选择的'查询字段'顺序排列；</p>
			<p>5、（点击数据查询和结算激活查询）查找'查询输入'参数,进入<a href="http://back.domob-inc.cn/offerwall/offer/list" target="_blank"> 积分墙管理 （点我进入）</a>；</p>
			<p>6、若查询当天数据则会在服务器产生一个到当天具体查询小时为止的缓存数据（即查询出的数据并不是当天全部数据），若之后只查询这一天数据则会直接将缓存数据导出（只是部分数据），</p>
			<p>解决方法：查询一天或少查询一天的方式来来避免，或者通知TS部门将缓存删除后再重新查询。</p>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</body>
<script>
$(function(){
    $('.endTime').one('change',function(){
	nstartTime = $('.startTime').val();
	nendTime = $('.endTime').val();
	nnewstartTime = transdate(nstartTime);
	nnewendTime = transdate(nendTime);
	if(nnewstartTime > nnewendTime){
	    $('.remind2').show(1500,function(){
		$(this).css({'display':'block',})
	    }).delay(2500).hide(1500);
	}
    });
    $('.ui_timepicker').change(function(){
	var cstartTime = $('.startTime').val();
	var cendTime = $('.endTime').val();
	var change_start = transhour(cstartTime);
	var change_end = transhour(cendTime);
	if(change_start == '00'){
	    $data_1 = trandate(cstartTime);
	    $('.startTime').val($data_1);
	}
	if(change_end == '00'){
	    $data_1 = trandate(cendTime);
	    $('.endTime').val($data_1);
	}
    });
    $('.findSearch').click(function(){
	var startTime = transdate($('.startTime').val());
	var endTime = transdate($('.endTime').val());
	var start_hour = transhour($('.startTime').val());
	var end_hour = transhour($('.endTime').val());
	var argument = $('.argument').val();
	var inputdata = $('.inputdata').val();
	var argument = $('.argument').val();
	if(inputdata == ''){
	    alert('查询不能为空！请输入');
	}else{
	    if(startTime > endTime){
		alert('亲，开始时间必须小于结束时间！');
	    }else if(startTime < 1392480000 || endTime < 1392480000){
		alert('亲，2月16号之前的数据无法查询，请联系TS查询！');
	    }else if(startTime == '' ||  endTime == ''){
		alert('亲，时间不能为空！');
	    }else if((start_hour != '' || end_hour != '') && (endTime - startTime) >= 86400){
		    alert('亲，超过一天就只能查询整天数据，请将小时数删除');
	    }else{
		if(endTime - startTime >= 1296000){
		    var poor = confirm('你查询的数据超过15天,请确认是否查询?');
		}
		if(poor==false){
		    return false;
		}else{
		    if(argument == '广告主账号'){
			argument = 'ad';
		    }
		    var find = '';
		    $("input[name='find']:checked").each(function(){
			find = find +','+ $(this).val();	
		    });
		    find = find.substr(1);
		    $.post("<?php echo yii::app()->createUrl('ClkActDataSearch/Dodata') ?>" , {
			'type' : 'clk',
			'argument' : argument,
			'inputdata' : inputdata,
			'startTime' : startTime,
			'endTime' : endTime, 
			'find' : find },
			function(data){
			    if(data == 'ok'){
				$('.remind').show(2500,function(){
				    $(this).css({'display':'block',})
				}).delay(2500).hide(2500);
			    } 
			}
		    );
		}
	    }
	}
    });
})
function transdate(endTime){
    var date=new Date();
    date.setFullYear(endTime.substring(0,4));
    date.setMonth(endTime.substring(5,7)-1);
    date.setDate(endTime.substring(8,10));
    date.setHours(endTime.substring(11,13));
    date.setMinutes(endTime.substring(14,16));
    date.setSeconds(endTime.substring(17,19));
    return timedata =  Date.parse(date)/1000;
} 
function transhour(time){
    return time.substring(11,13);
}
function trandate(time){
    return time.substring(0,10);
}
</script>
</html>
