<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="<?php echo yii::app() -> baseUrl;?>/css/expand.css"/> 
    <link rel="stylesheet" type="text/css" href="<?php echo yii::app() -> baseUrl;?>/css/CpaInfo.css"/>
    <script type="text/javascript" src="<?php echo yii::app() -> baseUrl; ?>/js/jQuery.js"></script>
    <script type="text/javascript" src="<?php echo yii::app() -> baseUrl; ?>/js/CpaInfo.js"></script>
    <script type="text/javascript" src="<?php echo yii::app() -> baseUrl; ?>/js/config.js"></script>
    <script type="text/javascript" src="<?php echo yii::app() -> baseUrl; ?>/js/zeroclipboard/ZeroClipboard.js"></script>
    <script type="text/javascript">
	page = "edit";
    </script>
    <style type="text/css">
    .hide{
	display:none;
    }
    .tp,.signature {float:left;}
    .mao {
	width:100px;
	overflow:hidden;
	margin-right:8px;
	border:1px solid #999;
	padding:3px;
    }
    .deviceInfo {
		font-weight:bold;
		color:red;
	
    }
	.hintContent {
    	z-index:999;
		width:800px;
        position:absolute;
		padding:5px;
		border:1px solid black;
		display:none;
    }

    #main .app ul li .createStandardLink{
	display:inline;
	width:auto;
    }
    #main .app ul li .createCallBack{
	display:inline;
	width:auto;
    }
    #main .app ul li .createTalkData{
	display:inline;
	width:auto;
    }
    #main .app ul li .openitunes{
	display:inline;
	width:auto;
    }
    .alldevice {
	margin-left:40px;
	padding-left:20px;;
	background:white;
	border:1px solid red;
	position:absolute;
	z-index:999;
	top:60px;
	display:none
    }
	.app_type, .send_type {
		width:100px;
	}
    </style>
    </head>
    <body>
      <div id="container">
       <div id="main"  class="bor_div">
	<div class="title">对接中的app</div>
	  <div class="warn" style="display:none">提示</div>
	  <div id="add">
		<span class="hint"><b class="sub_button shortcutKey">快捷键友情提示</b></span>
		<span class="hintContent"></span>
	<!--	<span class="fun_button createapp"><b class="addApp">+  添加app</b></span> -->
	  </div>
	  <div class="clear"></div> 
	<!-- 应用主体部分 -->
	    <div id="clo" style="display:none">
	     <div class="app">
		<ul>
		    <li>
			<span class="lname">itunes地址：</span>
			<input type="text" class="itunes link" value="<?php echo $edit->app_itunes?>">
			<span class="fun_button openitunes"><b class="newituneswindow">打开itunes</b></span>
		    </li>
		    <li style="float:left;line-height:normal;clear:both;">
			<div class="appName">
			    <span>app名称：</span>
			    <input type="text" class="app_name" value="<?php echo $edit->app_name?>">
			</div>
			<div class="appType">
			    <span style="width:90px;">广告投放类型：</span>
			    <select class="app_type">
				<option value="">请选择类型</option>
				<?php
				    $app_type = yii::app()->params['app_info'];
				    foreach($app_type['app_type'] as $av){
					if($edit->app_type == $av){
						echo '<option value='.$av.' selected=selected>'.$av.'</option>';
					}else{
						echo '<option value='.$av.'>'.$av.'</option>';
					}
				    }
				?>
			    </select>
			</div>
			<div class="tp" style="margin-left:-25px"><span style="">应用类型：</span>
			    <select class="type" style="width:82px;">
				<option value="">请选择类型</option>
				<?php
				$game = ''; $app = '';
				if($edit->type == '游戏'){
				    $game = 'selected="selected"';
				}else if($edit->type == '应用'){
				    $app = 'selected="selected"';
				}
				echo '<option value="应用" '.$app.'>应用</option>';
				echo '<option value="游戏" '.$game.'>游戏</option>';
				?>
			    </select>
			</div>
		    </li>
		    <li style="float:left;">
			<div>
			<span style="text-align:right;width:90px;margin-right:3px;">appid：</span><input type="text" class="appid" value="<?php echo $edit->appid?>"><span style="width:500px; text-align:left;margin-left:15px;" class="appEncrypt"></span>
			</div>
			
		    </li>
		    <div class="close" style="float:right;margin-right:10px;font-size:16px;color:gray;border:1px dotted #999;padding:3px;">close X</div>
		
		    <li>
			<span class="lname">推广链接：</span>
			<input type="text" class="extendLink link" value="<?php echo $edit->app_link?>">
			<span class="fun_button createStandardLink"><b class="StandardLink">标准链接</b></span>
			<span class="fun_button createCallBack"><b class="createCB">callback</b></span>
			<span class="fun_button createTalkData"><b class="createTD">TD链接</b></span>
		    </li>
		    <li>
			<div style="display:none">
			    <span>自定义签名：</span>
			    <input type="text" class="customsign" style="width:420px;" value="<?php echo $edit->custom_sign ?>">
			</div>
		    </li>
		    <li>
			<div style="display:none;">
			    <span>待加密串：</span><span class="stayencrypt" style="width:80%;text-align:left;"></span>
			</div>
		    </li>

		    <!-- 参数设置 -->
		    <li>
			<div class="param" >
			    <ul class="par" style="position:relative">
				<li>
				    <div class="macType">
					<span>选择设备：</span>
					<select class="mac_type">
					  <option value="">请选择设备</option>
					 <?php 
					    var_dump($ExistDeviceId);
					    foreach($deviceinfo as $k => $v){
						if(!empty($ExistDeviceId) && in_array($v->id, $ExistDeviceId)){
						    $significant = 'style="color:red;"';
						    $identification = '** ';
						}else{ 
						    $significant = '';
						    $identification = '';
						}
						if($edit->mac_type == $v->id){
							echo '<option value='.$v->id.' '.$significant.' selected=selected>'.$identification.$v->machine_name.'</option>';
						}else{
							echo '<option value='.$v->id.' '.$significant.'>'.$identification.$v->machine_name.'</option>';
						}
					    }
					?>
					</select>
				    </div>
				    <div class="sendType">
				    <span>点击发送方式：</span>
				    <select class="send_type">
				    <option value="">请选择</option>
				    <?php
				    foreach($app_type['send_mode'] as $sv){
					if($edit->send_mode == $sv){
						echo '<option value='.$sv.' selected=selected>'.$sv.'</option>';
					}else{
						echo '<option value='.$sv.'>'.$sv.'</option>';
					}
				    }   
				    ?>  
				    </select>
				    </div>
				    <div class="activateMode" style="margin-left:-10px;">
					<span>激活方式：</span>
					<input type="text" class="activate" style="width:90px;position:relative;top:2px;" value="<?php echo $edit->activate_mode ?>" />
				    </div>
				    <div class="callbackPeriod" style="margin-left:-10px;">
					<span>回调周期：</span>
					<input type="text" class="callback" style="width:90px;position:relative;top:2px;" value="<?php echo $edit->callback_period ?>" />
				    </div>
				</li>
				<li class="machineInfo">
				    <div class="macCode">
					<span>mac：</span>
					<span class="deviceInfo dmac" style="text-align:left;width:auto"></span>
				    </div>
				    <div class="idfa">
					<span>idfa：</span>
					<span class="deviceInfo ifa" style="width:auto"></span>
				    </div> 
				    <!--<div class="openudid">
					<span>openUDID：</span>
					<span class="deviceInfo oid" style="width:auto"></span>
				    </div> --> 
				</li>
				<li class="alldevice"></li>
								<li class="create" style=""><div ><span>生成的链接：</span><input type="text" class="createLink" style="width:70%;" value="<?php echo $edit->final_link?>" ></div></li>
				<li class="note" style=""><div ><span>备注信息：</span><textarea class="noteInfo"><?php echo $edit->note_info?></textarea><input type="hidden" value="<?php echo $username ?>" /><input type="hidden" class="offer_id"  value="<?php echo $edit->offer_id ?>" /></div></li>
				<li class="but">
				    <div class="saveApp"><b class="sub_button save">保存应用</b></div>
				    <div class="clickSend"><b class="sub_button sub_send">点击汇报</b><span class="hide" style="font-size:18px;width:15px;margin-right;20px;">-</span></div>
				    <div class="success"><b  class="sub_button suc" >对接成功</b></div>
				    <!-- <div class="sysVerify"><b  class="sub_button offerwalltext" >积分墙系统验证</b>
							    <b style="display:none;" class="isVerify">0</b></div> -->
				</li>
				<li style="border-top:1px solid #D0D0D0;height:1px;width:99%;margin:0 auto;"></li>
				<li class="but2" style="padding-left:70px;">
				    <b class="sub_button search" style="margin-right:15px;">立即查询</b>
				    <b class="sub_button createMail" style="margin-right:15px;">生成邮件模板</b>
				</li>
			    </ul>
			  </div>
			<div class="twoCode">
			    <img class="itunesCode" src="" style="width:200px;height:200px;margin:auto auto">
			</div>
		    </li>
		    <!-- 参数设置 -->
		    <li style="float:left">
			<div class="sendclk" style="display:none;border:1px dashed #999;width:98%">
			</div>
			<div class="returnValue" style="display:none;width:98%;height;400px;border:1px dashed #999;margin-top:5px;"></div>
		    </li>
		</ul>
	     </div>
	    </div>
	<!-- 应用主体部分结束 -->
    </div>
    </body>
    <script>
