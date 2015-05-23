<?php use BootsPHP\Util\TemplateHelper as H;?>
<!DOCTYPE html>
<html>
<head>
<title><?php H::S('title')?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL_STATIC?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="<?php echo URL_STATIC?>css/public/main.css" rel="stylesheet" media="screen">
</head>
<body>
	<div class="navbar">
		<div class="container">
			<a class="navbar-brand" href="<?php echo URL_ROOT?>">BootsPHP</a>
			<ul class="nav navbar-nav col-md-10">
				<li class="active"><a href="<?php echo URL_ROOT?>">Home</a></li>
				<li><a href="#">Documents</a></li>
				<li><a href="#">About</a></li>
				<li><a href="http://blog.bootsphp.com" target="_blank">Blog</a></li>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="jumbotron">
			<h1>BootsPHP framework</h1>
			<p>a exquisite fast esay php framework</p>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="panel">
					<div class="panel-heading"><span class="glyphicon glyphicon-th-large"></span> Exquisite</div>
					<div class="panel-body">
					Usually, these calendars consist of lovely models with exquisite photography bringing them to life.
					</div>
				</div>
				<div class="panel">
					<div class="panel-heading"><span class="glyphicon glyphicon-fire"></span> Fast</div>
					<div class="panel-body">
					Consumers need all the help they can get, as their earnings aren't going up very fast.
					</div>
				</div>
				<div class="panel">
					<div class="panel-heading"><span class="glyphicon glyphicon-wrench"></span> Controllable</div>
					<div class="panel-body">
					But also, it was controllable.
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel">
					<div class="panel-heading"><span class="glyphicon glyphicon-plus"></span> Scalability</div>
					<div class="panel-body">
					They share your vision early, they see the opportunity and they see clearly where the scalability is.
					</div>
				</div>
				<div class="panel">
					<div class="panel-heading"><span class="glyphicon glyphicon-road"></span> Freedom</div>
					<div class="panel-body">
					Independence in carrying out the mandate is one thing; freedom to redefine it is another.
					</div>
				</div>
				<div class="panel">
					<div class="panel-heading"><span class="glyphicon glyphicon-heart"></span> Easy</div>
					<div class="panel-body">
					Consciousness isn't easy to define, but we know it when we experience it.
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">© BootsPHP 2013</div>
			</div>
		</div>
	</footer>
	<script src="<?php echo URL_STATIC?>js/jquery.min.js"></script>
	<script src="<?php echo URL_STATIC?>js/bootstrap.min.js"></script>
</body>
</html>