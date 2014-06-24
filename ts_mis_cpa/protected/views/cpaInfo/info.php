<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="<?php echo yii::app() -> baseUrl;?>/css/expand.css"/> 
    <link rel="stylesheet" type="text/css" href="<?php echo yii::app() -> baseUrl;?>/css/CpaInfo.css"/>
    <script type="text/javascript" src="<?php echo yii::app() -> baseUrl; ?>/js/CpaInfo.js"></script>
    <script type="text/javascript" src="<?php echo yii::app() -> baseUrl; ?>/js/jQuery.js"></script>
    <script type="text/javascript" src="<?php echo yii::app() -> baseUrl; ?>/js/config.js"></script>
    <script type="text/javascript" src="<?php echo yii::app() -> baseUrl; ?>/js/zeroclipboard/ZeroClipboard.js"></script>
    <script type="text/javascript">
    </script>
    <style type="text/css">
    /*&.type{ position:relative; top:7px;margin-left:7px;}*/
    .hide{
	display:none;
    }
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

	.callback_period, .activate_mode, .app_type, .send_type {
		width:100px;
	}
    </style>
    </head>
    <body>
      <div id="container">
       <div id="main"  class="bor_div">
	<div class="title">已对接app</div>
	  <div class="clear"></div> 
	<!-- 应用主体部分 -->
	    <div id="clo" >
	    <?php foreach($edit as $infoValue): ?>
	     <div class="app">
		<ul>
		    <li>
			<span class="versionHistory">历史版本：</span>
			<b class="CurrentVersion" style="font-weight:bold;font-size:15px;color:#3A6DA4"><?php echo $infoValue->app_version?></b>
		    </li>
		    <li>
			<span class="lname">itunes地址：</span>
			<input type="text" class="itunes link" value="<?php echo $infoValue->app_itunes?>">
		    </li>
		    <li style="float:left;line-height:normal">
			<div class="appName">
			    <span>app名称：</span>
			    <input type="text" class="app_name" value="<?php echo $infoValue->app_name?>">
			</div>
			<div class="appType">
			    <span style="width:60px;">app类型：</span>
			    <select class="app_type">
				<option value="">请选择类型</option>
				<?php
				    $app_type = yii::app()->params['app_info'];
				    foreach($app_type['app_type'] as $av){
					if($infoValue->app_type == $av){
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
				if($infoValue->type == '游戏'){
				    $game = 'selected="selected"';
				}else if($infoValue->type == '应用'){
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
			    <span style="text-align:right;width:90px;margin-right:3px;">appid：</span><input type="text" class="appid" value="<?php echo $infoValue->appid?>"><span style="width:500px; text-align:left;margin-left:15px;" class="appEncrypt"></span>
			</div>
		    </li>
		    <li>
			<span class="lname">推广链接：</span>
			<input type="text" class="extendLink link" value="<?php echo $infoValue->app_link?>">
		    </li>
		    <li>
			<div style="display:none">
			    <span>自定义签名：</span>
			    <input type="text" class="customsign" style="width:420px;" value="<?php echo $infoValue->custom_sign ?>">
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
			    <ul class="par">
				<li>
				</li>
				<li>
				    <div class="macType">
					<span>选择设备：</span>
					<select class="mac_type" >
					  <option value="">请选择设备</option>
					 <?php 
					    foreach($deviceinfo as $k => $v){
						if($infoValue->mac_type == $v->id){
							echo '<option value='.$v->id.' selected=selected>'.$v->machine_name.'</option>';
						}else{
							echo '<option value='.$v->id.'>'.$v->machine_name.'</option>';
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
					if($infoValue->send_mode == $sv){
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
					<input type="text" class="activate" style="width:90px;position:relative;top:2px;" value="<?php echo $infoValue->activate_mode ?>" />
				    </div>
				    <div class="callbackPeriod" style="margin-left:-10px;">
					<span>回调周期：</span>
					<input type="text" class="callback" style="width:90px;position:relative;top:2px;" value="<?php echo $infoValue->callback_period ?>" />
				    </div>
				</li>
				<li class="machineInfo" style="display:none">
				    <div class="macCode">
					<span>mac：</span>
					<span class="deviceInfo dmac" style="text-align:left;width:auto"></span>
				    </div>
				    <div class="idfa">
					<span>idfa：</span>
					<span class="deviceInfo ifa" style="width:auto"></span>
				    </div> 
				    <div class="openudid">
					<span>openUDID：</span>
					<span class="deviceInfo oid" style="width:auto"></span>
				    </div> 
				</li>
				<li class="create" style=""><div ><span>生成的链接：</span><input type="text" class="createLink" style="width:70%;" value="<?php echo $infoValue->final_link?>" readonly="readonly"></div></li>
				<li class="note" style=""><div ><span>备注信息：</span><textarea class="noteInfo"><?php echo $infoValue->note_info?></textarea><input type="hidden" value="<?php echo $username ?>" /></div></li>
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
			<iframe class="iframes" src="" style="width:98%;height;400px;border:1px dashed #999;margin-top:5px;display:none;"></iframe>
			<div class="returnValue" style="width:98%;height;400px;border:1px dashed #999;margin-top:5px;"></div>
		    </li>
		</ul>
	     </div>
	<?php endforeach; ?>
	    </div>
	<!-- 应用主体部分结束 -->
    </div>
    </body>
    <script>


var aheight = window.screen.height;
var awidth = window.screen.width;
$('.addr').css('left',awidth*0.1);
$('.addr').css('top',aheight*0.1);

//选择设备
CpaInfo.init();

//推广url模型生成
$('.extendLink').focus(function(){
    CpaInfo.Keyboard($(this));
})

//选择设备
$('.mac_type').change(function(){
    $(this).parents('.app').find('.deviceInfo').html('');
    $(this).parents('.app').find('.itunesCode').attr('src','');
    var add = 'CpaInfo/ChangeDeviceInfo';
    var id  = $(this).val();
    var extendLink = $(this).parents('.app').find('.extendLink').val().replace(/\s/g, '');
    macTypeObj = $(this); 
    var tmpArray = [];
    tmpArray.push(id);
    for(var i in placeholder){
	    var searchValue = extendLink.match(placeholder[i]); 
	    if(searchValue != null)
		tmpArray.push(searchValue);
    }
    if($(this).val() == ''){
	$(this).parents('.app').find('.machineInfo,.create').hide(600);
    }else{
	CpaInfo.Cajax({'type':'GET', 'url':'?r='+add, 'param':tmpArray}); 
    }
    
})
//appid加密串处理
window.onload = function(){
    $('.appid').trigger('blur');
}

$('.appid').blur(function(){
    appencrypt($(this), $(this).val());
})

function appencrypt(obj, appid){
    $.get("<?php echo yii::app()->createUrl('CpaInfo/AppEncrypt') ?>" , { 'appid' : appid},
	    function(data){
		obj.parents('.app').find('.appEncrypt').html('&nbsp;&nbsp;加密串：' + data + '&nbsp;&nbsp;(<font color="#999">' + appid+ '</font>)');    
	    }
     );
}

var len = $('.mac_type').length; function b(i){ if(i+1 > len) return;$('.mac_type').eq(i).change(); setTimeout(function(){b(i+1);}, 500)};  b(0);
//显示设备信息
function ShowDeviceInfo(info){
    var macType = macTypeObj.parents('.app').find('.machineInfo');
    var link = macTypeObj.parents('.app').find('.extendLink').val().replace(/\s/g, '');
    for(var x in info){
	var tempPlaceholder = '<' + x + '>';
	var reg = new RegExp(tempPlaceholder, 'g');
	link = link.replace(reg, info[x]);
    }
    for(var i in info){
	for(var j in placeholderType){
	    for(var k in placeholderType[j]){
		if(i == placeholderType[j][k]){
		    macType.find('.' + j).html(info[i]);
		 }	    
	    }
	}
    }

var sign = macTypeObj.parents('.app').find('.customsign').val().replace(/\s/g, '');
    for(var x in info){
	var tempPlaceholder = '<' + x + '>';
	var reg = new RegExp(tempPlaceholder, 'g');
	sign = sign.replace(reg, info[x]);
    }
    macTypeObj.parents('.app').find('.stayencrypt').html(sign);
    if(sign != '')
	macTypeObj.parents('.app').find('.customsign').parent().show();
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

    
    //生成二维码
    var codeLink = '<?php echo  yii::app()->createUrl("CpaInfo/CreateQRcode") ?>
		&QRcode='+ macTypeObj.parents('.app').find('.itunes').val();
    macTypeObj.parents('.app').find('.itunesCode').attr('src',codeLink);
}


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

 //设只读属性
    $('input,textarea').attr('readonly','readonly');
    $("select").focus(function(){
       $(this).attr('defaultIndex',$(this).attr('selectedIndex'));    
       $(this).attr('disabled', 'disabled');
    });
    $("select").change(function(){
       $(this).attr('selectedIndex',$(this).attr('defaultIndex'));    
       $(this).attr('disabled', 'disabled');
    });


//隐藏或显示iframe
$('.hide').css('cursor','pointer');
$('.hide').click(function(){
    var dom = $(this).parents('.app');
    if($(this).html() == '-'){
	dom.find('.iframes').hide(400);
	$(this).html('+');
    }else{
	dom.find('.iframes').show(400);
	$(this).html('-');
    }
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
	var visitLink = 'http://ts.domob.cn/cpa_tool/cpaToolConnetMysql.php?appid=' + appid;
	var add = 'CpaInfo/SearchCallBack';
	CpaInfo.Cajax({'type':'POST', 'url':'?r='+add, 'param':{'link':'link=' + encodeURIComponent(visitLink)}});
    }else{
	alert('appid不能为空');
	return false;
    }
}

//回调结果
function searchResult(param){
    cbObj.find('.returnValue').html('');
    if(param != 'data is empty!'){
	var rows = '';
	//var arr = {'appid':100, 'macmd5':300, 'uuid':180, 'oid':180, 'status':25, 'dt':150, 'hr':50, 'dmac':200, 'source':80, 'idfa':400};
	var arr = {'appid':'10%', 'dmac':'10%', 'idfa':'30%', 'oid':'15%', 'macmd5':'10%', 'oid':'15%', 'dt':'10%', 'time':'5%'};
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
    var _clickSendUrl = '<li>点击发送Url：' + _app.find('.extendLink').val().replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</li>'
    var _example = '<li>例子：' + _app.find('.createLink').val() + '</li>'
    var _appid = '<li>appid：' + _app.find('.appid').val() + '</li>'
    var _act = '<li>激活定义：' + _app.find('.activate').val() + '</li>'
    var _callback = '<li>反馈周期：' + _app.find('.callback').val() + '</li>'
if(_app.find('.noteInfo').val()){
	var _noteInfo = '<li style="font-weight:bold;font-size:15px;color:red;">注意：'+ _app.find('.noteInfo').val() + '</li>';
    }else{
	var _noteInfo = '';
    }



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
	    alert(appClass[m]);
	    return false;
	}
    } 

       var lis = '<ul class="mailStyle" style="margin-left:40px;">' + _appName  + _type+ _appType + _itunesUrl + _sendStype + _clickSendUrl + _example + _appid + _act + _callback + _noteInfo + '</ul>';
    _app.find('.returnValue').append(lis).show();

    //一键复制
    var con = '';
    _app.find('.mailStyle li').each(function(i){
	con = con + $(this).html() + '\r\n';	    
    })
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
    alert('复制成功');
    }
}) 
</script>
</html>