$('.oneKeySelect').click(function(){
	$(this).parent().next().find('textarea').select();	    
	})
//克隆一个最原始的app
$('#main').append($('#clo .app').clone(true)); 
$('#main .app').eq(1).find('.close').hide();

//添加应用
var addApp = 1;
$('.addApp').click(function(){
	$('#main').append($('#clo .app').clone(true).attr('id','dian'+addApp));
	addApp++; 
	})


var aheight = window.screen.height;
var awidth = window.screen.width;
$('.addr').css('left',awidth*0.1);
$('.addr').css('top',aheight*0.1);

//快捷键提示
$('.shortcutKey').mouseover(function(){
	var str = hintcon.join('<br/>');
	$(this).parent().next('.hintContent').html(str);
	$(this).parent().next('.hintContent').show();
}).mouseout(function(){
	$(this).parent().next('.hintContent').hide();
	$(this).parent().next('.hintContent').css('top', '53px');
	$(this).parent().next('.hintContent').css('left', '138px');
})

//选择设备
CpaInfo.init();

//推广url模型生成
$('.extendLink, .customsign').focus(function(){
    $(this).blur(function(){
    	$(this).val($(this).val().replace(/\s/g, ''));
    })
    CpaInfo.Keyboard($(this));
})

//判断是否显示自定义签名
$('.extendLink').blur(function(){
    var extendLink = $(this).parents('.app').find('.extendLink').val().replace(/\s/g, '');
    if(extendLink.search(/<.*_SIGN>/) > -1){	
	$(this).parents('.app').find('.customsign').parent().show();
	$(this).parents('.app').find('.customsign').trigger('blur');
    }else{
	$(this).parents('.app').find('.customsign,.stayencrypt').parent().hide();
    }
})

