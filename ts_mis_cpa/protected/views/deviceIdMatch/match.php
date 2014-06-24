<?php
$this->pageTitle=Yii::app()->name . ' - 数据核对'; 
$this->breadcrumbs=array(
    'CPA'=>array('#'),
    '自助工具'=>array('#'),
    '数据核对',
);
?>

<legend><h1>数据核对</h1></legend>
<br>


<style type="text/css">
.fileInput{
    border:1px solid #ccc;
    height:20px;
    line-height:20px;
    padding:0px 6px;
    background:white;
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075);
    width:206px;
    display:inline-block;
    border-radius:4px;
    color:#555;
}
ul,li{list-style:none}
#ts{
    width:250px;
    padding:10px;
    margin:10px 10px 10px 100px;
    border:1px solid #eee;
}
#ts li{
    height:23px;
    line-height:23px;
}
#ts span{
    margin-left:10px;
}
</style>
<script type="text/javascript">
    var ctime = '<?php echo $ctime = mktime(); ?>';

    $(document).ready(function(){
	$('#matchForm').submit(function(){
	    if($('#actFile').val() !='' && $('#clkFile').val() != ''){
		$('#submit').button('loading');
		getDescribe();
	    }else{
		alert('请选择匹配的文件！');
	    }
	})	    
    })

    function getDescribe(){
	$.ajax({
	    url:'<?php echo Yii::app()->createUrl('DeviceIdMatch/Describe') ?>',	
	    data:'fileName=' + ctime,
	    dataType:'json',
	    success:function(res){
		if(res.code == 200){
		    res.msg = eval('(' + res.msg + ')');
		    console.log(res.msg);
		    $('#ts_countc').html(res.msg.countC);
		    $('#ts_counta').html(res.msg.countA);
		    $('#ts_countua').html(res.msg.countUA);
		    $('#ts_matchc').html(res.msg.matchC);
		    $('#submit').button('reset');
		    $('#ts').show();
		}else{
		    setTimeout(function(){getDescribe()}, 1000);
		}
	    }
	})
    }
</script>

<iframe src="" style="display:none;" name="upload"></iframe>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'matchForm',
    'type'=>'horizontal',
    'action'=>array('deviceIdMatch/index'),
    'method'=>'post',
    'htmlOptions'=>array(
	'enctype'=>'multipart/form-data',
	'target'=>'upload',
    ),
)); ?>
<div class="control-group">
<?php echo Chtml::label('激活数据：', false, array('class'=>'control-label required')); ?>
<?php echo CHtml::fileField('actFile', '', array('class'=>'fileInput')); ?>
</div>
<div class="control-group">
<?php echo Chtml::label('点击数据：', false, array('class'=>'control-label required')); ?>
<?php echo CHtml::fileField('clkFile', '', array('class'=>'fileInput')); ?>
</div>

<ul id="ts" style="display:none">
    <li>点击总数：<span id="ts_countc"></span></li>
    <li>激活总数：<span id="ts_counta"></span></li>
    <li>去重激活数：<span id="ts_countua"></span></li>
    <li>核对成功数：<span id="ts_matchc"></span></li>
</ul>

<div class="form-actions">
    <?php echo CHtml::hiddenField('fileName', $ctime); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'核 对', 'loadingText'=>'loading...', 'htmlOptions'=>array('id'=>'submit'))); ?>
</div>
<?php $this->endWidget(); ?>

<ul class="well" style="margin-left:0px">
    <li><strong>使用提示：</strong></li>
    <li>1、激活和点击数据必须是csv格式，目前暂时不支持其他格式数据。</li>
    <li>2、目前支持的设备ID有mac、idfa、macmd5，暂时不支持openudid等格式。同时兼容：大小写、mac是否含有冒号、idfa是否含有横线。</li>
    <li>3、激活和点击数据字段顺序必须是：date,idfa,mac,macmd5,otherDatas，当mac,macmd5,idfa,date有不存在的时候，该单元格为空。</li>
    <li>4、该工具的去重原则是将所有设备ID链在一起去重，所以mac、macmd5、idfa中有一项不同都认为不是同一台设备。</li>
    <li>5、核对结果包含a2c.csv和na2c.csv，前者是核对成功的数据，后者是未核对到点击的激活数据。a2c.csv中包含激活和点击两个导入csv文件中的所有字段，可以根据需求删减。</li>
    <li>6、更多规范请参考wiki &nbsp; <a target="_blank" href="http://trac.staff.domob.cn/trac/domob/wiki/TS/cpa/a2c">go >></a>，如有疑问请联系 <a href="mailto:zhengfei@domob.cn">zhengfei@domob.cn</a></li>
</ul>
