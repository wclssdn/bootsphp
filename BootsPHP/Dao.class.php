<?php

namespace BootsPHP;

/**
 * 数据访问层
 * TODO pdo操作结果的判断方法 try catch?
 * @author Wclssdn
 */
class Dao{

	const INSERT_NORMAL = 0;

	const INSERT_IGNORE = 1;

	const INSERT_REPLACE = 2;

	/**
	 * 表名
	 * @var string
	 */
	protected $tableName;

	/**
	 * PDO对象
	 * @var \PDO
	 */
	protected $pdo;

	/**
	 * PDO从库对象数组
	 * @var \PDO
	 */
	protected $slave;

	/**
	 * 解析条件变量得到的绑定值
	 * @var array
	 */
	protected $bindValues = array();

	/**
	 * 缓存数组
	 * @var \PDOStatement
	 */
	protected $statements = array();

	/**
	 * 最后一次执行的statement
	 * @var \PDOStatement
	 */
	protected $lastStatement;

	/**
	 * 执行的SQL记录
	 * @var array
	 */
	protected $sqls = array();

	/**
	 * 异常信息
	 * @var \Exception
	 */
	protected $exception;

	/**
	 * 是否查询的时候计算真实行数
	 * @var boolean
	 */
	protected $calcFoundRows = false;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	/**
	 * 添加从库
	 * @param \PDO $pdo
	 * @return \BootsPHP\Dao\Dao
	 */
	protected function addSlave(\PDO $slave) {
		$this->slave && in_array($slave, $this->slave) || $this->slave[] = $slave;
		return $this;
	}

	/**
	 * 获取单行
	 * @param $field 指定某列的值
	 * @return array string
	 */
	public function fetch($field = null) {
		if (!$this->lastStatement){
			return false;
		}
		if ($field){
			$result = $this->lastStatement->fetch();
			if (isset($result[$field])){
				return $result[$field];
			}
			return null;
		}
		return $this->lastStatement->fetch();
	}

	/**
	 * 获取所有行
	 * @param string $key 使用哪列作为第一维数组的键
	 * @param string $val 使用哪列作为数组的值, 退化为一维数组
	 * @return boolean array
	 */
	public function fetchAll($key = null, $val = null) {
		if (!$this->lastStatement){
			return false;
		}
		if ($key || $val){
			$result = $this->lastStatement->fetchAll();
			if (!$result){
				return $result;
			}
			$final = array();
			foreach ($result as $k => $v){
				if ($key && !isset($v[$key])){
					throw new \Exception("there is not such a key({$key}) data:" . json_encode($v));
				}
				if ($val && !isset($v[$val])){
					throw new \Exception("there is not such a val({$val}) data:" . json_encode($v));
				}
				$final[$key ? $v[$key] : $k] = $val ? $v[$val] : $v;
			}
			return $final;
		}
		return $this->lastStatement->fetchAll();
	}

	/**
	 * 获取多行
	 * @param array $fields
	 * @param array $condition
	 * @param array $order
	 * @param number $offset
	 * @param number $limit *default 100
	 * @param unknown_type $group
	 * @param unknown_type $having
	 * @return Dao
	 */
	public function select(array $fields, array $condition, array $order = array(), $page = 1, $limit = 0, $group = '', $having = '') {
		try{
			$condition = $this->prepareCondition($condition);
		}catch (\Exception $e){
			return $this;
		}
		$fields = $this->prepareFields($fields);
		$group = $this->prepareGroup($group);
		$having = $this->prepareHaving($having);
		$order = $this->prepareOrder($order);
		$limit = $this->prepareLimit($page, $limit);
		$calcFoundRows = $this->calcFoundRows ? 'SQL_CALC_FOUND_ROWS ' : '';
		$this->calcFoundRows = false;
		$sql = "SELECT {$calcFoundRows}{$fields} FROM `{$this->tableName}`{$condition}{$group}{$having}{$order}{$limit}";
		$this->execute($sql, true);
		return $this;
	}