//标准推广链接生成
$('.StandardLink').click(function(){
    var appid = $(this).parents('.app').find('.appid').val();
    var str = '?appId=' + appid + '&mac=<DMAC_UPPER>&ifa=<IDFA>&source=domob';
    var extendLink = $(this).parents('.app').find('.extendLink').val();
    if(extendLink != ''){
    	$(this).parents('.app').find('.extendLink').val(extendLink + str);
    }else{
	warn('warn', '请先填好推广链接的基础链接', false);
	return false;
    }
})

//TD链接生成
$('.createTD').click(function(){
    var extendLink = $(this).parents('.app').find('.extendLink').val();
    var str = '?mac=<DMAC_UPPER>&idfa=<IDFA>&idtype=7';
    if(extendLink != ''){
    	$(this).parents('.app').find('.extendLink').val(extendLink + str);
    }else{
	warn('warn', '请先填好推广链接的基础链接', false);
	return false;
    }
})

//生成回调链接
$('.createCB').click(function(){
    var appid = $(this).parents('.app').find('.appid').val();
    var str = encodeURIComponent('http://e.domob.cn/track/ow/api?appId=') + appid + 
	      encodeURIComponent('&udid=') + '<DMAC_UPPER>' + 
              encodeURIComponent('&ifa=') + '<IDFA>' + 
              encodeURIComponent('&returnFormat=1');
   
    var extendLink = $(this).parents('.app').find('.extendLink').val();
    if(extendLink != ''){
    	$(this).parents('.app').find('.extendLink').val(extendLink + str);
    }else{
	warn('warn', '请先填好推广链接的基础链接', false);
	return false;
    }
}) 

//选择设备
/*window.setInterval("autoSave()", 1000 * 60 * 2)

//自动保存应用
function autoSave(){
    dom = $('#clo').next('.app');
    var appName = dom.find('.app_name').val();
    var appType = dom.find('.app_type').val();
    var itunes = dom.find('.itunes').val();
    var appid = dom.find('.appid').val();
    if(appName != '' && appType != '' && itunes != '' && appid != ''){
	sub('CpaInfo/Save', dom, 'save', 'autoSave');    
    }
}*/



//选择设备
$('.mac_type').change(function(){
    $(this).parents('.app').find('.deviceInfo').html('');
    var add = 'CpaInfo/ChangeDeviceInfo';
    var id  = $(this).val();
    var extendLink = $(this).parents('.app').find('.extendLink').val().replace(/\s/g, '');
    macTypeObj = $(this); 

    if($(this).val() == ''){
	$(this).parents('.app').find('.machineInfo,.create').hide(600);
	$(this).parents('.app').find('.customsign').parent().hide();
    }else{
	CpaInfo.Cajax({'type':'GET', 'url':'?r='+add, 'param': {'0' : id}}); 
    }
    
})


