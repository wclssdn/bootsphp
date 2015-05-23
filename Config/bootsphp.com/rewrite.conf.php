<?php
return array(
	'/' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Home\Controller\HomeController',
				'action' => 'indexAction'))),
	'/load\.js' => array(
		'method' => array(
			'GET' => array(
				'controller' => '\Web\Home\Controller\LoadController',
				'action' => 'indexAction'))), 
/*end*/
);