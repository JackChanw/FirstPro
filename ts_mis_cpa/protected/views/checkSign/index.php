<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="<?php echo yii::app()->baseUrl;?>/css/base.css"/>
    <script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/jquery.js"></script>
    <style type="text/css">
	/** **/
	#table .tab_list:hover {
	    background: none;
	}
	#table .tab_list .tb_left {
	    width: 100px;
	    text-align: right;
	}
	#table .tab_list .tb_inp_url {
	    float: left;
	    height: 45px;
	    line-height: 45px;
	}
	/** 校验结果 **/
	#result {
	    width: 810px;
	    height: 100px;
	    border: 1px solid #dddddd;
	    margin: 30px 0px 30px 110px;
	}
	#result .result_info {
	    height: 80px;
	    margin: 10px 20px 0px 20px;
	}
	#result .result_info .info {
	    float: left;
	    width: 400px;
	    padding-left: 100px;
	}
	#result .result_info .info span {
	    display: block;
	    height: 40px;
	    line-height: 40px;
	}
	#result .result_title {
	    float: right;
	    margin: -10px 20px 0px 0px;
	    padding: 0px 10px;
	    background: #ffffff;
	}
	#msg { /* 校验结果信息：校验成功或校验失败 */
	    float: left;
	    font-size: 25px;
	    height: 80px;
	    line-height: 80px;
	}
	/** 提交按钮 **/
	.btn {
	    margin: 10px 0 0 110px;
	}
    </style>
</head>

<body>
<div id="container">
    <div id="main" class="bor_div">
        <div class="title">Sign校验</div>
        <?php // 操作结果提示模块 begin，不需要修改 ?>
	<?php $operateWarn = Yii::app()->user->getFlash('operateWarn'); ?>
	<?php $class = !empty($operateWarn['status']) && $operateWarn['status'] ? 'success' : 'error'; ?>
        <div id="operateWarn" class="<?php echo $class; ?>">
            <?php echo !empty($operateWarn['msg']) ? $operateWarn['msg'] : ''; ?>
        </div>
        <?php // 操作结果提示模块 end ?>
	<div class="content">
	    <ul id="table">
		<li class="tab_list" style="height:45px"> 
		    <span class="tb_left tb_inp_url">回调地址：</span>
		    <span class="tb_right tb_inp_url">
			<textarea name="inp_url" style="height:28px;width:800px;resize:none"></textarea>
		    </span>
		    <span class="tb_inp_url"><em>&nbsp;&nbsp;* 不允许为空</em></span>
		</li>
		<div style="clear:both"></div>
		<div class="btn">
		    <input type="button" id="btn_submit" class="sub_button" value="校验一下">
		</div>
		<!-- 校验结果显示部分 -->
		<div id="result">
		    <span class="result_title">校验结果</span>
		    <div class="result_info">
			<div class="info">
			    <span>回调Sign：<b id="sign_callback"></b></span>
			    <span>多盟Sign：<b id="sign_domob"></b></span>
			</div>
			<span id="msg"></span>
		    </div>
		</div>
		<!-- end 校验结果显示部分 -->
	    </ul>
        </div>
    </div>
</div>
<script type="text/JavaScript">
//
$("#btn_submit").click(function() {

    // 获取url，并拆分出所需处理的参数部分
    var inp_url = $("textarea[name='inp_url']").val();

    // 参数基本校验
    if(!checkFormat(inp_url)) return false;

    // 请求服务器进行校验，处理返回结果
    $.ajax({
	type: "POST",
	url: "<?php echo Yii::app()->createUrl('checkSign/index'); ?>",
	data: inp_url.split("?")[1],
	success: function(data) {

	    // 将返回结果转为json对象
	    var oData = eval("(" + data + ")");

	    // 显示广告主回调激活url中的Sign和根据接口文档生成的多盟Sign
	    $("#sign_callback").html(oData.sign_callback);
	    $("#sign_domob").html(oData.sign_domob);

	    // 显示校验结果
	    if(oData.code == '200') {
		$("#msg").html("<b style='color:green'>:) 校验成功！</b>");
	    } else if(oData.code == '300') { 	
		$("#msg").html("<b style='color:#ff0000'>:( 不一致！</b>"); 
	    } else {
		$("#sign_callback").html("");
		$("#sign_domob").html("");
		$("#msg").html("");
		alert(oData.msg);	
	    }
	}
    });
});

/**
 * 校验回调地址
 */
function checkFormat(data) {
    if(data !== '') {
	var reg = /^(http:\/\/e\.domob\.cn\/track\/ow\/api\/postback?).*?$/;
	if(!reg.test(data)) {
	    alert("无效的URL格式！");
	} else {
	    return true;
	}
    } else {
	alert("回调地址不能为空！");
    }
}
</script>
</body>
</html>