//自定义签名
$('.customsign').blur(function(){
    var that = $(this);
    var info = device;
    var sign = $(this).parents('.app').find('.customsign').val().replace(/\s/g, '');
    if(sign != ''){
	for(var x in info){
	    var tempPlaceholder = '<' + x + '>';
	    var reg = new RegExp(tempPlaceholder, 'g');
	    sign = sign.replace(reg, info[x]);
	}
	$(this).parents('.app').find('.stayencrypt').html(sign);
	$(this).parents('.app').find('.stayencrypt').parent().show();
	sign = encodeURIComponent(sign);
	var custom = '';
	var xhr = new XMLHttpRequest();
	xhr.open("get", "<?php echo yii::app()->createUrl('CpaInfo/CustomSign') ?>&sign=" + sign , true);
	xhr.send(null);
	xhr.onreadystatechange = function(){
	    if (xhr.readyState == 4 && xhr.status == 200) { 
		custom = xhr.responseText;
		that.parents('.app').find('.stayencrypt').attr('sign', custom);
	    }else{
		custom = '';
	    }
	  }
       }
})

//显示设备信息
function ShowDeviceInfo(info){
    device = info;
    var macType = macTypeObj.parents('.app').find('.machineInfo');
    macTypeObj.parents('.app').find('.extendLink').trigger('blur');
    var link = macTypeObj.parents('.app').find('.extendLink').val().replace(/\s/g, '');
    for(var x in info){
	var tempPlaceholder = '<' + x + '>';
	var reg = new RegExp(tempPlaceholder, 'g');
	link = link.replace(reg, info[x]);
    }
    macType.find('.dmac').html(info.DMAC_UPPER);
    macType.find('.ifa').html(info.IDFA);
    
var sign = macTypeObj.parents('.app').find('.customsign').val().replace(/\s/g, '');
    for(var x in info){
	var tempPlaceholder = '<' + x + '>';
	var reg = new RegExp(tempPlaceholder, 'g');
	sign = sign.replace(reg, info[x]);
    }
    macTypeObj.parents('.app').find('.stayencrypt').html(sign);
    if(sign != ''){
	macTypeObj.parents('.app').find('.stayencrypt').parent().show();
	var custom = '';
	var xhr = new XMLHttpRequest();
	xhr.open("get", "<?php echo yii::app()->createUrl('CpaInfo/CustomSign') ?>&sign=" + sign , true);
	xhr.send(null);
	xhr.onreadystatechange = function(){
	    if (xhr.readyState == 4 && xhr.status == 200) { 
		custom = xhr.responseText;
		var extendLink = macTypeObj.parents('.app').find('.extendLink').val().replace(/\s/g, '');
		var csign = macTypeObj.parents('.app').find('.customsign').val();
		    if(extendLink.search(/<.*_SIGN>/) > -1 && csign != '' && custom.search('error') < 0){
			link = link.replace(/<.*_SIGN>/, custom);
			warn('warn', '自定义签名加密成功', true);
		    }

		    macType.show(600);
		    macTypeObj.parents('.app').find('.createLink').val(link);
		    macTypeObj.parents('.app').find('.create').show(600);
	    }else{
		custom = '';
	    }
	}
    }else{
	macTypeObj.parents('.app').find('.stayencrypt').parent().hide();
    }


    macType.show(600);
    macTypeObj.parents('.app').find('.createLink').val(link);
    macTypeObj.parents('.app').find('.create').show(600);

    //生成二维码
    var codeLink = '<?php echo  yii::app()->createUrl("CpaInfo/CreateQRcode") ?>
		&QRcode='+ macTypeObj.parents('.app').find('.itunes').val();
    macTypeObj.parents('.app').find('.itunesCode').attr('src',codeLink);

//显示所有的设备信息
    d = [];
    d[0] = '大写带冒号的MAC地址：' + info.DMAC_UPPER;
    d[1] = '经过MD5加密的MAC地址：' + info.MD5_MAC;
    d[2] = '大写不带冒号的MAC地址：' + info.DMAC_PURE_NUM;
    d[3] = '小写不带冒号的MAC地址：' + info.DMAC_PURE_NUM_LOWER;
    d[4] = '小写带冒号的MAC地址：' + info.DMAC_LOWER;
    d[5] = '大写的带分隔符的IDFA：' + info.IDFA;
    d[6] = '大写的不带分隔符的IDFA：' + info.NOCOLONIDFA;
    d[7] = '小写的带分隔符的IDFA：' + info.IDFA_LOWER;
    d[8] = '小写的带分隔符的IDFA：' + info.NOCOLONIDFA_LOWER;
    d[9] = 'OpenUDID：' + info.OPEN_UDID;
    d[10] = '小写的OpenUDID：' + info.OPEN_UDID_LOWER;

    var separate = '&nbsp;&nbsp;&nbsp;&nbsp;';
    var left = [];
    var right = [];
    for(x in d){
	if(x % 2 == 0)
	    left.push(d[x]);
	else
	    right.push(d[x]);
    }
    var l = left.join('<br/>'); 
    var r = right.join('<br/>'); 
    str = '<div style="float:left;">' + l + '</div>' + '<div style="margin-left:40px;float:left;">' + r  + '</div>';
    macTypeObj.parents('.app').find('.dmac, .ifa, .oid').hover(
	function(){
	    $(this).parents('.app').find('.alldevice').html(str);
	    macTypeObj.parents('.app').find('.alldevice').delay(1000).show(0);
	}, function(){
	    macTypeObj.parents('.app').find('.alldevice').dequeue();
	    //window.clearTimeout(times);
	    $(this).parents('.app').find('.alldevice').hide();
	    $(this).parents('.app').find('.alldevice').hover(function(){$(this).show()}, function(){$(this).hide();});
	}	
    )
}


