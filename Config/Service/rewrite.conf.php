<?php
return array(
	'/' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Service\Controller\HomeController',
				'action' => 'indexAction')),
		'param' => array()),
	'/([a-zA-Z]+)/?' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Service\Controller\$1Controller',
				'action' => 'indexAction'),
			'POST' => array(
				'controller' => '\Web\Service\Controller\$1Controller',
				'action' => 'indexAction'),
			'PUT' => array(
				'controller' => '\Web\Service\Controller\$1Controller',
				'action' => 'indexAction'),
			'DELETE' => array(
				'controller' => '\Web\Service\Controller\$1Controller',
				'action' => 'indexAction')),
		'param' => array()),
	'/([a-zA-Z]+)/([a-zA-Z]+)' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Service\Controller\$1Controller',
				'action' => '$2Action'),
			'POST' => array(
				'controller' => '\Web\Service\Controller\$1Controller',
				'action' => '$2Action'),
			'PUT' => array(
				'controller' => '\Web\Service\Controller\$1Controller',
				'action' => '$2Action'),
			'DELETE' => array(
				'controller' => '\Web\Service\Controller\$1Controller',
				'action' => '$2Action')),
		'param' => array()), 
/*end*/
);