<?php
#########################################################################
# Author: Kayin Sun 
# Created Time: 2014-04-02 14:26:27
# File Name: CheckSignForm.php
# Description: 
#########################################################################

/**
 * 根据接口规范生成多盟Sign，与广告主回调时传递的Sign进行比对，返回校验结果
 *
 */
class CheckSignForm extends CFormModel {

	public $appId;			// APP标识 
	public $udid;			// 原始MAC地址，大写带冒号
	public $ma;				// 经过MD5加密的大写带冒号的MAC地址
	public $ifa;			// IDFA标识
	public $oid;			// OpenUDID标识
	public $sign;			// 广告主回调接口时传递的Sign
	public $acttime;		// 用户激活时间

	/**
	 * 设置规则，校验提交的数据中是否包含必须的参数
	 */
	public function rules() {
		return array(
				array('appId', 'required', 'message'=>'缺少appId参数！'),
				array('ifa', 'required', 'message'=>'缺少ifa参数！'),
				array('udid,ma', 'hasMacParam'), // 添加自定义验证方法hasMacParam()
				array('sign', 'required', 'message'=>'缺少sign参数！'),
				array('acttime', 'required', 'message'=>'缺少accttime参数！'),
			);
	}

	/**
	 * 判断Mac对应的参数udid或ma是否存在
	 */
	public function hasMacParam() {
		if(empty($this->udid) && empty($this->ma)) {
			$this->addError('udid,ma', '缺少udid或ma参数');
		} 
	}

	/**
	 * 校验sign并返回结果
	 * @return array 广告主Sign、多盟Sign、校验结果（true/false）
	 */
	public function check() {

		// 获取多盟Sign
		$signDomob = $this->_getDomobSign();

		// 与回调url中的sign进行比对，返回结果
		$result = $signDomob == $this->sign ? '200' : '300';
		return array('code'				=> $result,
					 'sign_callback'	=> $this->sign,
					 'sign_domob'		=> $signDomob);
	}

	/**
	 * 计算给广告主分配的key
	 * @return string 
	 */
	private function _getDomobKey() {
		return md5('lk2s#a1d@j8if' . $this->appId);
	}

	/**
	 * 生成domob激活回调的签名。
	 * @return string 经过MD5处理的多盟Sign
	 */
	private function _getDomobSign() {
		
		// 获取key
		$key = $this->_getDomobKey();

		// 生成、返回多盟Sign
		$sign = sprintf("%s,%s,%s,%s,%s,%s", 
			$this->appId, $this->udid, $this->ma, $this->ifa, $this->oid, $key);
		return md5($sign);
	}
}	

# vim: set noexpandtab ts=4 sts=4 sw=4 :
