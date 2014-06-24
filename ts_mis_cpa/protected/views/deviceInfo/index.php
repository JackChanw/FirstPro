<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo yii::app()->baseUrl;?>/css/base.css"/>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/base.js"></script>
<script type="text/javascript">
var expand = {
    init:function(){
        cyexpand = this;
        cyexpand.warn();
    },
    warn:function() {
        if($('.groupOperateWarn').hasClass('success')) {
            setTimeout(function(){$('.groupOperateWarn').animate({
                opacity:0,
                width:0,
                height:0,
                marginTop:0,
                fontSize:10
            }, 2000)}, 5000);
        }
    },
}
</script>
<style type="text/css">
.fun_button{margin-left:10px;	}
#table{margin-top:8px;}
.groupdiv{margin-top:10px;}
.li_1{width:12%;}
.li_2{width:42%;}
.li_3{width:22%;}
.li_4{width:22%;}

.lis_1{width:26%;}
.lis_2{width:37%;}
.lis_3{width:30%;}
</style>
</head>
<body>
<?php $operateWarn = Yii::app()->user->getFlash('operateWarn'); ?>
<?php $class = !empty($operateWarn['status']) && $operateWarn['status'] ? 'success' : 'error'; ?>
<?php $source = !empty($operateWarn['source']) ? $operateWarn['source'] : false; ?>
<div id="container">
    <div id="main" class="bor_div">
        <div class="title">设备信息</div>
        <div id="operateWarn" class="<?php echo $source == 'user' ? $class : 'error'; ?>">
	    <?php echo $source == 'user' ? (!empty($operateWarn['msg']) ? $operateWarn['msg'] : '') : ''; ?>
	</div>
        <div class="content">
	    <span class="fun_button" onclick="location='<?php echo Yii::app()->createUrl('adminUser/adduser');?>'"><b>添加设备</b></span>
            <ul id="table">
            	<li class="tab_title">
                    <span class="li_1">编号</span>
                    <span class="li_2">设备名</span>
                    <span class="li_3">系统版本</span>
                    <span class="li_4">操作</span>
                </li>
                <?php foreach($info as $item):?>
            	<li class="tab_list">
		    <span class="li_1"><?php echo $item->id;?></span>
                    <span class="li_2"><?php echo $item->machine_name;?></span>
                    <span class="li_3" title=""><?php echo $item->sys_version?></span>
                    <span class="li_4">
			<a href="<?php echo Yii::app()->createUrl('adminUser/modUser', array('id' => $item->id));?>">编辑</a> | 
			<a action="true" actType="del" href="<?php echo Yii::app()->createUrl('adminUser/delUser', array('id' => $item->id));?>">删除</a>
		    </span>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>

    </div>
</div>
</body>
</html>
