<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
    height:300px;
}
.find_o{
    position:relative;
    top:8px;
    margin-left:2px;
    margin-right:5px;
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
.con_top{
    background:white;
    border:none;	
}
.find_left{
         margin-left:92px;
}
.findSearch{
    position:relative;
    left:20px;
}
.find5{
    margin-left:88px;
}
.find6{
    margin-left:52px;
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
</style>
</style>
</head>
<body>
    <div id="container">
	<div id="main" class="bor_div">
	    <div class="title">原始激活查询</div>
		<div class="content">
		    <div class="remind">正在查询中，请注意查收邮件!</div>
		    <div class="remind2" style="color:red">亲，开始时间必须小于结束时间！</div>
		    <div class="con_top" style="margin:0 10px;">
		    <input class="find_o" type="checkbox" /><span>非积分墙查询</span><br/>
		    <span>查询项：</span><input type="text" value="appid" class="argument" readonly="value" size="3" />
		    <span style="margin-left:20px;" title="eg: KNO7Gw==">查询输入：</span><input class="inputdata" title="eg: 694967307" type="text" value="" />
		    <span class="timedata">开始时间：</span><input type="text" class="startTime ui_timepicker" value="<?php echo date('Y-m-d',time()); ?>" />
		    <span class="timedata">结束时间：</span><input type="text" class="endTime ui_timepicker" value="<?php echo date('Y-m-d',time()); ?>" /><br/>
		    查询字段：　<input class="find_i find4" type="checkbox" name="find" value="act_time" checked disabled><span title="eg: 20140102" name="find[4]">act_time(激活时间)</span>
		    <input class="find_i find0" type="checkbox" name="find" value="idfa" checked><span name="find[2]">idfa(idfa)</span>
		    <input class="find_i find1" name="find" type="checkbox" value="dmac" checked><span title="eg: 88:CB:87:6A:C7:E2" name="find[1]">原始mac(dmac)</span>
		    <input class="find_i find2" type="checkbox" name="find" value="macmd5" checked><span title="eg: 97AA2F9380422E499155900B7B85C927" name="find[2]">加密mac(macmd5)</span>
		    <input class="find_i find3" type="checkbox" name="find" value="oid" checked><span name="find[3]">openUDID</span><br/>
		    <div class="submit"><span class="sub_button findSearch" style="margin-left:15px;height:22px;">　 提 　交　 </span></div>
		    <div class="buttom">使用提示：<br/>
			<p>1、非积分墙查询（status=3）表示banner的查询</p>
			<p>2、（原始激活）查找appid,请查看TS技术发送的对接信息邮件,或询问TS技术；</p>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</body>
<script>
$(function(){
    var status = null;
    $('.find_o').bind('click',function(){
	if($('.find_o').attr('checked')){
	    status = 3;
	    $('.find_i').attr('checked','true');
	    $('.find_i').attr('disabled','disabled');	
	}else{
	    status = null;
	    $('.find_i').removeAttr('disabled');	
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
		    var find = '';
		    $("input[name='find']:checked").each(function(){
			find = find +','+ $(this).val();	
		    });
		    find = find.substr(1);
		    $.post("<?php echo yii::app()->createUrl('ClkActDataSearch/Dodata') ?>" , {
			'type' : 'act',
			'argument' : argument,
			'inputdata' : inputdata,
			'startTime' : startTime,
			'endTime' : endTime, 
			'status' : status, 
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
