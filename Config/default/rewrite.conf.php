<?php
return array(
	'/' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Home\Controller\HomeController', 
				'action' => 'indexAction'), 
			'POST' => array(), 
			'PUT' => array(), 
			'DELETE' => array()), 
		'param' => array()), 
	'/([a-zA-Z]+)/?' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Home\Controller\$1Controller', 
				'action' => 'indexAction'), 
			'POST' => array(), 
			'PUT' => array(), 
			'DELETE' => array()), 
		'param' => array()), 
	'/([a-zA-Z\d]+)/([a-zA-Z\d]+)' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Home\Controller\$1Controller', 
				'action' => '$2Action'), 
			'PUT' => array(), 
			'DELETE' => array()), 
		'param' => array()), 
	'/(js|img|css)/[a-zA-Z-.]+\.(js|css|jpg|png|gif)' => array(
		'method' => array(
			'GET' => array(
				'file' => array(
					'path' => PATH_ROOT . 'Web/Public/',
					'cache' => array(
						'control' => '',
						'time' => 86400		
					),
				)
			)
		), 
		'param' => array()),
	'/404' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Home\Controller\HomeController',
				'action' => '___404___Action'),
			'POST' => array(),
			'PUT' => array(),
			'DELETE' => array()),
		'param' => array()),
/*end*/
);