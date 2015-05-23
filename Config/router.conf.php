<?php
/**
 * 文件格式
 * 域名(可用*匹配) => array(
 * 		filePath => string		*网站文件根路径
 * 		configPath => string	*网站配置文件根路径
 * 		urlPath => string		网站URL根路径 默认为/
 * 		autoload => array		网站自动加载规则
 * 		rewrite => array		网站URL重写规则
 * 		define => string		网站常量定义文件
 * )
 * 
 */
return array(
	'+.bootsphp.sinaapp.com' => array(
		'filePath' => PATH_ROOT . 'Web/Public/', 
		'configPath' => PATH_CONFIG . 'bootsphp.com/',
		/* end */
	), 
	'test.bootsphp.com' => array(
		'filePath' => PATH_ROOT . 'Web/TFIDF', 
		'define' => PATH_CONFIG . 'tfidf.com/define.inc.php', 
		'autoload' => include PATH_CONFIG . 'tfidf.com/autoload.conf.php',  // 提供autoload自动加载类可用的格式 ,根据上个path设置自动加载.
		'rewrite' => include PATH_CONFIG . 'tfidf.com/rewrite.conf.php',
		/* end */
		), 
	'plugin.bootsphp.com' => array(
		'filePath' => PATH_ROOT . 'Web/Plugin/', 
		'configPath' => PATH_CONFIG . 'plugin.bootsphp.com/',
		'define' => PATH_CONFIG . 'plugin.bootsphp.com/define.inc.php', 
		'autoload' => include PATH_CONFIG . 'plugin.bootsphp.com/autoload.conf.php',  // 提供autoload自动加载类可用的格式 ,根据上个path设置自动加载.
		'rewrite' => include PATH_CONFIG . 'plugin.bootsphp.com/rewrite.conf.php', 
		/* end */
	), 
	'*.bootsphp.com' => array(
		'filePath' => PATH_ROOT, 
		'configPath' => PATH_CONFIG . 'bootsphp.com/',
		'define' => PATH_CONFIG . 'bootsphp.com/define.inc.php', 
		'autoload' => include PATH_CONFIG . 'bootsphp.com/autoload.conf.php',  // 提供autoload自动加载类可用的格式 ,根据上个path设置自动加载.
		'rewrite' => include PATH_CONFIG . 'bootsphp.com/rewrite.conf.php', 
		/* end */
	), 
	'*' => array(
		'filePath' => PATH_ROOT . 'Web/Home/', 
		'configPath' => PATH_CONFIG . 'default/',
		'define' => PATH_CONFIG . 'default/define.inc.php', 
		'autoload' => include PATH_CONFIG . 'default/autoload.conf.php',  // 提供autoload自动加载类可用的格式 ,根据上个path设置自动加载.
		'rewrite' => include PATH_CONFIG . 'default/rewrite.conf.php', 
		/* end */
	),
/* end */
);