//新窗口打开itunes地址
$('.newituneswindow').click(function(){
var itunes = $(this).parents('.app').find('.itunes').val();
    if(itunes.search('https:') > -1){
	window.open(itunes);	
    }else if(itunes == ''){
	warn('warn', 'itunes地址不能为空', false);
    }else{
	warn('warn', 'itunes地址不合法', false);
    } 
})

//itunes地址生成appid
$('.itunes').blur(function(){
	that = $(this);
	var add = 'CpaInfo/CreateAppName';
	var dom = $(this).parents('.app');
	var itunes =  dom.find('.itunes').val().replace('http:', 'https:').replace(/\s/g, '');
	dom.find('.itunes').val(itunes);
	if(itunes != ''){
		if(dom.find('.app_name').val() == ''){
			CpaInfo.Cajax({'type':'POST', 'url':'?r='+add, 'param':{'link':'itunes='+ CpaInfo.UrlReplaceCode(itunes)}});
		}
		if(dom.find('.appid').val() == ''){
		    var appid = $(this).val().match(/(id\d+)/g)[0].substr(2);
		    $(this).parents('.app').find('.appid').val(appid);    
		    appencrypt(that, appid);
		}

	}else{
		warn('warn', 'itunes不能为空', false);
		return false;
	}
	})

//appid加密串处理
window.onload = function(){
    $('.appid').trigger('blur');
    $('.mac_type').trigger('change');
}

$('.appid').blur(function(){
    var appid = $(this).val();
    if(appid != '')
	appencrypt($(this), appid);
})

function appencrypt(obj, appid){
    $.get("<?php echo yii::app()->createUrl('CpaInfo/AppEncrypt') ?>" , { 'appid' : appid},
	    function(data){
		obj.parents('.app').find('.appEncrypt').html('&nbsp;&nbsp;加密串：' + data + '&nbsp;&nbsp;(<font color="#999">' + appid+ '</font>)');    
	    }
     );
}

//生成appName
function AppNameCreate(param){
    var dom = that.parents('.app');
    if(param != 'data is empty'){
	dom.find('.app_name').val(param);
    }else{
	warn('warn', '此应用在浏览器打不开，请用IOS设备直接测试', false);
	return false; 
    }

}

//选择其它时产生input框
function other(id){
    $(id).change(function(){
	if($(this).find('option:selected').html() != "请选择"){
	$(this).parent().find('input').val($(this).find('option:selected').html());
	if($(this).find('option:selected').val() != ''){
	    if($(this).find('option:selected').html() == '其它'){
		$(this).parent().find('input').show();
	    }else{
		$(this).parent().find('input').hide();
	    }
	}
    }
})
}
other('.activate_mode');
other('.callback_period');

//积分墙仿真接口测试
$('.offerwalltext').click(function(){
    var param = $(this).pareants('.app').find('.extendLink').val();
    $.ajax({
	type: "POST",
	url: offerWallTest.link,
	data: offerWallTest.field + '=' + param,
	success: function(data){
	    comparison(data);
	}
    });
})



//仿真接口返回值对比
function comparison(data){
    //等待开发接口
}

