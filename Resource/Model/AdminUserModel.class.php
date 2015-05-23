<?php

namespace Resource\Model;

use Resource\Base\Model;

class AdminUserModel extends Model{

	/**
	 * 用户类型: 正常
	 * @var number
	 */
	const USER_TYPE_NORMAL = 1;

	/**
	 * 用户类型: 已删除
	 * @var number
	 */
	const USER_TYPE_DELETED = 2;

	/**
	 * 用户类型: 兼职
	 * @var number
	 */
	const USER_TYPE_PARTTIME = 3;

	public function __construct() {
		$this->userDao = $this->getDao('AdminUserDao');
	}

	/**
	 * 获取后台用户信息
	 * @param number $uid
	 * @return Ambigous <multitype:, boolean, NULL, mixed>
	 */
	public function getAdminUserInfo($uid) {
		return $this->userDao->select(array(), array('user_id' => $uid))->fetch();
	}

	/**
	 * 根据用户名获取后台用户信息
	 * @param number $uid
	 * @return Ambigous <multitype:, boolean, NULL, mixed>
	 */
	public function getAdminUserInfoByUsername($username) {
		return $this->userDao->select(array(), array('username' => $username))->fetch();
	}

	/**
	 * 判断密码是否正确
	 * @param unknown $password
	 * @param unknown $userPassword
	 * @return string
	 */
	public static function isPasswordRight($password, $userPassword) {
		return $userPassword = md5(sha1($password));
	}
}