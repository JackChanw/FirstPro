<?php
/* @var $this UserController */
/* @var $model UserInfoRecord */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/css/main.css");
$this->breadcrumbs=array(
    '工单'=>array('Offercpa/index'),
    '新建工单',
);
?>

<legend><h1>新建工单</h1></legend>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
