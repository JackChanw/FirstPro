<?php
$this->pageTitle=Yii::app()->name . ' - 数据核对'; 
$this->breadcrumbs=array(
    'CPA'=>array('#'),
    '自助工具'=>array('#'),
    'landing监测url生成',
);
?>

<legend><h1>landing监测url生成</h1></legend>
<br>


<style type="text/css">
ul,li{list-style:none}
.urls{
	border-left:30px;
}
</style>
<script type="text/javascript">
</script>

<iframe src="" style="display:none;" name="upload"></iframe>


<div class="form">
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table>
		<tr>
			<td class="urls">第三方检测url</td>
			<td><?php echo $form->textField($model, 'urlOne', array('size'=>50, 'maxlength'=>60, 'class'=>'urlOne'))?></td>
			<?php echo $form->error($model,'urlOne'); ?>
		</tr>
		<tr>
			<td class="urls">landing url</td>
			<td><?php echo $form->textField($model, 'urlTwo', array('size'=>50, 'maxlength'=>60, 'class'=>'urlTwo'))?></td>
			<?php echo $form->error($model,'urlTwo'); ?>
		</tr>
		<td colspan="2" align="center">
			<button class="btn btn-primary" type="submit" name="yt0">添加</button>
		</td>
	</table>
	<div class="row" style="display:none">
		<?php echo $form->labelEx($model,'tracker'); ?>
		<?php echo $form->textField($model,'tracker'); ?>
		<?php echo $form->error($model,'tracker'); ?>
	</div>
	<span>sssssssssssssss</span>
 
<?php $this->endWidget(); ?>
</div>


<div>
<ul class="well" style="margin-left:0px">
    <li><strong>使用提示：</strong></li>
    <li>1、激活和点击数据必须是csv格式，目前暂时不支持其他格式数据。</li>
</ul>
</div>
