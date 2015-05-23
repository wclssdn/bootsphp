<?php

namespace Web\Parttime\Controller;

use Web\Parttime\Base\Controller;

class HomeController extends Controller{

	public function __construct() {
		parent::__construct();
		$this->view->setTemplateSubPath('Home');
		$this->checkLogin();
	}

	/**
	 * 兼职平台首页
	 */
	public function indexAction() {
		$this->response->redirect('/Comment');
		$this->assign('title', '美丽说兼职平台');
		$this->show();
	}
}