//发送点击报告
$('.sub_send').click(function(){
    var dom = $(this).parents('.app');
    dom.find('.sendclk').html('');
    dom.find('.sendclk').append('<span class="loading">loading......</span>');
    dom.find('.sendclk').show();
    var _createLink = dom.find('.createLink').val().replace(/\s/g, '');

    var iframe = document.createElement("iframe"); 
    iframe.src = _createLink; 
    iframe.style.width = '98%';
    iframe.style.height = '80px';
    iframe.style.margin.top = '5px';
    iframe.style.display = 'none';
    iframe.className = 'iframes';

    dom.find('.loading').parent().append(iframe);
    iframe.onload = function(){
	dom.find('.loading').hide();
	iframe.style.display = 'block';
    }

    //提交对应关系到存在设备表
    _itunesId = dom.find('.itunes').val().match(/id\d+/g)[0].substr(2);
    _deviceId = dom.find('.mac_type').val();
    if(_itunesId == ''){
	warn('warn', '没有获取到itunes id', false);
    }else{
	$.post(
	    "<?php echo yii::app()->createUrl('CpaInfo/addHistoryTestDevice') ?>" , 
	    { 'itunes_id' : _itunesId, 'device_id' : _deviceId }, 
	    function(data){
		var returnValue = eval('('+ data+')');
		AlertInfo(returnValue.param);
		}
	); 
    }
     
})


//隐藏或显示iframe
$('.hide').css('cursor','pointer');
$('.hide').click(function(){
    var dom = $(this).parents('.app');
    if($(this).html() == '-'){
	dom.find('.sendclk').hide(400);
	$(this).html('+');
    }else{
	dom.find('.sendclk').show(400);
	$(this).html('-');
    }
})

//编辑成功
$('.suc').click(function(){
	var dom = $(this).parents('.app');
	sub('CpaInfo/EditSub', dom, 'sub');

	})

//编辑保存应用
$('.save').click(function(){
    var dom = $(this).parents('.app');
    sub('CpaInfo/EditSave', dom, 'save');    
})

//查询是否有回调
$('.search').click(function(){
    var dom = $(this).parents('.app');
    $(this).parents('.app').find('.returnValue').html('&nbsp;&nbsp;&nbsp;&nbsp;<b>loading......</b>');
    getBackInf(dom);
}) 

//获取回调    
function getBackInf(dom){
    cbObj = dom;
    var appid = dom.find('.appid').val();
    if(appid != ''){
	var visitLink = appid;
	var add = 'CpaInfo/SearchCallBack';
	CpaInfo.Cajax({'type':'GET', 'url':'?r='+add, 'param':{'link':visitLink}});
    }else{
	warn('warn', 'appid不能为空', false);
	return false;
    }
}

//回调结果
function searchResult(param){
    cbObj.find('.returnValue').html('');
    if(param != 'data is empty!'){
	var rows = '';
	var arr = {'appid':'10%', 'dmac':'10%', 'idfa':'30%', 'uuid':'15%', 'macmd5':'10%', 'dt':'10%', 'time':'5%'};
	var th = '';
	for(var j in arr){
	    th = th + '<span style="overflow:hidden;font-weight:bold;font-color:black;text-align:center;width:' + arr[j] + 
		'">' + j + '</span>';
	}
	$.each(param, function(k, v){
	    var str = '';
	    for(var i in arr){
		str = str + '<span style="overflow:hidden;text-align:center;width:' + arr[i] + 
		    '">' + v[i] + '</span>';
	    }
	     rows = rows + '<li style="border-bottom:1px dashed #999;line-height:30px;width:100%">' + str + '</li>';
	})
	var tab = '<ul>' + '<li style="border-bottom:1px dashed #999;line-height:30px;width:100%">' +th + '</li>' + rows + '</ul>';
	cbObj.find('.returnValue').append(tab).show();
    }else{
	$('.returnValue').html('Is empty!').show();
    }
}


//关闭本app
$('.close').mouseover(function(){
	$(this).css('cursor','pointer');
	})
$('.close').click(function(){
	var dom = $(this).parents('.app');
	dom.slideUp("slow");
	dom.parents('#main').find('.'+dom.attr('id')).hide();
	})


