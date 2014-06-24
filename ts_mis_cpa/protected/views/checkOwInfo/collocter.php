<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/css/owinfo.css");
$this->breadcrumbs=array(
    '自助工具' => array(''),
    '设备信息查询工具',
);
?>

<legend><h2>设备信息查询工具</h2></legend>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'user-info-record-form',
    'type'=>'horizontal',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    //'enableAjaxValidation'=>false,
)); ?>
<fieldset>
	<label class="control-label">信息文件<span class="required"> *</span></label>
	<div class='control-group'>
		<?php echo $form->fileFieldRow($model, 'owinfo', array('class'=>'filePos')); ?>
	</div>
</fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'提交')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'重置')); ?>
</div>
<?php $this->endWidget(); ?>
<p class="remind-note">操作要求:<p>
<p class="remind-danger">提交文件必须为CSV格式,否则无法提交查询<p>
<p class="remind-danger">文件名必须为英文,注意不要使用中文<p>
<p class="remind-danger">文件中的每行格式必须为Mac地址,IDFA,媒体ID(媒体列表中的mid),广告的内部appid,查询起始时间(eg:20140523),查询结束时间(eg:20140523)<p>
<p class="remind-danger">每行信息必须严格按照要求填写,否则会造成无法查询或查询没有结果的可能<p>
<p class="remind-danger">查询天数跨度尽量不要超过三天<p>
<p class="remind-danger">如有任何问题请联系<a href="mailto:chenwei1@domob.cn">chenwei1@domob.cn</a><p>
