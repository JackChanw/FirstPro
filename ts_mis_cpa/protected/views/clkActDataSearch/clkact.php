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
.content{
	padding:10px 0;	
}
.con_top{
    height:360px;
}
.find_i{
    position:relative;
    top:8px;
    margin-right:5px;
    margin-left:20px;
}
.video0{
    margin-left:0;
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
.find3{
    margin-left:48px;
}
.find5{
    margin-left:89px;
}
.find6{
    margin-left:52px;
}
.find8{
    margin-left:92px;
}
.remind, .remind2{
    font-size:10px;
    display:none;
    background:#E7F9AD;
    color:#5F8D00;
    margin:5px 5px 0 5px;
    padding:5px 10px;
}
.findShow{
    opacity:0.5;
}
.buttom p{
    margin-left:50px;
    line-height:20px;
}
.field1{
    margin-left:65px;
}
.field2{
    margin-left:28px;
}
.field3{
    margin-left:51px;
}
.field4{
    margin-left:67px;
}
</style>
</style>
</head>
<body>
    <div id="container">
	<div id="main" class="bor_div">
	    <div class="title">结算激活查询</div>
		<div class="content">
		    <div class="remind">正在查询中，请注意查收邮件!</div>
		    <div class="remind2" style="color:red">亲，开始时间必须小于结束时间！</div>
		    <div class="con_top" style="margin:0 10px;">
			<input class="find_i video0" name="video" type="checkbox"><span>视频积分墙（播放完成）</span>
			<input class="find_i video1" name="activate" type="checkbox"><span>视频APP激活</span><br/>
			<span>查询项：</span>
			    <select class="argument">
				<option selected>广告主账号</option>
				<option>offerid</option>
				<option>planid</option>
				<option>appid</option>
			    </select>
			<span style="margin-left:20px;"  title="eg: KNO7Gw==">查询输入：</span><input title="eg: KNO7Gw==" class="inputdata" type="text" value="" />
			<span class="timedata">开始时间：</span><input type="text" class="startTime ui_timepicker" value="<?php echo date('Y-m-d',time()); ?>" />
			<span class="timedata">结束时间：</span><input type="text" class="endTime ui_timepicker" value="<?php echo date('Y-m-d',time()); ?>" /><br/>
			查询字段：　<input class="find_i find0" type="checkbox" name="find" value="act_time" checked disabled><span title="eg: 20140102" name="find[6]">act_time(激活时间)</span>
			<input class="find_i find1" type="checkbox" name="find" value="idfa" checked><span name="find[2]">idfa(idfa)</span>
			<input class="find_i find2" name="find" type="checkbox" value="dmac" checked><span title="eg: 88:CB:87:6A:C7:E2" name="find[0]">原始mac(dmac)</span>
			<input class="find_i find3" type="checkbox" name="find" value="macmd5" checked><span title="eg: 97AA2F9380422E499155900B7B85C927" name="find[1]">加密mac(macmd5)</span><br/>
			<input class="find_i find4 find_left" type="checkbox" name="find" value="planid" checked><span name="find[4]">planid</span>
			<input class="find_i find5" type="checkbox" name="find" value="cid" checked><span name="find[3]">cid</span>
			<input class="find_i find6" type="checkbox" name="find" value="pub_mediaid" checked><span title="eg: 1000675" name="find[6]">pub_mediaid(媒体id)</span>
			<input class="find_i find7" type="checkbox" name="find" value="clk_time" checked><span title="eg: 20140101" name="find[5]">clk_time(点击时间)</span><br/>
			<div class="findOthers">附加：<span class="findShow">如需更多字段请点击</span> <a class="" href="javascript:void(0)" style="color:blue;" >更多字段</a> 
			</div>
			<div class="showOthers" style="display:none">
			    <input class="find_i find8" type="checkbox" name="find" value="ip">ip(点击IP)
			    <input class="find_i field1" type="checkbox" name="find" value="price">price(广告投放单价)
			    <input class="find_i field2" type="checkbox" name="find" value="mediashare">mediashare(媒体分成单价)<br>
			    <input class="find_i find8" type="checkbox" name="find" value="isspam">isspam(是否作弊)
			    <input class="find_i" type="checkbox" name="find" value="ad_charge">ad_charge(是否结算)
			    <input class="find_i" type="checkbox" name="find" value="media_charge">media_charge(是否分成)<br>
			    <input class="find_i find8" type="checkbox" name="find" value="clkid">clkid(点击id)
			    <input class="find_i field3" type="checkbox" name="find" value="actid">actid(激活id)
			    <input class="find_i field4" type="checkbox" name="find" value="id">id(主键id)<br>
			</div>
		    <div class="submit"><span class="sub_button findSearch" style="margin-left:15px;height:22px;">　 提 　交　 </span></div>
		    <div class="buttom">使用提示：<br/>
			<p>1、若勾选 isspam(是否作弊)、ad_charge(是否结算)、media_charge(是否分成) ，则导出数据中,1表示是，0表示否；</p>
			<p>2、如果同一个广告主账号下存在多个内部appId，请先导出一个appId的数据<b>并在邮件中下载到本地后</b>，再导出下一个appId对应的数据，防止服务器中导出数据被覆盖。</p>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</body>
<script>
$(function(){
    var status = null;
    $('.video0').bind('click',function(){
	if($('.video0').attr('checked')){
	    status = 0;
	    $('.video0').attr('checked',true);	
	    $('.video1').attr('checked',false);	
	}
    });
    $('.video1').bind('click',function(){
	if($('.video1').attr('checked')){
	    status = 1;
	    $('.video1').attr('checked',true);	
	    $('.video0').attr('checked',false);	
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
    $('.findOthers').bind('click',function(){
	$('.showOthers').fadeIn(3000);
	$('.findOthers').attr('style','display:none;');
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
			'type' : 'clk_act',
			'status' : status,
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
