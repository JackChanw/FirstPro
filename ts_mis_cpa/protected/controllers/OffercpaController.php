<?php
/**
 * 声明一个控制器，用于存放所有的工单的方法
 * 这个类继承Controller
 */
class OfferCpaController extends DController
{
	public function accessRules() 
	{   
	    return array(
			array(
				'allow',
				'actions'=>array('index', 'view', 'list', 'update', 'raise', 'claim', 'delete', 'done'),
				'users'=>array('@'),
				),
			array(
				'deny',
				'users'=>array('*'),
				),
            );  
        }   
	/** 
	 * 声明一个默认动作方法
	 * 用于渲染一个视图、表单的验证等
	 * 这个方法会把整个form类传递到视图，用于一些表单的验证
	 */
	public function actionIndex()
	{
		$model = new OfferCpaForm();
		if(Yii::app()->request->isPostRequest) {
		    $model->attributes = $_POST['OfferCpaForm'];
		    if($model->validate() && $model->saveOffer()) {
				Util::inform('提交成功了哟!$_$', 'info');
				$this->redirect(array('Offercpa/list'));
		    }
		}
		$this->render('index',array(
		    'model'=>$model,
		    ));
	}
	

	/**
	 * 声明一个动作方法
	 * 生成一个列表用于展示状态为未处理和处理中的工单简要信息
	 */
	public function actionList(){
		$model = new OfferListForm();
		$offerStatus = !empty($_GET['offerStatus']) ? $_GET['offerStatus'] : 0;
		if(!in_array($offerStatus, array(0,1,2))){
			$this->redirect(array('list'));
		}
		if($offerStatus == 0){
			$optionUp = 'true';
			$optionDel = 'true';
			$optionDone = 'false';
			$optionHeader = '提升操作';
		}
		if($offerStatus == 1){
			$optionUp = 'false';
			$optionDel = 'false';
			$optionDone = 'true';
			$optionHeader = '对接负责人';
		}
		if($offerStatus == 2){
			$optionUp = 'false';
			$optionDel = 'false';
			$optionDone = 'false';
			$optionHeader = '完成时间';
		}
		$model->attributes = $_GET;
        $dataProvider = $model->getDataProvider();
        $this->render('list',array('dataProvider'=>$dataProvider, 'model'=>$model, 'optionUp'=>$optionUp, 'optionDel'=>$optionDel, 'optionDone'=>$optionDone, 'optionHeader'=>$optionHeader));
	}
	

	/**
	 * 声明一个动作方法
	 * 展示工单内容
	 */
	public function actionView()
	{
		$id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : 0;
		$model = OfferList::model()->findByPk($id);
		if(!$model){
			$this->redirect(array('Offercpa/list'));
			return;
		}   
		$this->render('view', array(
			'model' => $model
		));
	}

	/** 
	 * 声明一个动作方法
	 * 用于更新数据时的表单验证以及数据保存操作
	 */
	public function actionUpdate($id){

		if(Yii::app()->user->name != OfferList::model()->findByPk($id)->offerDetail->psInfoSale->name && !in_array('TS', Yii::app()->user->groupName)){
			Util::inform('您没有权限这么做,老实呆着吧亲$_$', 'error');
			$this->redirect(array('Offercpa/list'));
		}

		$model = new OfferCpaForm();
		$model->getMyAttributes($id);
		if(Yii::app()->request->isPostRequest) {
		    $model->attributes = $_POST['OfferCpaForm'];
		    if($model->validate() && $model->updateOffer($id)) {
				Util::inform('更新成功了哟!$_$', 'info');
				$this->redirect(array('Offercpa/list'));
		    }
		}
		$this->render('update',array('model'=>$model));
		

	}


	/**
	 * 声明一个动作方法
	 * 接收两个传递过来的id，并互换两条记录的优先级
	 */
	public function actionRaise($id){
		$model = new SetActForm();
		$res = $model->setRaise($id);
		if($res){
			Util::inform('操作成功了哟!$_$', 'info');
			$this->redirect(array('Offercpa/list'));
		}else{
			Util::inform('我去,操作失败了耶!送你一个字,该!', 'error');
			$this->redirect(array('Offercpa/list'));
		}
	}

	/**
	 * 声明一个动作方法
	 * 用于认领工单记录
	 */
	public function actionClaim($id){
		if(!in_array('TS', Yii::app()->user->groupName)){
			Util::inform('您没有权限这么做,老实呆着吧亲$_$', 'error');
			$this->redirect(array('Offercpa/list'));
		}
		$model = new SetActForm();
		$this->redirect(array('CpaInfo/Index','id'=>$id));
	}
	
	/**
	 * 声明一个动作方法
	 * 用于完成对接工单是设置
	 */
	public function actionDone($id){
		if(!in_array('TS', Yii::app()->user->groupName)){
			Util::inform('您没有权限这么做,老实呆着吧亲$_$', 'error');
			$this->redirect(array('Offercpa/list'));
		}
		$model = new SetActForm();
		$res = $model->setDone($id);
		if($res){
			Util::inform('操作成功啦!君甚屌,家翁乃知?', 'info');
			$this->redirect(array('Offercpa/list'));
		}else{
			Util::inform('我去,操作失败了耶!送你一个字,该!', 'error');
			$this->redirect(array('Offercpa/list'));
		}
	}
	/**
	 * 声明一个动作方法
	 * 用于将工单设置为失效
	 */
	public function actionDelete($id)
	{

		if(Yii::app()->user->name != OfferList::model()->findByPk($id)->offerDetail->psInfoSale->name && !in_array('TS', Yii::app()->user->groupName)){
			Util::inform('您没有权限这么做,老实呆着吧亲$_$', 'error');
			$this->redirect(array('Offercpa/list'));
		}
		
		$status = isset($_REQUEST['status'])?$_REQUEST['status']:10000;
		$model = new SetActForm();
		if($model->setFail($id)){
			Util::inform('操作成功啦!君甚屌,家翁乃知?', 'info');
			$this->redirect(array('Offercpa/list'));
		}else{
			Util::inform('我去,操作失败了耶!送你一个字,该!', 'error');
			$this->redirect(array('Offercpa/list'));
		}
		
	}
	
}
