<?php
/**
  * 生命一个类，用于获取数据库中的记录，返回给控制器生成工单列表
  */
class GetlistForm extends CFormModel
{
	public function findList($status)
	{
		$model = array();
		$criteria = new CDbCriteria();
		$criteria->order = 'status DESC,pri_level';
		$criteria->condition = "status = 0 or status = 1";
		$count = OfferList::model()->count($criteria);
		if(!$count):
		    $model['page'] = null;
		    $model['list'] = null;
		    $model['preid'] = null;
		    return $model;
		endif;
		$pager = new CPagination($count);
		$pager->pageSize = 20;
		$pager->applyLimit($criteria);
		$model['list'] = OfferList::model()->findAll($criteria);
		$model['page'] = $pager;
		$model['preid'] = $this->getPriid($model['list'][0]);
		return $model;
	}

	/**
	  * 此方法用于获取满足条件的的offer的前一个的id，主要用于前一页的在第二页第一个工单的前一个工单的id信息
	  */
	public function getPriId($premodel)
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'pri_level DESC';
		$criteria->condition = "status = 0 and pri_level<".$premodel->pri_level;
		$pre = OfferList::model()->findAll($criteria);
		if(empty($pre)){
		    $preid = 0;   
		 }else{
		    $preid = $pre[0]->id;    
		 }
		 return $preid;
	}
}
