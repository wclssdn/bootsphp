<?php

namespace BootsPHP\Util;

/**
 * CURL
 * @author wclssdn <ssdn@vip.qq.com>
 *
 */
class Curl{

	/**
	 * 结果解析函数
	 * @var callable
	 */
	private static $resultParser;

	/**
	 * 出错信息
	 * @var array
	 */
	private static $error;

	/**
	 * 请求响应详情
	 * @var array
	 */
	private static $detail;

	private static $header;

	private static $body;

	private function __construct() {
	}

	private function __clone() {
	}

	/**
	 * 设置结果解析器 3个参数 $body, $httpCode, $header
	 * @param callable $callable
	 */
	public static function setResultPraser($callable) {
		if (is_callable($callable)){
			self::$resultParser = $callable;
		}
	}

	public static function get($api, $params, $header = array(), $cookie = array(), $timeout = 5) {
		return self::request($api, 'GET', $params, $header, $cookie, $timeout);
	}

	public static function post($api, $params, $header = array(), $cookie = array(), $timeout = 5) {
		return self::request($api, 'POST', $params, $header, $cookie, $timeout);
	}

	public static function put($api, $params, $header = array(), $cookie = array(), $timeout = 5) {
		return self::request($api, 'PUT', $params, $header, $cookie, $timeout);
	}

	public static function delete($api, $params, $header = array(), $cookie = array(), $timeout = 5) {
		return self::request($api, 'DELETE', $params, $header, $cookie, $timeout);
	}

	/**
	 * 获取错误
	 * @return string
	 */
	public static function getError() {
		return self::$error;
	}

	/**
	 * 获取请求响应明细
	 * @return array
	 */
	public static function getDetail() {
		return self::$detail;
	}

	/**
	 * 获取响应头
	 * @return string
	 */
	public static function getHeader() {
		return self::$header;
	}

	/**
	 * 获取响应正文
	 * @return string
	 */
	public static function getBody() {
		return self::$body;
	}

	private static function request($api, $method, $params, $header = array(), $cookie = array(), $timeout = 5) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		if (!empty($header)){
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		}
		if (!empty($cookie)){
			curl_setopt($curl, CURLOPT_COOKIE, implode('; ', $cookie));
		}
		switch (strtolower($method)){
			case 'get':
				if (strpos($api, '?')){
					$parse = parse_url($api);
					if (isset($parse['query'])){
						parse_str($parse['query'], $parse['query']);
					}
					$params = array_merge($parse['query'], $params);
					$api = "{$parse['scheme']}://{$parse['host']}{$parse['path']}";
				}
				$api .= '?' . http_build_query($params);
				break;
			case 'post':
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
				break;
			case 'put':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
				break;
			case 'delete':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
				break;
		}
		curl_setopt($curl, CURLOPT_URL, $api);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLINFO_HEADER_OUT, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
		$response = curl_exec($curl);
		self::$error = curl_error($curl);
		if (self::$error !== ""){
			return false;
		}
		self::$detail = curl_getinfo($curl);
		self::$header = substr($response, 0, self::$detail['header_size']);
		self::$body = substr($response, self::$detail['header_size']);
		return self::$resultParser ? call_user_func(self::$resultParser, self::$body, self::$detail['http_code'], self::$header) : self::$body;
	}
}