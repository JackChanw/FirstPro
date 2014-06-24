<?php
/*
 * 声明一个对象,提供数据并支持相应的检索功能
 * */
class OfferListForm extends DFormModel
{
	public $search = '';
	public $offerStatus = 0;

	public function rules()
	{
		return array(
				array('search, offerStatus','safe'),
			);
	}
	public function getCondition()
	{
		$preCondition = array('status = ' . mysql_escape_string(trim($this->offerStatus)));
		
		if($this->search)
			$preCondition[] = 'offer_title like "%' . mysql_escape_string(trim($this->search)) . '%"';

		return $condition = join(' and ', $preCondition);

	}

	public function getDataProvider()
	{
        $criteriaOptions = array(
            'order' => 'pri_level DESC',
        );
		$pageOption = array(
			'pageSize'=>'20',
			);
		$criteriaOptions['condition'] = $this->getCondition();
        $dataProvider = new CActiveDataProvider('OfferList', array(
            'criteria' => $criteriaOptions,
			'pagination'=>$pageOption,
			)
		);
		return $dataProvider;
	}
}
?>
