<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
<!-- 
*{ padding:0; margin:0; font-size:12px}
a:link,a:visited{text-decoration:none;color:#0068a6}
a:hover,a:active{color:#ff6600;text-decoration: underline}
.showMsg{border: 1px solid #1e64c8; zoom:1; width:450px; height:172px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px}
.showMsg h5{background-image: url('<?php echo yii::app()->baseUrl;?>/images/msg.png');background-repeat: no-repeat; color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .content{ padding:46px 12px 10px 45px; font-size:13px; height:64px; text-align:left}
.showMsg .bottom{ background:#e4ecf7; margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center;color:gray;}
.showMsg .ok,.showMsg .guery{background: url('<?php echo yii::app()->baseUrl;?>/images/msg_bg.png') no-repeat 0px -560px;}
.showMsg .guery{background-position: left -460px;}
-->
</style>
</head>
<body>
<div class="showMsg" style="text-align:center">
	<h5>提示信息</h5>
    <div class="content guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;max-width:330px">
        <?php
        //为false值得时候是错误信息
        if($status):
        ?>
        <font><?php echo $message;?></font>
        <?php else:?>
        <font color="red"><?php echo $message;?></font>
        <?php endif;?>
    </div>
    <div class="bottom">
    	<b id="no"></b> 后自动跳转到 <a href="javascript:
    	<?php if($repath == 'admin/index'):?>
    	window.top.location='/yiiIdealAdmin/index.php?r=admin/index'
    	<?php elseif($repath != ''):?>
    	window.location='<?php echo yii::app()->createUrl($repath);?>'
    	<?php else:?>
    	window.history.back()
    	<?php endif;?>
    	">这里</a>  ，请稍后...
	</div>
</div>
	<script type="text/javascript">
		function time(i){
			document.getElementById('no').innerHTML=i;
			if(i==0){
				setTimeout(function(){  	
				<?php if($repath == 'admin/index'):?>
				window.top.location='/yiiIdealAdmin/index.php?r=admin/index'
				<?php elseif($repath != ''):?>
				window.location='<?php echo yii::app()->createUrl($repath);?>'
				<?php else:?>
				window.history.back()
				<?php endif;?>},1000);
				return;
			}
			setTimeout('time('+(i-1)+')',1000);
		}
		time(3);
	</script>
</body>
</html>
