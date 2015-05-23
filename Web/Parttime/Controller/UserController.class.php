<?php

namespace Web\Parttime\Controller;

use Web\Parttime\Base\Controller;
use Resource\Model\AdminUserModel;

class UserController extends Controller{

	public function __construct() {
		parent::__construct();
		$this->view->setTemplateSubPath('User');
	}

	public function indexAction() {
		$this->response->redirect('/');
	}

	/**
	 * 登陆
	 */
	public function loginAction() {
		if ($this->isLogin()) {
			$this->response->redirect('/');
		}
		if ($this->request->isPost()){
			$username = $this->request->getParam('username');
			$password = $this->request->getParam('password');
			$remember = $this->request->getParam('remember', 'boolean', false);
			$backurl = $this->request->getParam('backurl', 'string', '/');
			$backurl || $backurl = '/';
			$userModel = new AdminUserModel();
			$userInfo = $userModel->getAdminUserInfoByUsername($username);
			if (!$userInfo){
				$this->error('用户不存在');
			}
			if (!$userModel->isPasswordRight($password, $userInfo['password'])){
				$this->error('密码错误');
			}
			$this->login($userInfo);
			if ($remember){
				session_set_cookie_params(86400 * 7);
			}
			$this->success('登陆成功', array('redirect' => $backurl));
		}
		$backurl = $this->request->getParam('backurl');
		$this->assign('backurl', $backurl);
		$this->assign('title', '登陆 美丽说兼职平台');
		$this->show();
	}

	/**
	 * 登出
	 */
	public function logoutAction() {
		$this->logout();
		$this->success('登出成功', array('redirect' => '/'));
	}
}