	/**
	 * 插入
	 * @param array $fields
	 * @param array $values
	 * @param number $insertType Dao::INSERT_XX
	 * @param array $onDuplicateUpdate array(field => 'values(`field`)', f2 => 'str', f3 => 123)
	 * @return boolean
	 */
	public function insert(array $fields, array $values, $insertType = null, array $onDuplicateUpdate = array()) {
		if (empty($fields) || count($fields) != count($values)){
			return false;
		}
		$fields = $this->prepareFields($fields);
		$values = $this->prepareValues($values);
		$opertion = 'INSERT';
		switch ($insertType){
			case self::INSERT_IGNORE:
				$opertion = 'INSERT IGNORE';
				break;
			case self::INSERT_REPLACE:
				$opertion = 'REPLACE';
				break;
		}
		$duplicateKeyUpdateStr = $this->prepareDuplicateKeyUpdate($onDuplicateUpdate);
		$sql = "{$opertion} INTO {$this->tableName} ({$fields}) VALUES ({$values}){$duplicateKeyUpdateStr}";
		$stat = $this->execute($sql);
		if ($stat === false){
			return false;
		}
		return $stat->errorCode() === '00000';
	}

	/**
	 * 批量插入
	 * @param array $data 固定格式数据
	 * 格式一: array(array(k1 => v11, k2 => v21, k3 => v31), array(k1 => v12, k2 => v22, k3 => v32), array(...))
	 * 格式二: array(k1 => array(v11, v12, v13), k2 => array(v21, v22, v23), k3 => array(v31, v32, v33)))
	 * 格式三: array(k1 => 'v', k2 => array(v21, v22, v23), k3 => array(v31, v32, v33))) 字符串值表示:所有行的k1列都为'v'
	 * @param number $insertType Dao::INSERT_XX
	 * @param array $onDuplicateUpdate array(field => 'values(`field`)', f2 => 'str', f3 => 123)
	 * @return boolean
	 */
	public function inserts(array $data, $insertType = null, array $onDuplicateUpdate = array()) {
		// 判断给定数据是哪种格式 1:key为数字,每个元素为一行数据 2:key为字符串,字符串为列名,每个子数组为一列的所有值(如果子数组为字符串, 则转换为等数量字符串数组)
		$type = 'number';
		$keys = array_keys($data);
		foreach ($keys as $key){
			if (!is_numeric($key)){
				$type = 'string';
			}
		}
		// 数字类型key
		if ($type == 'number'){
			$count = null;
			foreach ($data as $k => $v){
				if (isset($count) && $count !== count($v)){
					return false;
				}
				$count = count($v);
			}
			$fields = array_keys($data[0]);
		}else{ // 字符串类型key
			$count = null;
			foreach ($data as $k => $v){
				if (is_string($v)){
					continue;
				}
				// 不允许数目不一致
				if (isset($count) && $count !== count($v)){
					return false;
				}
				$count = count($v);
			}
			$fields = array_keys($data);
			$count === null && $count = 1; // 全部为字符串, 则转换为一个元素的数组
			foreach ($data as $k => $v){
				if (is_string($v)){
					$data[$k] = array_fill(0, $count, $v);
				}
			}
			// 转换为每个子元素包含一行数据
			$result = array();
			for($i = 0; $i < $count; ++$i){
				$tmp = array();
				foreach ($keys as $key){
					$tmp[] = $data[$key][$i];
				}
				$result[] = $tmp;
			}
			$data = $result;
		}
		$values = array();
		foreach ($data as $v){
			$v = $this->prepareValues($v);
			$values[] = "({$v})";
		}
		$values = implode(', ', $values);
		$fields = $this->prepareFields($fields);
		$opertion = 'INSERT';
		switch ($insertType){
			case self::INSERT_IGNORE:
				$opertion = 'INSERT IGNORE';
				break;
			case self::INSERT_REPLACE:
				$opertion = 'REPLACE';
				break;
		}
		$duplicateKeyUpdateStr = $this->prepareDuplicateKeyUpdate($onDuplicateUpdate);
		$sql = "{$opertion} INTO {$this->tableName} ($fields) VALUES {$values}{$duplicateKeyUpdateStr}";
		$stat = $this->execute($sql);
		if ($stat === false){
			return false;
		}
		return $stat->errorCode() === '00000';
	}

	/**
	 * 更新
	 * @param array $fields
	 * @param array $values
	 * @param array $condition
	 * @return boolean
	 */
	public function update(array $fields, array $values, array $condition) {
		if (empty($fields) || count($fields) != count($values)){
			return false;
		}
		$values = $this->prepareValues($values, $fields);
		try{
			$condition = $this->prepareCondition($condition);
		}catch (\Exception $e){
			return false;
		}
		$sql = "UPDATE {$this->tableName} SET {$values}{$condition}";
		$stat = $this->execute($sql);
		if ($stat === false){
			return false;
		}
		return $stat->errorCode() === '00000';
	}

