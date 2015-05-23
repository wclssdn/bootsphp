<?php

namespace Web\Plugin\Controller;

use Web\Plugin\Base\Controller;

class HomeController extends Controller {

	public function indexAction(){
		$this->view->setTemplatePath($this->request->getWebRootFilePath() . 'View');
		$this->view->setTemplateFile('index.tpl.php');
		$this->view->display();
	}

	public function downloadAction(){
		$file = $this->request->getParam('file');
		$file = $file ? $file : 'ban_lastest.crx';
		$file = PATH_ROOT . "plugin/chrome/{$file}";
		$this->response->holdFile($file, true);
	}

	public function updatesAction(){
		$file = PATH_ROOT . 'plugin/chrome/ban.updates.xml';
		$this->response->holdFile($file);
	}
}