//生成发邮件模板
$('.createMail').click(function(){
    var _app = $(this).parents('.app');
    _app.find('.returnValue').html('');

    //一键复制
    _app.find('.returnValue').append('<button class="sub_button oneKeySelect" id="oneCopy">一键复制</button>');

    var _appName = '<li>app名称：《' + _app.find('.app_name').val() + '》</li>'
    var _type = '<li>应用类型：' + _app.find('.type').val() + '</li>'
    var _appType = '<li>投放类型：' + _app.find('.app_type').val() + '</li>'
    var _itunesUrl = '<li>itunesUrl：' + _app.find('.itunes').val() + '</li>'
    var _sendStype = '<li>点击发送方式：' + _app.find('.send_type').val() + '</li>'
    var _clickSendUrl = '<li>点击发送Url：' + _app.find('.extendLink').val().replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</li>'
    var _example = '<li>例子：' + _app.find('.createLink').val().replace(/&/g, '&amp;') + '</li>'
    var _appid = '<li>appid：' + _app.find('.appid').val() + '</li>'
    var _act = '<li>激活定义：' + _app.find('.activate').val() + '</li>'
    var _callback = '<li>反馈周期：' + _app.find('.callback').val() + '</li>'
    
if(_app.find('.noteInfo').val() && _app.find('.noteInfo').val() != ''){
	var _noteInfo = '<li style="font-weight:bold;font-size:15px;color:red;">注意：'+ _app.find('.noteInfo').val() + '</li>';
	var _emailNoteInfo = '注意：'+ _app.find('.noteInfo').val();
    }else{
	var _emailNoteInfo = '';
	var _noteInfo = '';
    }

    //邮件内容
    var _info = 'app名称：《' + _app.find('.app_name').val() + '》\r\n' +
    '应用类型：' + _app.find('.type').val() + '\r\n' +
    '投放类型：' + _app.find('.app_type').val() + '\r\n' +
    'itunesUrl：' + _app.find('.itunes').val() + '\r\n' +
    '点击发送方式：' + _app.find('.send_type').val() + '\r\n' +
    '点击发送Url：' + _app.find('.extendLink').val().replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;') + '\r\n' +
    '例子：' + _app.find('.createLink').val().replace(/&/g, '&amp;') + '\r\n' +
    'appid：' + _app.find('.appid').val() + '\r\n' +
    '激活定义：' + _app.find('.activate').val() + '\r\n' +
    '反馈周期：' + _app.find('.callback').val() + '\r\n' +
    _emailNoteInfo;


    switch(_app.find('.app_type').val()){
	case 'offerwall': var at = '积分墙';break;  
	case 'banner_offerwall': var at = 'banner与积分墙';break;  
	case 'banner': var at = 'banner';break;
    }
     _appType = '<li>投放类型：' + at + '</li>'

    //生成邮件模板为空测试
    var appClass = {
	    'app_name' : 'app名称不能为空', 
	    'app_type' : '请选择app类型',
	    'itunes' : 'itunes链接不能为空', 
	    'send_type' : '请选择发送类型', 
	    'appid' : 'appid不能为空', 
	    'activate' : '激活定义不能为空', 
	    'callback' : '反馈周期不能为空'
	};

    for(var m in appClass){
	if(_app.find('.' + m).val()== ''){
	    warn('warn', appClass[m], false);
	    return false;
	}
    } 

    
    var lis = '<ul class="mailStyle" style="margin-left:40px;">' + _appName + _type + _appType + _itunesUrl + _sendStype + _clickSendUrl + _example + _appid + _act + _callback + _noteInfo + '</ul>';
    _app.find('.returnValue').append(lis).show();
    
    //一键复制
    var con = '';
    /*_app.find('.mailStyle li').each(function(i){
	con = con + $(this).html() + '\r\n';	    
    })*/
    con = _info.replace('offerwall', '积分墙').replace('banner_offerwall', 'banner与积分墙');	
    var info = con.replace(/&lt;/g,'<').replace(/&gt;/g, '>').replace(/&amp;/g, '&');
    ZeroClipboard.moviePath = "<?php echo yii::app() -> baseUrl; ?>/js/zeroclipboard/ZeroClipboard.swf";
    var clip = new ZeroClipboard.Client();
    clip.setText(info); // 设置要复制的文本。
    clip.setHandCursor(true); // 设置鼠标为手型
    // 注册一个 button，参数为 id。点击这个 button 就会复制。
    //这个 button 不一定要求是一个 input 按钮，也可以是其他 DOM 元素。
    clip.glue("oneKeySelect"); // 和上一句位置不可调换
    clip.addEventListener('onComplete', onComplete);
    function onComplete(){
	    warn('warn', '复制成功', true);
    }
}) 

