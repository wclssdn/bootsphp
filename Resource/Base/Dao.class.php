<?php

namespace Resource\Base;

use BootsPHP\BootsPHP;
use BootsPHP\Exception\DatabaseException;
use BootsPHP\Util\Factory;

class Dao extends \BootsPHP\Dao{

	/**
	 * 数据库配置KEY(用于读取数据库配置)
	 * @var string
	 */
	protected $databaseConfigKey;

	/**
	 * 数据库名
	 * @var string
	 */
	protected $database;

	public function __construct($pdo = null) {
		if (!$this->tableName){
			throw new DatabaseException('table name is empty');
		}
		$key = $this->getDbHandelName();
		$pdos = Factory::getPdo($key, $this->getDbConfig($this->databaseConfigKey, $this->database));
		if ($pdos === false){
			throw new DatabaseException("{$this->tableName}'s config is not available. use key {$this->databaseConfigKey}.");
		}
		parent::__construct($pdos['master']);
		if (isset($pdos['slave'])){
			foreach ($pdos['slave'] as $slave){
				$this->addSlave($slave);
			}
		}
	}

	/**
	 * 获取数据库配置
	 * @param string $key
	 * @param string $database
	 * @param array $dbConfig 附加数据库配置数组
	 * @return null array
	 */
	protected function getDbConfig($key, $database, $dbConfig = array()) {
		static $dbParser = null;
		$dbConfigFile = "/home/work/conf/mysql/{$key}.mysql.ini";
		if (!is_file($dbConfigFile)){
			return false;
		}
		$dbParser === null && $dbParser = new MLSDbConfigParser($dbConfigFile);
		return $dbParser->getConfig($database);
	}

	/**
	 * 获取数据库操作句柄缓存标识
	 * 默认使用表名, 如果多个网站可能存在表名重复, 需要重写此函数
	 * @return string
	 */
	protected function getDbHandelName() {
		return $this->database;
	}
}