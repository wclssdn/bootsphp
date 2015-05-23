<?php
return array(
	'/([a-z]+)/([a-z]+)\.(json|jsonp)' => array(
		'method' => array(
			'GET' => array(
				'c' => '$1Controller', 
				'a' => '$2Action', 
				'param' => array('format' => '$3', 'test' => 123)), 
			'POST' => array('c' => '$1Controller', 'a' => '$2Action'), 
			'PUT' => array('c' => '$1Controller', 'a' => '$2Action'), 
			'DELETE' => array('c' => '$1Controller', 'a' => '$2Action')), 
		'param' => array('format' => '$3')),
/*end*/
);