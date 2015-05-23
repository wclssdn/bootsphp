<?php

namespace BootsPHP\Util;

/**
 * 数据库配置文件解析器
 * @author wclssdn
 *
 */
class DbConfigParser{

	protected $config;

	public function __construct($file) {
		$this->parse($file);
	}

	/**
	 * 解析配置文件
	 * @param string $file 配置文件绝对路径
	 */
	protected function parse($file) {
		$this->config = include $file;
	}

	/**
	 * 获取数据库配置
	 * @param string $key 自定义数据库配置标识
	 * @return array
	 */
	public function getConfig($key) {
		return isset($this->config[$key]) ? $this->config[$key] : (isset($this->config['*']) ? $this->config['*'] : array());
	}

	/**
	 * 添加一个数据库配置
	 * @param string $key 自定义数据库配置标识
	 * @param unknown $dbname 
	 * @param unknown $host
	 * @param unknown $port
	 * @param unknown $user
	 * @param unknown $pass
	 * @param unknown $master
	 * @param unknown $weight
	 */
	protected function addConfig($key, $dbname, $host, $port, $user, $pass, $weight, $master) {
		$tmp = array();
		$tmp['db'] = $dbname;
		$tmp['host'] = $host;
		$tmp['port'] = $port;
		$tmp['user'] = $user;
		$tmp['pass'] = $pass;
		$tmp['weight'] = $weight;
		if ($master){
			$this->config[$key]['master'] = $tmp;
		}else{
			$this->config[$key]['slave'][] = $tmp;
		}
	}
}