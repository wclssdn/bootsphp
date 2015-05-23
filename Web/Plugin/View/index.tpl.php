<?php use BootsPHP\Util\TemplateHelper as H;?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo H::S('title');?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL_STATIC;?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/abcnfakceajflmfhnblejpkanbamcgog">
<style>
body {
	padding-top: 100px
}
</style>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="nav-header">
				<a class="navbar-brand" href="/">Ban!</a>
			</div>
			<?php /*?><div class="pull-right">
				<button type="button" class="btn btn-default navbar-btn">Register</button>
				<button type="button" class="btn btn-default navbar-btn">Login</button>
			</div>
			<?php */?>
		</div>
	</nav>
	<div class="container">

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="jumbotron">
					<div class="container">
						<h1>Ban! every thing you want!</h1>
						<p>A plugin for chrome</p>
						<p>
							<a class="btn btn-primary btn-lg" href="https://chrome.google.com/webstore/detail/ban/abcnfakceajflmfhnblejpkanbamcgog" target="_blank">View on Chrome Store</a>
							or
							<a class="btn btn-primary btn-lg" href="#" id="btn-install">Install</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo URL_STATIC?>js/jquery.min.js"></script>
	<script src="<?php echo URL_STATIC?>js/bootstrap.min.js"></script>
	<script>
		$('#btn-install').click(function(){
			chrome.webstore.install("https://chrome.google.com/webstore/detail/abcnfakceajflmfhnblejpkanbamcgog", function(){}, function(){alert('安装失败，请再次尝试（如果没翻墙，好像很难安上）');});
		});
	</script>
</body>
</html>