<?php

namespace BootsPHP;

use BootsPHP\Exception\ClassNotFoundException;

class Model{

	/**
	 * 获取Dao对象
	 * @param string $dao Dao名称
	 * @param string $namespace 所在命名空间
	 * @throws ClassNotFoundException
	 * @return Dao
	 */
	public function getDao($dao, $namespace = null) {
		static $cache = array();
		$classname = $namespace === null ? $dao : rtrim($namespace, '\\') . '\\' . $dao;
		if (!class_exists($classname)){
			throw new ClassNotFoundException("{$classname} is not found!");
		}
		if (!isset($cache[$classname])){
			$cache[$classname] = new $classname();
		}
		return $cache[$classname];
	}
}