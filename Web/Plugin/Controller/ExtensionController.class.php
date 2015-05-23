<?php

namespace Web\Plugin\Controller;

class ExtensionController extends \Web\Plugin\Base\Controller {

	private $url;

	private $page;

	private $params = array();

	private $js;

	public function banAction(){
		$this->url = "http://{$_SERVER['HTTP_HOST']}/";
		$this->page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
		if ($this->page === null){
			return false;
		}
		$this->js = $this->request->getWebRootFilePath() . 'js/';
		$urlInfo = parse_url($this->page);
		if (isset($urlInfo['query'])){
			parse_str($urlInfo['query'], $this->params);
		}
		$handler = array(
			'#^http://t.qq.com\b.*$#i' => array('t_qq_com'), 
			'#^http://(www\.)?weibo.com\b.*$#i' => array('weibo_com'),
			'#^(.*)$#' => array('all_sites'));
		header('Content-Type:application/x-javascript');
		ob_start();
		foreach ($handler as $pattern => $functions){
			if (preg_match($pattern, $this->page)){
				foreach ($functions as $function){
					$methodName = "action_{$function}";
					if (method_exists($this, $methodName)){
						echo PHP_EOL;
						$this->$methodName($this->params);
						echo PHP_EOL;
					}
				}
			}
		}
		$content = ob_get_contents();
		ob_end_clean();
		$this->jsonSuccess("<script>{$content}</script>", array('cacheExpire' => 1000));
	}

	public function popupAction(){
		$this->view->setTemplatePath($this->request->getWebRootFilePath() . 'View/Extension/');
		$html = $this->view->fetch('popup.tpl.php');
		$this->jsonSuccess($html);
	}

	public function backgroundAction(){
		$mtime = filemtime($this->request->getWebRootFilePath() . 'View/Extension/background.tpl.php');
		if (!$this->response->isModifyed($mtime)){
			$this->response->noModifed();
			$this->response->response();
		}
		$this->response->setLastModify($mtime);
		$this->view->setTemplatePath($this->request->getWebRootFilePath() . 'View/Extension/');
		$html = $this->view->fetch('background.tpl.php');
		$this->jsonSuccess($html);
	}

	public function optionsAction(){
		if (!isset($_SESSION['user'])){
			$mtime = filemtime($this->request->getWebRootFilePath() . 'View/Extension/options.tpl.php');
			if (!$this->response->isModifyed($mtime)){
				$this->response->noModifed();
				$this->response->response();
			}
			$this->response->setLastModify($mtime);
		}
		$this->view->setTemplatePath($this->request->getWebRootFilePath() . 'View/Extension/');
		$html = $this->view->fetch('options.tpl.php');
		$this->jsonSuccess($html);
	}

	/**
	 * t.qq.com
	 */
	private function action_t_qq_com(){
		$js = $this->js . 't_qq_com.js';
		$time = filemtime($js);
		if (!$this->response->isModifyed($time)){
			$this->response->noModifed();
			$this->response->response();
		}
		$this->jquery();
		$this->response->setLastModify($time);
		include $js;
	}

	/**
	 * weibo.com
	 */
	private function action_weibo_com(){
		$js = $this->js . 'weibo_com.js';
		$time = filemtime($js);
		if (!$this->response->isModifyed($time)){
			$this->response->noModifed();
			$this->response->response();
		}
		$this->jquery();
		$this->response->setLastModify(filemtime($js));
		include $js;
	}

	/**
	 * all sites
	 */
	private function action_all_sites(){
		$js = $this->js . 'all_sites.js';
		$time = filemtime($js);
		if (!$this->response->isModifyed($time)){
			$this->response->noModifed();
			$this->response->response();
		}
		$this->jquery();
		$this->response->setLastModify(filemtime($js));
		include $js;
	}

	/**
	 * 加载jQuery
	 */
	private function jquery(){
		$jquery = PATH_PUBLIC . 'js/jquery.min.js';
		include_once $jquery;
	}
}