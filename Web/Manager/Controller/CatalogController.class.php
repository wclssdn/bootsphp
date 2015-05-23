<?php

namespace Web\Manager\Controller;

use Web\Manager\Base\Controller;

class CatalogController extends Controller {

	public function __construct(){
		parent::__construct();
		$this->view->setTemplatePath(PATH_ROOT . 'Web/Manager/View/Catalog');
	}

	public function indexAction(){
		$this->show();
	}
}