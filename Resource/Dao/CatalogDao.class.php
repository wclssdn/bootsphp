<?php

namespace Resource\Dao;

use Resource\Base\Dao;

class CatalogDao extends Dao{

	const COLUMN_FORMAT_JSON = 'json';

	protected $tableName = 'catalog';

	protected $columns = array('userinfo' => array('format' => 'json'));

	protected function ___beforeInsert(array $fields, array $values) {
		if (array_intersect(array_keys($this->columns), $fields)){
			foreach ($fields as $field){
				if (isset($this->columns[$field])){
					
				}
			}
		}
		return $values;
	}

	protected function ___afterGet(array $values) {
		foreach ($values as &$value){
			foreach ($this->columns as $column => $columnInfo){
				if (isset($values[$column])){
					$value[$column] = $this->columnDecode($value[$column], $columnInfo);
				}
			}
		}
		unset($value);
		return $values;
	}

	/**
	 * 列加密
	 * @param mixed $value 要存入数据库中的列数据
	 * @param array $columnInfo 列信息
	 * @return string
	 */
	protected function columnEncode($value, $columnInfo) {
		switch ($columnInfo['type']){
			case 'json':
				return json_encode($value);
			case 'serialize':
				return serialize($value);
			default:
				return $value;
		}
	}

	/**
	 * 列解密
	 * @param string $value 数据库中取出的列内容
	 * @param array $columnInfo 列信息
	 * @return mixed
	 */
	protected function columnDecode($value, $columnInfo) {
		switch ($columnInfo['type']){
			case 'json':
				return json_decode($value, true);
			case 'serialize':
				return unserialize($value);
			default:
				return $value;
		}
	}
}