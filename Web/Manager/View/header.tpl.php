<?php use BootsPHP\Util\TemplateHelper as H;?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo H::S('title');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL_STATIC;?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<style>
body {
	padding-top: 50px
}

.left-panel {
	position: fixed;
	top: 50px;
	padding-top: 20px;
}

.right-panel {
	padding-top: 20px;
}
</style>
</head>
<body>
	<nav class="navbar navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<a href="#" class="navbar-brand">BootsPHP</a>
		</div>
	</nav>
	<div class="col-lg-1 left-panel">
		<div class="panel">
			<div class="panel-heading">功能菜单</div>
			<ul class="list-group text-center">
				<li class="list-group-item"><a href="/manager/Catalog">分类管理</a></li>
				<li class="list-group-item"><a href="">文章管理</a></li>
				<li class="list-group-item"><a href="">标签管理</a></li>
				<li class="list-group-item"><a href="">图片管理</a></li>
				<li class="list-group-item"><a href="">用户管理</a></li>
				<li class="list-group-item"><a href="">分类管理</a></li>
			</ul>
		</div>
	</div>
	<div class="col-lg-11 pull-right right-panel">