<?php

namespace BootsPHP\Util;

/**
 * 字符串
 * @author wclssdn <ssdn@vip.qq.com>
 *
 */
class String {

	private function __construct(){
	}

	public static function isEmpty($str){
		return (boolean)preg_match('#^\s*$#', $str);
	}

	public static function isAlpha($str){
		return (boolean)preg_match('#^[a-z]+$#i', $str);
	}

	public static function isNumeric($str){
		return (boolean)preg_match('#^\d+$#i', $str);
	}

	public static function isAlphaNumeric($str){
		return (boolean)preg_match('#^[a-z\d]+$#i', $str);
	}

	public static function length($str, $encoding = 'utf8'){
		return mb_strlen($str, $encoding);
	}

	/**
	 * 计算字符宽度, 两个半角算一个字符宽度. 一个全角英文,一个汉字计算为一个字符宽度
	 * @param string $str 字符串
	 * @return mixed
	 */
	public static function width($str, $encoding = 'utf8'){
		for ($i = 0, $len = mb_strlen($str, $encoding); $i < $len; ++$i){
			$char = mb_substr($str, $i, 1);
			$ord = ord($char);
			if ($ord >= 32 && $ord <= 127){
				$width += 0.5;
			}elseif ($ord < 32){
			}else{
				$width += 1;
			}
		}
		return $width;
	}

	/**
	 * 保留HTML标记截取字符串长度
	 * @param string $html
	 * @param number $len
	 * @param string $encoding
	 * @return string
	 */
	public static function subStrExceptHtml($html, $len, $encoding = 'utf8'){
		$contentLen = mb_strlen($html, $encoding);
		if (empty($html) || $len <= 0 || $contentLen <= $len){
			return $html;
		}
		$result = '';
		$i = 0;
		$length = 0; //长度
		$inTag = false; //是否在标签中
		$isTagName = false; //当前字符是否属于标签名称
		$isCloseTag = false; //当前字符是否属于闭合标签
		$allowOpenTags = array('link', 'img'); //允许未闭合的标签数组
		$tags = array(); //标签数组
		$tagStr = ''; //整个标签字符串(包括属性)
		$tagName = ''; //标签名称
		while (true){
			$x = mb_substr($html, $i++, 1, $encoding); //取下一个字符
			if ($x === '<') { //进入标签处理
				if ($inTag && !empty($tags)){
					array_pop($tags);
				}
				$inTag = true; //开始处理标签内容
				$isTagName = true; //开始计算标签名称
				$tagStr = '<';
				continue;
			}
			if ($inTag) { //处理标签内容
				if ($x === '<') { //标签中出现"<",则"<"到上一个"<"舍弃
					$tagStr = '<';
				}
				$tagStr .= $x;
				if ($isTagName){ //计算标签名称
					if (strtolower($x) >= 'a' && strtolower($x) <= 'z'){ //合法的标签名称
						$tagName .= $x;
					}elseif ($x === '/' && $tagStr === '</') {
						$isCloseTag = true;
					}else{
						if ($isCloseTag) {
							if (!empty($tags) && strtolower($tagName) === strtolower(end($tags))) { //正好匹配
								array_pop($tags);
							}else{ //当前闭合标签不上一个标签不匹配
								$tagStr = '';
							}
						}else{
							if (!in_array(strtolower($tagName), $allowOpenTags)){
								$tags[] = $tagName;
							}
						}
						$tagName = '';
						$isTagName = false;
						$isCloseTag = false;
					}
				}
				if ($x === '>') { //标签结束
					$inTag = false;
					$result .= $tagStr;
					$tagStr = '';
				}
			}else{ //处理标签外内容
				if ($x === '>') { //如果不在标签中出现>,视为非法
					$x = '';
				}else{
					$result .= $x;
					++$length;
				}
			}
			if ($length >= $len) {
				break;
			}
		}
		if (!empty($tags)){ //存在未闭合标签
			$closedTagFix = '';
			foreach (array_reverse($tags) as $unClosedTag){
				$closedTagFix .= "</{$unClosedTag}>";
			}
			$result .= $closedTagFix;
		}
		return $result;
	}

	private final function __clone(){
	}
}