<?php

namespace Resource\Base;

class ServiceController extends \BootsPHP\Controller{

	const CODE_SUCCESS = 0;

	const CODE_ERROR_PARAM = 1;

	const CODE_ERROR_NO_DATA = 2;

	const CODE_ERROR_BAD_REQUEST = 404;

	const CODE_ERROR_METHOD_NOT_SUPPORT = 405;

	const CODE_ERROR_SYSTEM = 500;

	protected function success(array $data = array(), $message = '', $code = self::CODE_SUCCESS) {
		$this->outputJson($code, $message, $data);
		$this->response->response();
	}

	protected function error($code = self::CODE_ERROR_PARAM, $message = '', array $data = array()) {
		$this->outputJson($code, $message, $data);
		$this->response->response();
	}

	protected function outputJson($code = self::CODE_SUCCESS, $message = '', array $data = array()) {
		$json = json_encode(array('code' => $code,'message' => $message,'data' => $data));
		echo $json;
		$this->response->response();
	}
}