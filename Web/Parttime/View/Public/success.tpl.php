<?php use BootsPHP\Util\TemplateHelper as H; ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo H::S($title, '提示信息 美丽说兼职平台');?></title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL_STATIC;?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<div class="alert alert-success text-center" style="margin: 100px auto; width: 50%; line-height: 30px; font-size: 14px">
	<?php echo $message;?>
	<?php if (isset($data['redirect'])):?>
		<br>
		<a href="<?php H::S($data['redirect'])?>" class="btn btn-info">确定</a>
	<?php else:?>
		<br>
		<a href="<?php if (isset($back)):?><?php H::S($back)?><?php else:?>javascript:history.back()<?php endif;?>" class="btn btn-warning">返回</a>
	<?php endif;?>
	</div>
	<script src="<?php echo URL_STATIC?>js/jquery.min.js"></script>
	<script src="<?php echo URL_STATIC?>js/bootstrap.min.js"></script>
</body>
</html>