	/**
	 * 删除
	 * @param array $condition
	 * @return boolean
	 */
	public function delete(array $condition) {
		try{
			$condition = $this->prepareCondition($condition);
		}catch (\Exception $e){
			return false;
		}
		$sql = "DELETE FROM `{$this->tableName}` {$condition}";
		$stat = $this->execute($sql);
		if ($stat === false){
			return false;
		}
		return $stat->errorCode() === '00000';
	}

	public function beginTransaction() {
		return $this->pdo->beginTransaction();
	}

	public function commit() {
		return $this->pdo->commit();
	}

	public function rollback() {
		return $this->pdo->rollBack();
	}

	public function getLastId() {
		return $this->pdo->lastInsertId();
	}

	/**
	 * 获取返回行数
	 * @return boolean
	 */
	public function getRows() {
		return $this->lastStatement ? $this->lastStatement->rowCount() : false;
	}

	/**
	 * 获取发现行数
	 * @return mixed
	 */
	public function getFoundRows() {
		$sql = 'SELECT FOUND_ROWS() AS r';
		$this->execute($sql);
		return $this->fetch('r');
	}

	/**
	 * 获取所有执行过的SQL
	 * @return array
	 */
	public function getSqls() {
		return $this->sqls;
	}

	/**
	 * 获取最后一条SQL
	 * @return string
	 */
	public function getLastSql() {
		return end($this->sqls);
	}

	/**
	 * 获取绑定值
	 * @return array
	 */
	public function getBindValues() {
		return $this->bindValues;
	}

	/**
	 * 获取异常信息
	 * @return Exception
	 */
	public function getException() {
		return $this->exception;
	}

	/**
	 * 将字符串用于SQL查询
	 * @param string $string
	 * @return string
	 */
	public function quote($string) {
		return $this->pdo->quote($string);
	}

	/**
	 * 设置是否查询的同时计算真实行数(单次查询有效)
	 * @param boolean $boolean
	 */
	public function calcFoundRows($boolean = true) {
		$this->calcFoundRows = (boolean)$boolean;
	}

	/**
	 * 执行自定义SQL
	 * @param string $sql
	 * @return boolean|Dao
	 */
	public function query($sql) {
		$stat = $this->execute($sql);
		if ($stat->errorCode() === '00000'){
			return $this;
		}
		return false;
	}

	/**
	 * 设置异常信息
	 * @param \Exception $exception
	 */
	protected function setException(\Exception $exception) {
		$this->exception = $exception;
	}

	/**
	 * 执行SQL
	 * @param string $sql
	 * @param boolean $slave 使用从库
	 * @return PDOStatement
	 */
	private function execute($sql, $slave = false) {
		$this->sqls[] = $sql;
		$key = crc32($sql);
		if (isset($this->statements[$key])){
			$stat = $this->statements[$key];
		}else{
			if ($slave && $pdo = $this->getSlave()){
			}else{
				$pdo = $this->pdo;
			}
			try{
				$stat = $this->statements[$key] = $pdo->prepare($sql);
			}catch (\Exception $e){
				$this->setException($e);
				return false;
			}
		}
		$this->lastStatement = $stat;
		$stat->execute($this->bindValues);
		$this->bindValues = array();
		return $stat;
	}

	/**
	 * 随机获取从库
	 * @return Ambigous <boolean, PDO>
	 */
	private function getSlave() {
		return empty($this->slave) ? false : $this->slave[array_rand($this->slave)];
	}

	/**
	 * fields
	 * @param array $fields
	 * @return string
	 */
	private function prepareFields(&$fields) {
		if (empty($fields)){
			return '*';
		}
		if (is_array($fields)){
			$fields = array_filter($fields);
			array_walk($fields, array($this,'prepareFields'));
			$fields = implode(',', $fields);
			return $fields;
		}else{
			$fields = trim($fields);
			$fixed = false;
			if (stripos($fields, ' AS ')){
				if (strpos($fields, '(')){
					$fields = preg_replace('#^(.+?)\s+AS\s+([a-z0-9_]+)$#i', '\1 AS `\2`', $fields);
				}else{
					$fields = preg_replace('#^([a-z0-9_]+)\s+AS\s+([a-z0-9_]+)$#i', '`\1` AS `\2`', $fields);
				}
				$fixed = true;
			}
			if (strpos($fields, '(')){
				$fields = preg_replace('#^(.+?)\(([^*]+?)\)(.*?)$#i', '\1(`\2`)\3', $fields);
				$fixed = true;
			}
			if (!$fixed){
				$fields = "`{$fields}`";
			}
			return $fields;
		}
	}

