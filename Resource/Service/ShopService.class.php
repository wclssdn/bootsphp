<?php

namespace Resource\Service;

use Resource\Model\ShopModel;
use BootsPHP\Service;

class ShopService extends Service{

	public function __construct() {
		$this->shopModel = new ShopModel();
	}

	/**
	 * 获取店铺信息
	 * @param number|array $shopId
	 * @return array|boolean
	 */
	public function getShopInfo($shopId) {
		$shopId = (array)$shopId;
		return $this->shopModel->getShopInfo($shopId);
	}

	/**
	 * 获取推信息
	 * @param unknown $twitterId
	 * @param boolean $moreInfo 更多信息
	 * @return Ambigous <unknown, multitype:, boolean, multitype:unknown >
	 */
	public function getTwitterInfo($twitterId, $moreInfo = false) {
		$result = $this->shopModel->getTwitterInfo($twitterId);
		if ($moreInfo) {
			$property = $this->shopModel->getTwitterProperty($twitterId);
			foreach ($result as $tid => $v){
				$result[$tid]['property'] = $property[$tid];
			}
		}
		return $result;
	}

	/**
	 * 获取基本审核待审推列表
	 */
	public function getBaseUnVerifyTwitterList($page, $limit) {
		return $this->shopModel->getTwitterListByStatus(ShopModel::GOODS_STATUS_PAUSE, ShopModel::GOODS_AUDIT_STATUS_BASE_UNVERIFY, $page, $limit);
	}

	/**
	 * 获取时尚审核待审推列表
	 */
	public function getFashionUnVerifyTwitterList($page, $limit) {
		return $this->shopModel->getTwitterListByStatus(array(
			ShopModel::GOODS_STATUS_NORMAL,
			ShopModel::GOODS_STATUS_PAUSE), ShopModel::GOODS_AUDIT_STATUS_FASHION_UNVERIFY, $page, $limit);
	}

	/**
	 * 基本审核提交审核
	 * @param unknown $twitterId
	 * @param unknown $verifyStat
	 * @param unknown $errorReason
	 * @return boolean
	 */
	public function verifyBaseTwitter($twitterId, $verifyStat, $errorReason) {
		$twitterInfo = $this->shopModel->getTwitterInfo($twitterId);
		if (!$twitterInfo){
			return false;
		}
		$twitterInfo = $twitterInfo[$twitterId];
		if ($twitterInfo['goods_audit_status'] != ShopModel::GOODS_AUDIT_STATUS_BASE_UNVERIFY){
			return false;
		}
		if (!is_numeric($verifyStat)){
			return false;
		}
		if (!$this->shopModel->verifyTwitter($twitterId, $verifyStat, $errorReason)){
			return false;
		}
		$date = date('Y-m-d H:i:s');
		return $this->shopModel->verifyLog($twitterId, $twitterInfo['goods_id'], $twitterInfo['shop_id'], $twitterInfo['user_id'], $verifyStat, $errorReason, $date);
	}

	/**
	 * 时尚审核提交审核
	 * @param unknown $twitterId
	 * @param unknown $verifyStat
	 * @param unknown $errorReason
	 * @return boolean
	 */
	public function verifyFashionTwitter($twitterId, $verifyStat, $errorReason) {
		$twitterInfo = $this->shopModel->getTwitterInfo($twitterId);
		if (!$twitterInfo[$twitterId]){
			return false;
		}
		$twitterInfo = $twitterInfo[$twitterId];
		if ($twitterInfo['goods_audit_status'] != ShopModel::GOODS_AUDIT_STATUS_FASHION_UNVERIFY){
			return false;
		}
		if (!is_numeric($verifyStat)){
			return false;
		}
		if (!$this->shopModel->verifyTwitter($twitterId, $verifyStat, $errorReason)){
			return false;
		}
		$date = date('Y-m-d H:i:s');
		return $this->shopModel->verifyLog($twitterId, $twitterInfo['goods_id'], $twitterInfo['shop_id'], $twitterInfo['user_id'], $verifyStat, $errorReason, $date);
	}
}