<?php
$this->breadcrumbs=array(
    '工单'=>array('offercpa/list'),
    '工单列表',
);
?>

<legend><h1>工单列表</h1></legend>

<?php
	$this->renderPartial('_search', array('model'=>$model));
	$this->renderPartial('_gridViewList', array('dataProvider'=>$dataProvider, 'model'=>$model, 'optionUp'=>$optionUp, 'optionDel'=>$optionDel, 'optionDone'=>$optionDone, 'optionHeader'=>$optionHeader));