	/**
	 * value
	 * @param array $values
	 * @param array $fields
	 * @return string
	 */
	private function prepareValues(array $values, array $fields = array()) {
		$result = array();
		foreach ($values as $value){
			$randomStr = 'v_' . substr(uniqid(), -7);
			$this->bindValues[$randomStr] = $value === null ? '' : $value;
			if ($fields){
				$tmp = array_shift($fields);
				$field = $this->prepareFields($tmp);
				$result[] = "{$field} = :{$randomStr}";
			}else{
				$result[] = ":{$randomStr}";
			}
		}
		return implode(',', $result);
	}

	/**
	 * where
	 * @param mixed $condition
	 * @param boolean $first 非递归调用标志
	 * @throws \Exception
	 * @return string
	 */
	private function prepareCondition(array $condition, $first = true) {
		if (empty($condition)){
			return '';
		}
		if ($first && !is_numeric(key($condition))){
			$condition = array($condition);
		}
		foreach ($condition as $field => $value){
			// 数字索引数组按照OR关系算
			if (is_numeric($field)){
				$or[] = $this->prepareCondition($value, false);
			}else{ // 非数字索引数组按AND关系算
				$randomStr = 'f_' . substr(uniqid(), -7);
				// 先判断field 是否包含空格, 比如between应该是 array('field between' => array(1, 99)); TODO
				// 支持各种条件 like => array('%词A%', '词B')
				if (is_array($value)){
					if (empty($value)){
						throw new \Exception();
					}
					$i = 0;
					foreach ($value as $v){
						$this->bindValues[$randomStr . '_' . $i] = $v;
						$randomStrs[] = ":{$randomStr}_{$i}";
						++$i;
					}
					$randomStr = implode(',', $randomStrs);
					$condition[$field] = "`{$field}` IN ({$randomStr})";
				}elseif (is_scalar($value)){
					if (strpos($field, ' ')){ // 键中包含空格表明使用其他条件比较符 例如 field like
						$parts = explode(' ', $field, 2);
						$parts[1] = strtoupper($parts[1]);
						$condition[$field] = "`{$parts[0]}` {$parts[1]} :{$randomStr}";
					}else{
						$condition[$field] = "`{$field}` = :{$randomStr}";
					}
					$this->bindValues[$randomStr] = $value;
				}elseif ($value === null){
					$condition[$field] = "`{$field}` is null";
				}else{
					$condition[$field] = "`{$field}` = :{$randomStr}";
					$this->bindValues[$randomStr] = (string)$value;
				}
			}
		}
		if ($first){
			return ' WHERE ' . implode(' OR ', array_filter($or));
		}
		return implode(' AND ', $condition);
	}

	/**
	 * group by
	 * @param string $group
	 * @return string
	 */
	private function prepareGroup($group) {
		if (is_array($group)){
			$str = implode(',', array_map(function ($v) {
				return "`{$v}`";
			}, $group));
			return $group ? " GROUP BY {$str}" : '';
		}elseif (strpos($group, ',')){
			return $this->prepareGroup(explode(',', $group));
		}
		return $group ? " GROUP BY `{$group}`" : '';
	}

	/**
	 * having
	 * 待完善
	 * @param string $having
	 * @return string
	 */
	private function prepareHaving($having) {
		return $having ? " HAVING {$having}" : '';
	}

	/**
	 * order
	 * @param mixed $order
	 * @return string
	 */
	private function prepareOrder(array $order) {
		if (!$order){
			return '';
		}
		foreach ($order as $field => $type){
			$type = strtoupper($type);
			if ($type !== 'DESC' && $type !== 'ASC'){
				continue;
			}
			$order[$field] = "`{$field}` {$type}";
		}
		return ' ORDER BY ' . implode(',', $order);
	}

	/**
	 * limit
	 * @param number $page
	 * @param number $limit (boolean)$limit === false 表示不限
	 * @return string
	 */
	private function prepareLimit($page, $limit) {
		if (!$limit){
			return '';
		}
		$limit = max(1, intval($limit));
		$offset = max(0, $page - 1) * $limit;
		return " LIMIT {$offset}, {$limit}";
	}

	/**
	 * on duplicate key update
	 * @param array $duplicateUpdate
	 * @return string
	 */
	private function prepareDuplicateKeyUpdate(array $duplicateUpdate) {
		if ($duplicateUpdate){
			$t = array();
			foreach ($duplicateUpdate as $k => $v){
				$t[] = "`{$k}` = {$v}";
			}
			$t = implode(', ', $t);
			return " ON DUPLICATE KEY UPDATE {$t}";
		}
		return '';
	}
}