<?php
class SetActForm extends CFormModel
{
	public function saveClaim($id)
	{
		$model = OfferList::model()->findByPK($id);
		$model->status = 1;
		$model->claim_name= Yii::app()->user->name;
		$model->claim_dt = time();
		$re = $model->save();
		if(!$re):
		    Util::log('OfferCpa',Yii::app()->user->name.'认领工单失败了,标题为:'.$model->offer_title, 'error');
		    return False;
		endif;
		Util::log('OfferCpa', Yii::app()->user->name.'认领工单成功了,标题为:'.$model->offer_title, 'info');
		return $re;
	}
	public function setDone($id)
	{
		$model = OfferList::model()->findByPK($id);
		$model->done_dt = time();
		$model->status = 2;
		$re = $model->save();
		if(!$re):
		    Util::log('OfferCpa',Yii::app()->user->name.'设置完成工单失败了,标题为:'.$model->offer_title, 'error');
		    return False;
		endif;
		Util::log('OfferCpa', Yii::app()->user->name.'设置完成工单成功了,标题为:'.$model->offer_title,'info');
		return $re;
	}
	public function setRoll($id)
	{
		$model = OfferList::model()->findByPK($id);
		$model->status = 0;
		$model->claim_dt = 0;
		$re = $model->save();
		return $re;
	}
	public function setRaise($id)
	{
		$preid = $this->getPreId($id);
		if(!$preid)
			return False;
		$model = OfferList::model()->findAllByPK(array($id,$preid));
		$offer_1 = $model[0]->pri_level;
		$offer_2 = $model[1]->pri_level;
		$model[0]->pri_level = $offer_2;
		$model[1]->pri_level = $offer_1;
		$re1 = $model[1]->save();
		if(!$re1):
			Util::log('OfferCpa', Yii::app()->user->name.'提升工单失败了,标题为:'.$model[0]->offer_title, 'error', '保存当前列失败');
		    return False;
		endif;
		$re2 = $model[0]->save();
		if(!$re2):
		    $model[1]->pri_level = $offer_1;
		    $model[1]->save();
			Util::log('OfferCpa', Yii::app()->user->name.'提升工单失败了,标题为:'.$model[0]->offer_title, 'error', '保存前一列失败');
		    return False;
		endif;
		Util::log('OfferCpa', Yii::app()->user->name.'提升了工单,标题为:'.$model[0]->offer_title.',前面的id为:'.$preid, 'info');
		return True;
	}
	public function setFail($id){
		$model = new OfferList();
		$re = $model->findByPk($id);
		$re->status = 4;
		if($re->save()){
		    return true;
		}else{
		    return false;                                                                                                                                                                                         
		}
	}

	private function getPreId($id)
	{
		$model = OfferList::model()->findByPK($id);
		$priLevel = $model->pri_level;
		$criteria=new CDbCriteria;
		$criteria->select = 'id';  // only select the 'title' column
		$criteria->condition = 'status = 0 and pri_level > :priLevel';
		$criteria->order = 'pri_level ASC';
		$criteria->params = array(':priLevel'=>$priLevel);
		$priModel = OfferList::model()->find($criteria); // $params is not needed
		if($priModel)
			return $priModel->id;
		return False;
	}
}
