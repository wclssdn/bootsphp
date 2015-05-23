<?php

namespace BootsPHP;

class Controller {

	/**
	 * 请求对象
	 * @var \BootsPHP\Request
	 */
	protected $request;

	/**
	 * 响应对象
	 * @var \BootsPHP\Response
	 */
	protected $response;

	public function __construct(){
		$this->request = Request::getInstance();
		$this->response = Response::getInstance();
	}

	/**
	 * 转向另一个action, 这个action收到的信息会跟直接请求它是一致的
	 * @param string $action action的名字, 不包括结尾的Action后缀
	 */
	public function execAction($action){
		$this->request->setAction($action);
		$action = "{$action}Action";
		$this->$action();
	}

	public function __destruct(){
		$this->response && $this->response->response();
	}
}