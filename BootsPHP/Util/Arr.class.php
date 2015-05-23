<?php

namespace BootsPHP\Util;

class Arr {

	/**
	 * 获取子数组的某列值
	 * @param array $array 二维数组数据源
	 * @param string|array $key 子维数组的键名, 支持多个值
	 * @param boolean $unique 返回数组内元素是否需要唯一
	 * @return array
	 */
	public static function subValues(array $array, $key, $uniqie = true){
		$result = array();
		if (is_array($key)){
			foreach ($key as $k){
				$result = array_merge($result, self::subValues($array, $k, $uniqie));
			}
		}else{
			$result = array_map(function ($v) use($key){
				return isset($v[$key]) ? $v[$key] : null;
			}, $array);
		}
		return $uniqie ? array_unique($result) : $result;
	}

	/**
	 * 获取一维数组: 子数组某列为结果数组的key, 子数组某列为结果数组的value
	 * @param array $array 二维数组数据源
	 * @param string $key 子维数组的键名: 结果数组的key
	 * @param string $val 子维数组的键名: 结果数组的value
	 * @return array
	 */
	public static function subArray(array $array, $key, $val){
		if (empty($array)){
			return array();
		}
		return array_combine(self::subValues($array, $key, false), self::subValues($array, $val, false));
	}
}