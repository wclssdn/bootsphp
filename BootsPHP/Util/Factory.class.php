<?php

namespace BootsPHP\Util;

use BootsPHP\BootsPHP;
use BootsPHP\Pdo;

/**
 * 工厂
 * @author wclssdn <ssdn@vip.qq.com>
 */
class Factory{

	/**
	 * 获取主从PDO对象数组
	 * @param string $handelName 数据库句柄缓存标识
	 * @param array $config 数据库配置
	 * @return boolean array
	 */
	public static function getPdo($handelName, $config) {
		static $cache = array();
		if (!isset($cache[$handelName])){
			if (!$config){
				return false;
			}
			if (!isset($config['master'])){
				return false;
			}
			$pdos['master'] = Pdo::getInstance($config['master']['host'], $config['master']['port'], $config['master']['db'], $config['master']['user'], $config['master']['pass'], isset($config['master']['charset']) ? $config['master']['charset'] : null, isset($config['master']['driver']) ? $config['master']['driver'] : null, isset($config['master']['options']) ? $config['master']['options'] : array());
			if (isset($config['slave'])){
				foreach ($config['slave'] as $slave){
					if (!isset($slave['host'])){
						continue;
					}
					$pdos['slave'][] = Pdo::getInstance($slave['host'], $slave['port'], $slave['db'], $slave['user'], $slave['pass'], isset($slave['charset']) ? $slave['charset'] : null, isset($slave['driver']) ? $slave['driver'] : null, isset($slave['options']) ? $slave['options'] : array());
				}
			}
			$cache[$handelName] = $pdos;
		}
		return $cache[$handelName];
	}
}