<?php
/* @var $this UserController */
/* @var $model UserInfoRecord */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'user-info-record-form',
    'type'=>'horizontal',
    //'enableAjaxValidation'=>false,
)); ?>
<fieldset>

	<?php echo $form->textFieldRow($model, 'offer_title', array()); ?>

	<?php echo $form->textFieldRow($model, 'app_name', array()); ?>

	<?php echo $form->textFieldRow($model, 'company_name', array()); ?>

	<div class="control-group ">
		<label class="control-label">上线时间</label>
		<div class="controls">
				<?php 
                    $this->widget('application.extensions.timepicker.timepicker', array(
                        'model'=>$model,
                        'name'=>'online_dt',
                        'options' => array(
                            'value'=>date('Y-m-d',strtotime('+3 day')),
                            'showOn'=>'focus',
                            'dateFormat'=>'yy-mm-dd',
							'timeFormat'=>'',
                            'showTime'=>false,
                            'showHour'=>false,
                            'showMinute'=>false,
							'showSecond'=>false,
							'tabularLevel'=>null,
                        ),  
                    )); 
                ?>  
		</div>
	</div>

	<?php echo $form->dropDownListRow($model, 'sale', $model->getAllSales()); ?>

	<?php echo $form->dropDownListRow($model, 'ae', $model->getAllAes()); ?>

	<label class="control-label">应用类型<span class="required"> *</span></label>
	<div class='control-group'>
	<?php echo $form->radioButtonList($model, 'app_type', array(1=>'游戏',2=>'应用'), array('separator'=>'&nbsp', 'labelOptions'=>array('class'=>'labelForRadio'))); ?>
	</div>

	<label class="control-label">对接方式<span class="required"> *</span></label>
	<div class='control-group'>
	<?php echo $form->radioButtonList($model, 'api_type', array(1=>'API',2=>'SDK'), array('separator'=>'&nbsp', 'labelOptions'=>array('class'=>'labelForRadio'))); ?>
	</div>

	<label class="control-label">设备类型<span class="required"> *</span></label>
	<div class='control-group'>
	<?php echo $form->checkBoxList($model, 'send_type', array(1=>'iPhone',2=>'iPad'), array('separator'=>'&nbsp', 'labelOptions'=>array('class'=>'labelForCheckBox'))); ?>
	</div>

	<label class="control-label">投放平台<span class="required"> *</span></label>
	<div class='control-group'>
	<?php echo $form->checkBoxList($model, 'platform', array(1=>'积分墙',2=>'广告平台', 4=>'视频广告'), array('separator'=>'&nbsp', 'labelOptions'=>array('class'=>'labelForCheckBox'))); ?>
	</div>

	<label class="control-label">激活定义<span class="required"> *</span></label>
	<div class='control-group'>
	<?php echo $form->radioButtonList($model, 'active_mode', array(1=>'联网打开',2=>'进入游戏', 3=>'注册成功', 4=>'创建角色'), array('separator'=>'&nbsp', 'labelOptions'=>array('class'=>'labelForRadio'))); ?>
	</div>

	<label class="control-label">投放系统<span class="required"> *</span></label>
	<div class='control-group'>
	<?php echo $form->radioButtonList($model, 'system_version', array(1=>'全系统',2=>'Mac系统(IOS7以下)', 3=>'IDFA系统(IOS7及以上)'), array('separator'=>'&nbsp', 'labelOptions'=>array('class'=>'labelForRadio'))); ?>
	</div>

	<label class="control-label">回调周期<span class="required"> *</span></label>
	<div class='control-group'>
	<?php echo $form->radioButtonList($model, 'callback_period', array(1=>'实时回调',2=>'五分钟', 3=>'十五分钟', 4=>'一个小时', 5=>'隔天回调'), array('separator'=>'&nbsp', 'labelOptions'=>array('class'=>'labelForRadio'))); ?>
	</div>

	<?php echo $form->textFieldRow($model, 'itunesurl', array('class'=>'span6')); ?>

	<?php echo $form->textFieldRow($model, 'clk_link', array('class'=>'span6')); ?>

	<?php echo $form->textAreaRow($model, 'note', array('class'=>'span6', 'rows'=>3)); ?>

</fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>$model->isNewRecord ? '添加' : '修改')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'重置')); ?>
</div>
<?php $this->endWidget(); ?>

