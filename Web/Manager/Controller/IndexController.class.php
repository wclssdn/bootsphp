<?php

namespace Web\Manager\Controller;

use Web\Manager\Base\Controller;

class IndexController extends Controller{

	public function __construct(){
		parent::__construct();
		$this->view->setTemplatePath(PATH_ROOT . 'Web/Manager/View');
	}

	public function indexAction(){
		$this->show();
	}
	
	public function testAction(){
		echo 'test';
	}

	protected function getLoginUser(){
		return array();
	}

	protected function setLoginUser(array $userInfo){
		return true;
	}
}