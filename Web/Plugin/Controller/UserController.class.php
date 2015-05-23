<?php

namespace Web\Plugin\Controller;

use Resource\Model\UserModel;
use \BootsPHP\Util\String;

class UserController extends \Web\Plugin\Base\Controller {

	public function loginAction(){
		$username = $this->request->getParam('username');
		$password = $this->request->getParam('password');
		$m = new UserModel();
		if (($user = $m->getUserByName($username)) === false){
			$this->jsonError(1, '用户不存在');
		}
		if (!$m->isRightPassword($user['password'], $password)){
			$this->jsonError(2, '密码错误');
		}
		$_SESSION['user'] = $user;
		$this->jsonSuccess('登录成功', array(
			'username' => $user['username'], 
			'regtime' => $user['reg_time'], 
			'sign' => session_id()));
	}

	public function isLoginAction(){
		if (isset($_SESSION['user'])){
			$this->jsonSuccess();
		}
		$this->jsonError(1, '未登录');
	}

	public function reLoginAction(){
		$sign = $this->request->getParam('sign');
		if (!$sign){
			$this->jsonError(1, '登录失败');
		}
		session_write_close();
		session_id($sign);
		session_start();
		if (isset($_SESSION['user'])){
			$this->jsonSuccess('', array(
				'username' => $_SESSION['user']['username'], 
				'regtime' => $_SESSION['user']['reg_time'], 
				'sign' => session_id()));
		}
		$this->jsonError(2, '登录失败');
	}

	public function logoutAction(){
		unset($_SESSION['user']);
		$this->jsonSuccess('logout');
	}

	public function registerAction(){
		$username = $this->request->getParam('username');
		$password = $this->request->getParam('password');
		if (String::isEmpty($username)){
			$this->jsonError(1, '用户名不能为空');
		}
		if (String::isEmpty($password)){
			$this->jsonError(2, '密码不能为空');
		}
		if (!String::isAlphaNumeric($username)){
			$this->jsonError(3, '用户名只能为字母+数字');
		}
		if (String::length($username) < 3 || String::length($username) > 16){
			$this->jsonError(4, '用户名长度为3-16位');
		}
		if (String::length($password) > 32){
			$this->jsonError(5, '密码不要太长啊! 你能记住么!');
		}
		$m = new UserModel();
		if ($m->isBlackUsername($username)){
			$this->jsonError(6, '不允许的用户名');
		}
		if ($m->getUserByName($username)){
			$this->jsonError(7, '用户名已经存在');
		}
		if ($m->getErrorMessage()){
			$this->jsonError(8, '注册失败, 请重试');
		}
		if (($id = $m->addUser($username, $password, $this->request->getIp())) !== false){
			$this->jsonSuccess('注册成功!', array('id' => $id));
		}
		$this->jsonError(9, '注册失败, 请重试');
	}
}