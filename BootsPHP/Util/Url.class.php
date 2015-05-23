<?php

namespace BootsPHP\Util;

/**
 * URL工具
 * @author wclssdn <ssdn@vip.qq.com>
 *
 */
class Url {

	public static function getCurrentUrl(){
		return isset($_SERVER['HTTP_HTTPS']) && $_SERVER['HTTP_HTTPS'] == 'on' ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	public static function getHost(){
		return $_SERVER['HTTP_HOST'];
	}

	public static function getPathinfo(){
		return isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	}

	public static function getQueryString(){
		return $_SERVER['QUERY_STRING'];
	}

	/**
	 * 生成URL
	 * @param string $baseUrl 基础URL 默认为 /
	 * @param array $params 参数
	 * @param array $removeParams 需要移除的参数(如果参数中存在则自动覆盖,无需移除)
	 * @return string
	 */
	public static function create($baseUrl, array $params = array(), array $removeParams = array()){
		$baseUrl || $baseUrl = '/';
		$urlInfo = parse_url($baseUrl);
		$url = '';
		if (isset($urlInfo['host'])){
			isset($urlInfo['scheme']) && $url .= "{$urlInfo['scheme']}://";
			isset($urlInfo['user']) && isset($urlInfo['pass']) && $url .= "{$urlInfo['user']}:{$urlInfo['pass']}@";
			$url .= $urlInfo['host'];
			isset($urlInfo['port']) && $url .= ":{$urlInfo['port']}";
		}
		isset($urlInfo['path']) && $url .= $urlInfo['path'];
		$query = array();
		if (isset($urlInfo['query'])){
			parse_str($urlInfo['query'], $query);
		}
		$removeParams && $query = array_diff_key($query, array_combine($removeParams, range(1, count($removeParams))));
		$query = array_merge($query, $params);
		$query && $url .= '?' . http_build_query($query);
		isset($urlInfo['fragment']) && $url .= "#{$urlInfo['fragment']}";
		return $url;
	}
}