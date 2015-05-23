<?php
return array(
	'/' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Parttime\Controller\HomeController',
				'action' => 'indexAction')),
		'param' => array()),
	'/([a-zA-Z]+)/?' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Parttime\Controller\$1Controller',
				'action' => 'indexAction'),
			'POST' => array(
				'controller' => '\Web\Parttime\Controller\$1Controller',
				'action' => 'indexAction')),
		'param' => array()),
	'/([a-zA-Z]+)/([a-zA-Z]+)' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Parttime\Controller\$1Controller',
				'action' => '$2Action'),
			'POST' => array(
				'controller' => '\Web\Parttime\Controller\$1Controller',
				'action' => '$2Action')),
		'param' => array()),
	'/(js|img|css)/[a-zA-Z-.]+\.(js|css|jpg|png|gif)' => array(
		'method' => array(
			'GET' => array(
				'file' => array(
					'path' => PATH_ROOT . 'Web/Public/',
					'cache' => array('control' => '','time' => 86400)))),
		'param' => array()),
/*end*/
);