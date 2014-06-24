<?php
$tabs = array(
	array(
		'label' => '未对接工单列表', 
		'url' => array('offercpa/list'),
		'active'=>($model->offerStatus==0)
	),
	array(
		'label' => '正在对接列表', 
		'url' => array('offercpa/list&offerStatus=1'),
		'active'=>($model->offerStatus=='1')
	),
	array(
		'label' => '完成对接列表', 
		'url' => array('offercpa/list&offerStatus=2'),
		'active'=>($model->offerStatus=='2')
	),
);
?>
<div style="float:right">
	<a class="btn btn-primary" href="<?php echo Yii::app()->createUrl("Offercpa/index");?>"><i class="icon-plus"></i>新建工单</a>
</div>
<?php
// 渲染tab
$this->widget('bootstrap.widgets.TbMenu', array(
	'type' => 'tabs',
	'stacked' => false,
	'items' => $tabs, 
));
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$dataProvider,
    'enableSorting'=>false,
    'type'=>'striped bordered condensed',
    'template'=>"{items}{pager}",
    'htmlOptions'=>array('style'=>'text-align:center'),
    'emptyText'=>'无',
    'columns'=>array(
	array(
	    'name' => 'id',
	    'headerHtmlOptions'=>array('style'=>'text-align:center;width:50px'),
	    'htmlOptions'=>array('style'=>'text-align:center'),
	),
	array(
	    'header' => '工单标题',
	    'name' => 'offer_title',
	    'value' => 'mb_substr($data->offer_title, 0, 25, "utf-8").".."',
	    'headerHtmlOptions'=>array('style'=>'text-align:center;width:120px'),
	    'htmlOptions'=>array('style'=>'text-align:center'),
	),
	array(
	    'header' => '负责销售',
	    'name' => 'sale',
	    'value' => '$data->offerDetail->psInfoSale->name',
	    'headerHtmlOptions'=>array('style'=>'text-align:center;width:20px'),
	    'htmlOptions'=>array('style'=>'text-align:center'),
	),
	array(
	    'header' => '负责AM',
	    'name' => 'ae',
	    'value' => '$data->offerDetail->psInfoAe->name',
	    'headerHtmlOptions'=>array('style'=>'text-align:center;width:20px'),
	    'htmlOptions'=>array('style'=>'text-align:center'),
	),
	array(
	    'header' => '提交时间',
	    'name' => 'commit_dt',
	    'value' => 'date("Y-m-d",$data->commit_dt)',
	    'headerHtmlOptions'=>array('style'=>'text-align:center;width:40px'),
	    'htmlOptions'=>array('style'=>'text-align:center'),
	),
	array(
	    'header' => '上线时间',
	    'name' => 'online_dt',
	    'value' => 'date("Y-m-d",$data->online_dt)',
	    'headerHtmlOptions'=>array('style'=>'text-align:center;width:40px'),
	    'htmlOptions'=>array('style'=>'text-align:center'),
	),
	array(
	    'header' => $optionUp != 'false' ? '领取对接' : ($optionDone == 'false' ? '对接负责人' : '领取时间'),
	    'name' => 'claim_dt',
		'type' => 'raw',
		'value' => $optionUp == 'true'? '"<a class=\"btn btn-success copy_a btn-mini\" href=\'index.php?r=Offercpa/claim/id/$data->id\' data-clipboard-text=\"\">"."领取对接"."</a>"' : '!$data->done_dt ? date("Y-m-d", $data->done_dt) : $data->claim_name',
	    'headerHtmlOptions'=>array('style'=>'text-align:center;width:40px'),
	    'htmlOptions'=>array('style'=>'text-align:center'),
	),
	array(
		'header' => $optionHeader,
		'name' => '提升',
		'type' => 'raw',
		'value' => $optionUp == 'true'? '"<a class=\"btn copy_a btn-info btn-mini\" href=\"'.Yii::app()->createUrl("Offercpa/raise/id/").'/$data->id\">"."提升"."</a>"' : '$data->done_dt ? date("Y-m-d", $data->done_dt) : $data->claim_name',
	    'headerHtmlOptions'=>array('style'=>'text-align:center;width:40px'),
	    'htmlOptions'=>array('style'=>'text-align:center'),
		),
	array(
		'header'=>'操作',
	    'class'=>'bootstrap.widgets.TbButtonColumn',
	    'headerHtmlOptions'=>array('style'=>'width: 50px; text-align:center'),
		'template'=>'{view} {update} {edit} {done}',
		'deleteConfirmation'=>'js:"你确定删除这条记录么？"',
		'buttons'=>array(
			'view'=>array(
				'visible'=>'true',
				),
			'update'=>array(
				'visible'=>$optionUp,
				),
			'edit'=>array(
				'url' => 'Yii::app()->createUrl("Offercpa/delete/id/$data->id")',
				'label'=>'',
				'visible'=>$optionDel,
				'options' =>  array("class"=>"icon- icon-trash"),
				),
			'done'=>array(
				'url' => 'Yii::app()->createUrl("Offercpa/done/id/$data->id")',
				'label'=>'',
				'visible'=>$optionDone,
				'options' =>  array("class"=>"icon- icon-trash"),
				),
			),
	),  			
    )
)); ?>
