<?php
return array(
	'/' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Plugin\Controller\HomeController', 
				'action' => 'indexAction'))), 
	'/download/?([a-z\d._]+\.crx)?' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Plugin\Controller\HomeController', 
				'action' => 'downloadAction', 
				'param' => array('file' => '$1')))), 
	'/updates\.xml/?' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Plugin\Controller\HomeController', 
				'action' => 'updatesAction'))), 
	'/(ban|popup|options|background)\.js' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Plugin\Controller\ExtensionController', 
				'action' => '$1Action'))), 
	'/(login|register|logout|isLogin|reLogin)' => array(
		'method' => array(
			'POST' => array(
				'controller' => '\Web\Plugin\Controller\UserController', 
				'action' => '$1Action'))), 
	'/(getOptions)' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Plugin\Controller\UserController', 
				'action' => '$1Action'))),
/*end*/
);