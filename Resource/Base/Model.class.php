<?php

namespace Resource\Base;

use BootsPHP\Exception\QuitException;
class Model extends \BootsPHP\Model{

	/**
	 * DAO对象
	 * @var \BootsPHP\Dao
	 */
	protected $dao;

	/* (non-PHPdoc)
	 * @see \BootsPHP\Model::getDao()
	 */
	public function getDao($dao, $namespace = '\Resource\Dao') {
		try {
			return parent::getDao($dao, $namespace);
		}catch (\Exception $e){
			$this->log('phpsites_model_instance_dao_failed', $e->getMessage());
			throw new QuitException();
		}
	}

	/**
	 * 获取DAO的错误信息
	 * @return NULL \BootsPHP\Exception
	 */
	public function getErrorMessage($dao = null) {
		$dao || $dao = $this->dao;
		if (!$dao){
			return null;
		}
		if ($dao->getException() === null){
			return null;
		}
		return $dao->getException()->getMessage();
	}

	/**
	 * 获取DAO的错误代码
	 * @return NULL \BootsPHP\Exception
	 */
	public function getErrorCode($dao = null) {
		$dao || $dao = $this->dao;
		if (!$dao){
			return null;
		}
		if ($dao->getException() === null){
			return null;
		}
		return $dao->getException()->getCode();
	}

	/**
	 * 获取调试信息
	 * @return multitype:Ambigous <string, mixed> multitype: 
	 */
	protected function getDebugData($dao = null) {
		$dao || $dao = $this->dao;
		if (!$dao){
			return 'dao is null';
		}
		return array('lastSQL' => $dao->getLastSql(),'bindValues' => $dao->getBindValues());
	}

	/**
	 * 记录日志
	 * @param string $sign
	 * @param string $message
	 * @param mixed $data
	 * @return number
	 */
	protected function log($sign, $message, $data = array()) {
		$date = date('Y-m-d H:i:s');
		if (defined('DEBUG_MODE') && DEBUG_MODE) {
			var_dump($message, $data);
		}
		$data = json_encode($data);
		return file_put_contents("/tmp/phpsites_model_log_{$sign}.log", "Date:{$date}|Message:{$message}|Data:{$data}" . PHP_EOL, FILE_APPEND);
	}
}