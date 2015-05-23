<?php

namespace Web\Service\Controller;

use \Web\Service\Base\Controller;
use \Resource\Service\TaobaoService;

/**
 * 好店相关接口
 * @author wangchenglong
 *
 */
class TaobaoController extends Controller{

	/**
	 * @var ShopService
	 */
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new TaobaoService();
	}

	/**
	 * 宝贝信息
	 */
	public function itemAction() {
		//获取店铺信息
		if ($this->request->isGet()){
			$itemId = $this->request->getParam('item_id');
			if (empty($itemId)){
				$this->error(self::CODE_ERROR_PARAM, 'item_id is empty');
			}
			$itemInfo = $this->service->getItemInfo($itemId);
			if ($itemInfo === false){
				$this->error(self::CODE_ERROR_NO_DATA);
			}
			$this->success($itemInfo);
		}
		$this->error(self::CODE_ERROR_METHOD_NOT_SUPPORT);
	}
}