//数据提交方法
function sub(add, dom, type, autoSaves){
    var appName = dom.find('.app_name').val();
    var types = dom.find('.tp select').val();
    var appType = dom.find('.app_type').val();
    var extendLink = CpaInfo.UrlReplaceCode(dom.find('.extendLink').val());
    var itunes = CpaInfo.UrlReplaceCode(dom.find('.itunes').val());
    var appid = dom.find('.appid').val();
    var macType = dom.find('.mac_type').val();
    var activate = dom.find('.activate').val();
    var callback = dom.find('.callback').val();
    var sendStyle = dom.find('.send_type').val();
    var createLink =CpaInfo.UrlReplaceCode(dom.find('.createLink').val());
    var noteinfo = dom.find('.noteInfo').val();
    //操作人
    var username = dom.find('.noteInfo').next().val();
    var offer_id = dom.find('.offer_id').val();
    //是否通过仿真接口验证
    var verify = dom.find('.isVerify').html(); 
    var customsign = dom.find('.customsign').val();
    var link = 'appName=' + appName +
		'&type=' + types +
	       '&appType=' + appType +
	       '&extendLink=' + extendLink +
	       '&itunes=' + itunes +
	       '&appid=' + appid +
	       '&mac_type=' + macType +
	       '&activate=' + activate +
	       '&callback=' + callback +
	       '&sendStyle=' + sendStyle +
	       '&createLink=' + createLink +
	       '&noteinfo=' + noteinfo +
	       '&verify=' + verify +
	       '&username=' + username +
	       '&offer_id=' + offer_id +
	       '&customsign=' + customsign;

    //提示信息
    var hint = {
	    'app_name' : 'app名称不能为空',
	    'app_type' : '请选择app类型',
	    'extendLink' : '推广链接不能为空',
	    'itunes' : 'itunes地址不能为空',
	    'appid' : 'appid不能为空',
	    'mac_type' : '请选择设备',
	    'activate' : '请确认激活定义',
	    'callback' : '请确认回调周期',
	    'send_type' : '请选择发送方式',
    }

    if(type == 'sub'){
    	if(appName && appType && extendLink && itunes && appid && macType && activate && callback && sendStyle && createLink){
	    if(confirm('是否确认要提交')){
		$.post("<?php echo yii::app()->createUrl('CpaInfo/InsertData') ?>" , { 'appName' : appName,
			       	      'appType' : appType,
				      'type' : types,
			       	      'extendLink' : extendLink,
			       	      'itunes' : itunes,
			       	      'appid' : appid,
			       	      'mac_type' : macType,
			       	      'activate' : activate,
			       	      'callback' : callback,
				      'sendStyle' : sendStyle,
			     	      'createLink' : createLink,
			       	      'noteinfo' : noteinfo,
			       	      'verify' : verify,
			       	      'username' : username,
			       	      'offer_id' : offer_id,
				      'customsign' : customsign }, 
			function(data){
				var returnValue = eval('('+ data+')');
				AlertInfo(returnValue.param, autoSaves);
			}
		 );
	    }
	}else{
	    for(var i in hint){
		if(dom.find('.' + i).val() == ''){
		    warn('warn', hint[i], false);
		    return false;
		}
		
	    }
	}

    }else if(type == 'save' && appName && appType && appid){
		$.post("<?php echo yii::app()->createUrl('CpaInfo/Save') ?>" , { 'appName' : appName,
			       	      'appType' : appType,
				      'type' : types,
			       	      'extendLink' : extendLink,
			       	      'itunes' : itunes,
			       	      'appid' : appid,
			       	      'mac_type' : macType,
			       	      'activate' : activate,
			       	      'callback' : callback,
				      'sendStyle' : sendStyle,
			     	      'createLink' : createLink,
			       	      'noteinfo' : noteinfo,
			       	      'verify' : verify,
			       	      'username' : username,
			       	      'offer_id' : offer_id,
				      'customsign' : customsign }, 
			function(data){
				var returnValue = eval('('+ data+')');
				AlertInfo(returnValue.param, autoSaves);
			}
		 );
    }else{
	warn('warn', '保存应用必须要填写app名称，选择app类型和填写appid', false);
	return false;
    }
}

//提示信息
function AlertInfo(statuses, autoSaves){
	 var inf = '';
              switch(statuses){
                  case 10000: inf = '数据保存成功';break;
                  case 10001: inf = '不能重复提交';break;
                  case 10002: inf = '参数不能为空';break;
                  case 10003: inf = '数据提交失败';break;
                  case 10004: inf = '数据提交成功';break;
                  case 10005: inf = '更新数据失败';break;
		  case 10006: inf = '至少得有一个占位符吧';break;
		  case 10007: inf = '网络繁忙';break;
              }
              if(inf != ''){
		if(statuses == 10000 || statuses == 10004)
		    var st = true;
		else
		    var st = false;

		if(autoSaves != 'autoSave')
		    warn('warn', inf, st);

                    if(statuses == 10004){
						//location.href = "<?php echo yii::app()->createUrl('CpaInfo/list') ?>";
                       // document.location.reload();//当前页面  
                    }
              }

		return false;
}

//监测所有的事件，为之后关闭浏览器窗口做判断 
$('input, select, textarea').click(function(){
    changes = true; 	
})



</script>
</html>

