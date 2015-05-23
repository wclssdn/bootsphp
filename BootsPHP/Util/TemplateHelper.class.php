<?php

namespace BootsPHP\Util;

/**
 * 模板常用工具
 * @author wclssdn <ssdn@vip.qq.com>
 *
 */
class TemplateHelper {
	const CHARSET = 'utf8';

	/**
	 * 安全输出字符串到HTML代码中
	 * @param string $var 模板变量
	 * @param string $default 默认值
	 * @param boolean $return
	 * @return string null
	 */
	public static function S($var, $default = '', $return = false){
		if ($return){
			return $var ? htmlspecialchars($var) : htmlspecialchars($default);
		}
		echo $var ? htmlspecialchars($var) : htmlspecialchars($default);
	}

	/**
	 * 截取字符串
	 * @param string $str 待截取字符串
	 * @param number $length 截取长度
	 * @param string $suffix 截取后添加的后缀
	 * @param string $return 是否返回而不输出 *默认返回
	 * @return string|null
	 */
	public static function T($str, $length, $suffix = '...', $return = true){
		$result = $str;
		if (mb_strlen($str, self::CHARSET) > $length){
			$length || $length = 50;
			$result = mb_substr($result, 0, $length, self::CHARSET);
			$suffix && $result .= $suffix;
		}
		if ($return) {
			return $result;
		}
		echo $result;
	}

	/**
	 * 输出数字
	 * @param string|number $var
	 * @param number $default
	 * @param boolean $return
	 * @return number null
	 */
	public static function N($var, $default = 0, $return = false){
		if ($return){
			return $var ? intval($var) : intval($default);
		}
		echo $var ? intval($var) : intval($default);
	}

	/**
	 * 输出URL参数, 前边不包含?和&
	 * @param unknown $params
	 * @param string $return
	 * @return string
	 */
	public static function P($params, $return = false){
		$result = '';
		if (is_array($params)){
			$result = http_build_query($params);
		}elseif (is_scalar($params)){
			$result = urlencode($params);
		}else{
			$result = '';
		}
		if ($return){
			return $result;
		}
		echo $result;
	}

	public static function U($params){
		
	}
	/**
	 * 替换一个或多个指定字符
	 * TODO remove 支持assoc数组 key为查找, val为替换
	 * @param string $var
	 * @param string|array $remove 要移除的字符
	 * @param boolean $return
	 * @return mixed
	 */
	public static function R($var, $remove, $return = false){
		$result = str_replace($remove, '', $var);
		if ($return){
			return $result;
		}
		echo $result;
	}

	/**
	 * checked帮助方法
	 * @param string $value 表单的值
	 * @param string|array $compare 要对比的值(可为数组)
	 * @param boolean $return
	 * @return string
	 */
	public static function checked($value, $compare, $return = false){
		if ($return){
			return (is_array($compare) ? in_array($value, $compare) : $value == $compare) ? ' checked="checked"' : '';
		}
		echo (is_array($compare) ? in_array($value, $compare) : $value == $compare) ? ' checked="checked"' : '';
	}

	public static function selected($value, $compare, $return = false){
		if ($return){
			return $value == $compare ? ' selected="selected"' : '';
		}
		echo $value == $compare ? ' selected="selected"' : '';
	}

	/**
	 * 白名单标签方式输出HTML代码
	 * @param string $html
	 * @param array $config
	 * @param boolean $return
	 * @return string null
	 */
	public static function W($html, $config, $return = false){
	}

	/**
	 * 根据表达式决定输出trueText还是falseText
	 * @param boolean $expresion 表达式
	 * @param string $trueText
	 * @param string $falseText
	 * @param boolean $return
	 * @return string null
	 */
	public static function E($expresion, $trueText, $falseText, $return = false){
		if ($return){
			return $expresion ? $trueText : $falseText;
		}
		echo $expresion ? $trueText : $falseText;
	}

	/**
	 * 快速生成option标签
	 * @param array $options
	 * @param string $name 数组$options中标签内容列名称
	 * @param string $value 数组$options中标签值列名称
	 * @param string $return 是否返回
	 * @return string null
	 */
	public static function option(array $options, $nameKey = null, $valueKey = null, $selected = null, $return = false){
		$result = '';
		foreach ($options as $k => $v){
			$value = $valueKey ? $v[$valueKey] : $k;
			$name = $nameKey ? $v[$nameKey] : $v;
			$s = strval($value) === strval($selected) ? ' selected="selected"' : '';
			$result .= "<option value=\"{$value}\"{$s}>{$name}</option>";
		}
		if ($return){
			return $result;
		}
		echo $result;
	}
}
