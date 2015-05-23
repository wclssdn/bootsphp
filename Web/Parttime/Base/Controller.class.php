<?php

namespace Web\Parttime\Base;

use Resource\Base\HtmlController;
class Controller extends HtmlController {

	protected $user = null;

	public function __construct(){
		parent::__construct();
		$this->view->setTemplatePath(PATH_ROOT . 'Web/Parttime/View');
		$this->user = $this->getLoginUserInfo();
		$this->assign('user', $this->user);
	}

	public function checkLogin(){
		if (!$this->isLogin()){
			$this->error('请先登录', 1, array('redirect' => '/User/login'));
		}
	}

	public function getLoginUserInfo(){
		return isset($_SESSION['user']) ? $_SESSION['user'] : null;
	}

	public function isLogin(){
		return isset($_SESSION['user']) && $_SESSION['user'];
	}

	public function login($userInfo){
		$_SESSION['user'] = $userInfo;
	}

	public function logout(){
		unset($_SESSION['user']);
	}
	
	public function ___404___Action(){
		$this->show(array(), '404.tpl.php', $this->request->getWebRootFilePath() . 'View/Public');
	}

	private function busy($message){
		$this->assign('title', '系统繁忙');
		$this->show(array('message' => $message), 'busy.tpl.php', $this->request->getWebRootFilePath() . 'View/Public');
	}
}