<?php
/**
 * 路由逻辑:
 * 在路由表中的可匹配成功的规则, 根据规则给定Controller, action执行方法.
 * 如果Controller中不存在给定的action方法, 则查找___DEFAULT___Action方法, 如果___DEFAULT___Action方法不存在,
 * 则继续查找___404___Actioin, 如果404方法仍然不存在, 则输出http404错误.
 * 如果存在以上任一文件, 并且存在___HOLDE___Action, 则只调用此方法.
 * TODO
 * 站点内匹配不到路由, 可执行默认拦截控制器的默认方法
 * @author Wclssdn
 *
 */
namespace BootsPHP;

use BootsPHP\Exception\ClassNotFoundException;
use BootsPHP\Exception\ResponseException;

class Dispatcher {

	private function __construct(){
	}

	public static function router(array $router){
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		$requestUri = $_SERVER['REQUEST_URI'];
		$pathInfo = ($pos = strpos($requestUri, '?')) ? substr($requestUri, 0, $pos) : substr($requestUri, 0);
		if ($pathInfo == '/index.php'){
			$pathInfo = '/';
		}elseif (substr($pathInfo, 0, 11) == '/index.php/'){
			$pathInfo = substr($pathInfo, 10);
		}
		$requestHost = $_SERVER['HTTP_HOST'];
		foreach ($router as $host => $routerInfo){
			$hostPartten = str_replace(array('*.', '+.', '.', '*', '#', '@'), array(
				'#', 
				'@', 
				'\.', 
				'#', 
				'.*?', 
				'.+?\.'), $host);
			if (preg_match("#^{$hostPartten}$#i", $requestHost)){
				$webRootUrlPath = isset($routerInfo['urlPath']) ? trim($routerInfo['urlPath']) : '/';
				$webRootFilePath = rtrim(str_replace('/', DIRECTORY_SEPARATOR, $routerInfo['filePath']), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
				isset($routerInfo['configPath']) && $webConfigFilePath = rtrim(str_replace('/', DIRECTORY_SEPARATOR, $routerInfo['configPath']), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
				$defineFile = isset($routerInfo['define']) ? $routerInfo['define'] : '';
				if (isset($routerInfo['autoload'])){
					$autoload = Autoload::getInstance($webRootFilePath);
					isset($routerInfo['autoload']['path']) && is_array($routerInfo['autoload']['path']) && $autoload->setFindPath($routerInfo['autoload']['path']);
					isset($routerInfo['autoload']['extension']) && is_array($routerInfo['autoload']['extension']) && $autoload->setFileExtension($routerInfo['autoload']['extension']);
					$autoload->hold();
				}
				$request = Request::getInstance();
				$response = Response::getInstance();
				$request->setWebRootFilePath($webRootFilePath);
				isset($webConfigFilePath) && $request->setConfigFilePath($webConfigFilePath);
				$request->setWebRootUrlPath($webRootUrlPath);
				defined('PATH_WEB_ROOT') || define('PATH_WEB_ROOT', $webRootFilePath);
				defined('URL_WEB_ROOT') || define('URL_WEB_ROOT', $webRootUrlPath);
				if (isset($routerInfo['rewrite']) && is_array($routerInfo['rewrite'])){
					foreach ($routerInfo['rewrite'] as $uri => $rewriteInfo){
						$uri = ltrim($uri, '/');
						$matches = array();
						if (preg_match("#^{$webRootUrlPath}{$uri}$#", $pathInfo, $matches)){
							if (empty($rewriteInfo['method'][$requestMethod])){
								throw new ResponseException("Request method {$requestMethod} is not allowed", Response::STATUS_METHOD_NOT_ALLOWED);
							}
							$methodRewriteInfo = & $rewriteInfo['method'][$requestMethod];
							array_shift($matches);
							$paramPartten = array_map(function ($v){
								return "\${$v}";
							}, range(1, count($matches)));
							if (isset($methodRewriteInfo['controller']) && isset($methodRewriteInfo['action'])){
								$methodRewriteInfo['controller'] = str_replace($paramPartten, $matches, $methodRewriteInfo['controller']);
								$methodRewriteInfo['action'] = str_replace($paramPartten, $matches, $methodRewriteInfo['action']);
								$request->setController(substr($methodRewriteInfo['controller'], strrpos($methodRewriteInfo['controller'], '\\') + 1, -10));
								$request->setAction(substr($methodRewriteInfo['action'], 0, -6));
								$params = array();
								if (isset($rewriteInfo['param']) && !empty($rewriteInfo['param'])){
									foreach ($rewriteInfo['param'] as &$param){
										$param = str_replace($paramPartten, $matches, $param);
									}
									unset($param);
								}
								if (isset($methodRewriteInfo['param']) && !empty($methodRewriteInfo['param'])){
									foreach ($methodRewriteInfo['param'] as &$param){
										$param = str_replace($paramPartten, $matches, $param);
									}
									unset($param);
								}
								isset($rewriteInfo['param']) && $params = $rewriteInfo['param'];
								isset($methodRewriteInfo['param']) && $params = array_merge($params, $methodRewriteInfo['param']);
								$arguments = file_get_contents('php://input');
								$arg = array();
								parse_str($arguments, $arg);
								$request->setParams(array_merge($_GET, $_POST, $params, $arg));
								try{
									if (!class_exists($methodRewriteInfo['controller'])){
										if (isset($rewriteInfo['last']) && $rewriteInfo['last']){
											throw new ResponseException('Controller ' . $methodRewriteInfo['controller'] . ' not found', Response::STATUS_FILE_NOT_FOUND);
										}else{
											continue;
										}
									}
								}catch (ClassNotFoundException $e){
									continue;
								}
								// TODO 根据参数判断是否当作AOP切面处理
								if (!method_exists($methodRewriteInfo['controller'], $methodRewriteInfo['action']) && method_exists($methodRewriteInfo['controller'], '___DEFAULT___Action')){
									$methodRewriteInfo['action'] = '___DEFAULT___Action';
									break;
								}
							}
						}
					}
					if (is_file($defineFile)){
						include $defineFile;
					}
					//如果未确定执行具体哪个方法, 则检查文件是否存在. 如果文件也不存在, 则查找404页面是否存在.
					if (!isset($methodRewriteInfo['controller']) || !isset($methodRewriteInfo['action'])){
						//rewrite中写明重定向到文件
						if (isset($methodRewriteInfo['file'])){
							isset($methodRewriteInfo['file']['cache']['control']) && $response->setCacheControl($methodRewriteInfo['file']['cache']['control']);
							isset($methodRewriteInfo['file']['cache']['time']) && $response->setCacheTime($methodRewriteInfo['file']['cache']['time']);
							isset($methodRewriteInfo['file']['path']) && $path = $methodRewriteInfo['file']['path'];
							$file = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path . ltrim($pathInfo, '/'));
							$response->holdFile($file);
						}elseif (isset($routerInfo['rewrite']['/404'])){
							$methodRewriteInfo = $routerInfo['rewrite']['/404']['method']['GET'];
						}
					}
					if (isset($methodRewriteInfo['controller']) && isset($methodRewriteInfo['action'])){
						$controller = new $methodRewriteInfo['controller']();
						if (method_exists($methodRewriteInfo['controller'], '___HOLD___Action')){
							$controller->___HOLD___Action();
						}else{
							$controller->$methodRewriteInfo['action']();
						}
					}else{
						throw new ResponseException('Page not found!', Response::STATUS_FILE_NOT_FOUND, null);
					}
					return true;
				}
				//rewrite中未写明重定向到文件, 尝试重定向到文件.
				$file = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $webRootFilePath . ltrim($pathInfo, '/'));
				$response->holdFile($file);
			}
		}
	}

	final private function __clone(){
	}
}
