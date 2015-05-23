<?php

namespace BootsPHP;

use BootsPHP\Exception\FileNotExistsException;
use BootsPHP\Exception\ConfigFileFormatError;

/**
 * 配置读取基类
 * TODO 支持多格式配置, 构造方法提供文件格式选项.
 * 最终解析成数组
 * @author Wclssdn
 */
class Config {

	/**
	 * 配置数组
	 * @var array
	 */
	protected $config;

	/**
	 * 载入配置文件
	 * @param string $configFile 配置文件绝对路径, 或者当前站点下的配置文件名称(可包含子目录)
	 * @throws FileNotExistsException
	 * @throws ConfigFileFormatError
	 */
	public function __construct($configFile, $throwException = false){
		if (!is_file($configFile)){
			$request = Request::getInstance();
			$configFile = $request->getConfigFilePath() . $configFile . '.conf.php';
			if (!is_file($configFile)){
				if ($throwException){
					throw new FileNotExistsException("Config File {$configFile} not exists!");
				}
			}
		}
		$this->config = include $configFile;
		if (!is_array($this->config)){
			throw new ConfigFileFormatError("Config File {$configFile} format error! Must be a array.");
		}
	}

	/**
	 * 获取配置值
	 * @param string $key
	 * @param mixed $default 获取不到则使用的默认值
	 * @return mixed
	 */
	public function get($key, $default = null){
		return isset($this->config[$key]) ? $this->config[$key] : $default;
	}

	public function getAll(){
		return $this->config;
	}
}