<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo yii::app()->baseUrl;?>/css/expand.css"/>
<script type="text/javascript" src="<?php echo yii::app()->baseUrl;?>/js/jQuery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('a').filter('.del').click(function(){
			if(!confirm('您确定删除该条数据么？')){
				return false;	
			}
		});
	});
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
.fun_button{
	margin-left:10px;	
}
.con_tab_title span,.list span{
	display:inline-block;
	text-align:center;
}
.list:hover {
    background:#FBFFE4;
}
.list span{
	border-bottom:1px solid #eee;	
}
.li_1,.li_2,.li_3,.li_4,.li_5,.li_6,.li_7,.li_8,.li_9 {
    overflow:hidden;
}
.li_1{
    width:5%;	
}
.li_2{
    width:15%;	
}
.li_3{
    width:20%;	
}
.li_4{
    width:10%;
}
.li_5{
    width:10%;    
}
.li_6{
    width:0%;
}
.li_7{
    width:8%;
}
.li_8{
    width:15%;
}
.li_9{
    width:8%;
}
.lis_1{
	width:26%;	
}
.lis_2{
	width:37%;	
}
.lis_3{
	width:30%;	
}


</style>
</head>
<body>
<div id="container">
    <div id="main" class="bor_div">
        <div class="title">已对接app</div>
        <div class="content">
            <div class="con_top" style="margin:0 10px;">
            <span>appid：</span><input type="text"  style="padding:0;margin-top:8px;" value="<?php echo $appid; ?>" /><span class="sub_button appidSearch" style="margin-left:15px;height:22px;">查询</span>
            <span style="margin-left:20px;">app名称：</span><input type="text"  style="padding:0;margin-top:8px;" value="<?php echo $appname; ?>" /><span class="sub_button appNameSearch" style="margin-left:15px;height:22px;">模糊查询</span>
            </div>
            <ul>
          	<li class="con_tab_title">
                	<span class="li_1">编号</span>
                	<span class="li_2">appid</span>
                    <span class="li_3">app名称</span>
                    <span class="li_4">app类型</span>
                    <span class="li_5">app版本</span>
                  <!--  <span class="li_6">验证</span> -->
                    <span class="li_7">对接人</span>
                    <span class="li_8">对接日期</span>
                    <span class="li_9">操作</span>
                </li>
                <?php foreach($app as $item):?>
                <li class="list">
		    <span class="li_1"><?php echo $item['id'];?></span>
		    <span class="li_2"><?php echo $item['appid'];?></span>
                    <span class="li_3"><?php echo $item['app_name'];?></span>
                    <span class="li_4"><?php echo $item['app_type'];?></span>
                    <span class="li_5"><?php echo $item['app_version'];?></span>
                    <?php
                      /*  if($item['is_verify'] == 0){
                    		echo '<span class="li_6" style="color:red;">否</span>'; 
 			}else{
                    		echo '<span class="li_6">是</span>'; 
			}  */
                    ?>
                    <span class="li_7"><?php echo $item['user_name'];?></span>
                    <span class="li_8"><?php echo date('Ymd H:i:s',$item['dt']);?></span>
                    <span class="li_9">
                        <a href="<?php echo yii::app()->createUrl('CpaInfo/Edit')?>&id=<?php echo $item['id'];?>">编辑</a> | 
                        <a href="<?php echo yii::app()->createUrl('CpaInfo/info')?>&id=<?php echo $item['id'];?>">详情</a> 
                    </span>
                </li>
                <?php endforeach;?>
                <li>
                  <?php
                    $this->widget('CLinkPager',array(   
                            'header'=>'',
                            'firstPageLabel'=> '',  
                            'lastPageLabel' => '',   
                            'prevPageLabel' => '上一页',   
                            'nextPageLabel' => '下一页',   
                            'pages'         => $pages,   
                            'maxButtonCount'=>10,
                            'cssFile'=> yii::app()->baseUrl."/css/page.css",
                            )
                        );   
                    ?>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
<script>
$(function(){
    $('.appidSearch').click(function(){
        window.location='<?php echo yii::app()->createUrl('CpaInfo/Search')?>'+'&appid='+$(this).prev().val();
    })
    $('.appNameSearch').click(function(){
        window.location='<?php echo yii::app()->createUrl('CpaInfo/Search')?>'+'&app_name='+$(this).prev().val();
    })
})
</script>
</html>
