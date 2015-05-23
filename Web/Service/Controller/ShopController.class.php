<?php

namespace Web\Service\Controller;

use \Web\Service\Base\Controller;
use \Resource\Service\ShopService;

/**
 * 好店相关接口
 * @author wangchenglong
 *
 */
class ShopController extends Controller{

	/**
	 * @var ShopService
	 */
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new ShopService();
	}

	/**
	 * 店铺
	 */
	public function indexAction() {
		//获取店铺信息
		if ($this->request->isGet()){
			$shopId = $this->request->getParam('shop_id');
			$shopId = array_filter((array)$shopId);
			if (empty($shopId)){
				$this->error(self::CODE_ERROR_PARAM, 'shop_id is empty');
			}
			$shopInfo = $this->service->getShopInfo($shopId);
			if ($shopInfo === false){
				$this->error(self::CODE_ERROR_NO_DATA);
			}
			$this->success($shopInfo);
		}
		$this->error(self::CODE_ERROR_METHOD_NOT_SUPPORT);
	}

	/**
	 * 推
	 */
	public function twitterAction() {
		//获取推信息
		if ($this->request->isGet()){
			$twitterId = $this->request->getParam('twitter_id', 'number');
			$moreinfo = $this->request->getParam('moreinfo', 'boolean');
			//获取指定推的信息
			if ($twitterId){
				$twitterInfo = $this->service->getTwitterInfo($twitterId, $moreinfo);
				$twitterInfo = is_array($twitterId) ? $twitterInfo : $twitterInfo[$twitterId];
				if (!$twitterInfo){
					$this->error(self::CODE_ERROR_NO_DATA);
				}
				$this->success($twitterInfo);
			}
			$type = $this->request->getParam('type');
			$page = $this->request->getParam('page', 'number', 1);
			$limit = $this->request->getParam('limit', 'number', 100);
			//获取指定类型的推列表
			if ($type){
				if (!in_array($type, array('base','fashion'))){
					$this->error(self::CODE_ERROR_PARAM, 'wrong type');
				}
				switch ($type){
					case 'base':
						$list = $this->service->getBaseUnVerifyTwitterList($page, $limit);
						if (!$list){
							$this->error(self::CODE_ERROR_NO_DATA);
						}
						$this->success($list);
						break;
					case 'fashion':
						$list = $this->service->getFashionUnVerifyTwitterList($page, $limit);
						if (!$list){
							$this->error(self::CODE_ERROR_NO_DATA);
						}
						$this->success($list);
						break;
				}
			}
			$this->error(self::CODE_ERROR_PARAM);
		}
		//更新推
		if ($this->request->isPut()){
			$type = $this->request->getParam('type');
			$twitterId = $this->request->getParam('twitter_id');
			$verifyStat = $this->request->getParam('verify_stat');
			$errorReason = $this->request->getParam('error_reason');
			if (!in_array($type, array('base','fashion'))){
				$this->error(self::CODE_ERROR_PARAM, 'wrong type');
			}
			if (!$twitterId){
				$this->error(self::CODE_ERROR_PARAM, 'twitter_id is empty');
			}
			if (!is_numeric($verifyStat)){
				$this->error(self::CODE_ERROR_PARAM, 'wrong verify_stat');
			}
			switch ($type){
				case 'base':
					if ($this->service->verifyBaseTwitter($twitterId, $verifyStat, $errorReason)){
						$this->success();
					}
					break;
				case 'fashion':
					if ($this->service->verifyFashionTwitter($twitterId, $verifyStat, $errorReason)){
						$this->success();
					}
					break;
			}
			$this->error(self::CODE_ERROR_SYSTEM);
		}
		$this->error(self::CODE_ERROR_METHOD_NOT_SUPPORT);
	}

	/**
	 * 判断推是否为好店的推
	 */
	public function isShopTwitterAction() {
		if ($this->request->isGet()){
			$twitterId = $this->request->getParam('twitter_id');
			if (!$twitterId){
				$this->error(self::CODE_ERROR_PARAM, 'twitter_id is empty');
			}
			$twitterInfo = $this->service->getTwitterInfo($twitterId);
			if (!$twitterInfo){
				$this->success();
			}
			$result = array_combine(array_keys($twitterInfo), array_fill(0, count($twitterInfo), true));
			$this->success($result);
		}
		$this->error(self::CODE_ERROR_METHOD_NOT_SUPPORT);
	}
}
