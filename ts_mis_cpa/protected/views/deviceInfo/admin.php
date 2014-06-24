<?php
$this->breadcrumbs=array(
	'Device Infos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DeviceInfo', 'url'=>array('index')),
	array('label'=>'Create DeviceInfo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('device-info-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Device Infos</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'device-info-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'machine_name',
		'DMAC_UPPER',
		'DMAC_LOWER',
		'DMAC_PURE_NUM',
		'DMAC_PURE_NUM_LOWER',
		/*
		'MD5_MAC',
		'OPEN_UDID',
		'OPEN_UDID_LOWER',
		'IDFA',
		'NOCOLONIDFA',
		'IDFA_LOWER',
		'NOCOLONIDFA_LOWER',
		'MAC_OR_IDFA',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
