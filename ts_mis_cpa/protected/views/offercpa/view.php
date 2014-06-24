<?php
/* @var $this UserNewsControllerController */
/* @var $model UserNewsRecord */

$this->breadcrumbs=array(
    '工单列表'=>array('Offercpa/list'),
    '工单详情',
);

$apiType = array(
		'1'=>'API',
		'2'=>'SDK',
	);
$appType = array(
		'1'=>'游戏',
		'2'=>'应用',
	);
$platform = array(
		'0'=>'未指定平台',
		'1'=>'积分墙',
		'2'=>'广告平台',
		'4'=>'视频广告',
		'3'=>'积分墙&&广告平台',
		'5'=>'积分墙&&视频广告',
		'6'=>'广告平台&&视频广告',
		'7'=>'积分墙&&广告平台&&视频广告',
	);
$sendType = array(
		'0'=>'未指定设备类型',
		'1'=>'iPhone',
		'2'=>'iPad',
		'3'=>'iPhone&&iPad',
	);
$sysVer = array(
		'1'=>'不限制',
		'2'=>'Mac系统(IOS7以下)',
		'3'=>'IDFA系统(IOS7及以上)',
		'30002'=>'IOS2',
		'30003'=>'IOS3',
		'30004'=>'IOS4',
		'30005'=>'IOS5',
		'30006'=>'IOS6',
		'30007'=>'IOS7',
	);
$activMode = array(
		'1'=>'联网打开',
		'2'=>'进入游戏',
		'3'=>'注册成功',
		'4'=>'创建角色',
		'5'=>'其他',
	);
$callbackPeriod = array(
		'0'=>'未指定回调周期',
		'1'=>'实时回调',
		'2'=>'五分钟',
		'3'=>'十五分钟',
		'4'=>'一小时',
		'5'=>'隔天回调',
		'404'=>'其他',
	);
function getSysVer($sysVer, $version){
	$preVer = explode('-', $version);
	$verArr = array();
		foreach ($preVer as $key) {
			$verArr[] = $sysVer[$key];
		}
	return join(' & ',$verArr);
}
?>

<legend><h1>工单详情</h1></legend>
<br/>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
		'data'=>$model,
		'type'=>'striped bordered condensed',
		'attributes'=>array(
			'id',
			array(
				'label' => '工单名称',
				'value' => $model->offer_title,
			),
			array(
				'label' => '负责销售',
				'value' => $model->offerDetail->psInfoSale->name,
			),
			array(
				'label' => '负责AM||AE',
				'value' => $model->offerDetail->psInfoAe->name,
			),
			array(
				'label' => '对接方式',
				'value' => $apiType[$model->offerDetail->api_type],
			),
			array(
				'label' => '应用类别',
				'value' => $appType[$model->offerDetail->app_type],
			),
			array(
				'label' => '投放平台',
				'value' => $platform[$model->offerDetail->platform],
			),
			array(
				'label' => '设备类型',
				'value' => $sendType[$model->offerDetail->send_type],
			),
			array(
				'label' => '可投系统版本',
				'value' => getSysVer($sysVer, $model->offerDetail->system_version),
			),
			array(
				'label' => '激活定义',
				'value' => $activMode[$model->offerDetail->active_mode].':'.$model->offerDetail->active_mode_other,
			),
			array(
				'label' => '回调周期',
				'value' => $callbackPeriod[$model->offerDetail->callback_period],
			),
			array(
				'label' => '应用名称',
				'value' => $model->offerDetail->app_name,
			),
			array(
				'label' => '公司名称',
				'value' => $model->offerDetail->company_name,
			),
			array(
				'label' => 'iTunes地址',
				'value' => $model->offerDetail->itunesurl,
			),
			array(
				'label' => '点击接口地址',
				'value' => $model->offerDetail->clk_link,
			),
			array(
				'label' => '备注信息',
				'value' => empty($model->offerDetail->note)? '无':$model->offerDetail->note,
			),
			array(
				'name' => '上线时间',
				'value' => date("Y/m/d H:i", $model->online_dt),
			),
			array(
				'name' => '记录时间',
				'value' => date("Y/m/d H:i", $model->commit_dt),
			),
			),
		)
	); 
?>
