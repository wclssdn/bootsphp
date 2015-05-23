<?php use BootsPHP\Util\TemplateHelper as H;?>
<!DOCTYPE html>
<html>
<head>
<title><?php H::S($title)?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL_STATIC?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="<?php echo URL_STATIC?>css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="<?php echo URL_STATIC?>css/main.css" rel="stylesheet" media="screen">
<script src="<?php echo URL_STATIC?>js/jquery.min.js"></script>
<script src="<?php echo URL_STATIC?>js/bootstrap.min.js"></script>
<?php if (isset($print)):?>
<script src="<?php echo URL_STATIC?>js/jquery.printThis.js"></script>
<link href="<?php echo URL_STATIC?>css/print.css" rel="stylesheet" media="print">
<?php endif;?>
</head>
<body>
	<div class="container">
		<div class="row-fluid header">
			<div class="span3">
				<div class="title">管理系统</div>
			</div>
			<div class="span3 pull-right text-right userinfo">
				<?php if (isset($user)):?>
				<div><?php H::S($user['name'])?>！您好！<a href="/User/logout">安全退出</a></div>
				<div>上次登录时间：<?php H::S($user['last_login_time'])?></div>
				<?php endif;?>
			</div>
		</div>
		<div class="row-fluid body">