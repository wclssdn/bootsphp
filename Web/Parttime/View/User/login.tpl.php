<?php use BootsPHP\Util\TemplateHelper as H;?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo H::S($title);?></title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL_STATIC;?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<style>
body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #eee;
}

.form-signin {
	max-width: 330px;
	padding: 15px;
	margin: 0 auto;
}

.form-signin .form-signin-heading,.form-signin .checkbox {
	margin-bottom: 10px;
}

.form-signin .checkbox {
	font-weight: normal;
}

.form-signin .form-control {
	position: relative;
	font-size: 16px;
	height: auto;
	padding: 10px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

.form-signin .form-control:focus {
	z-index: 2;
}

.form-signin input[type="text"] {
	margin-bottom: -1px;
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0;
}

.form-signin input[type="password"] {
	margin-bottom: 10px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
}
</style>
</head>
<body>
	<div class="container">
		<form class="form-signin" role="form" method="post">
			<h2 class="form-signin-heading">请先登陆</h2>
			<input type="text" name="username" class="form-control" placeholder="用户名" required autofocus> <input type="password" name="password" class="form-control" placeholder="密码" required>
			<label class="checkbox">
				<input type="checkbox" name="remember" value="1"> 7天内自动登陆
			</label>
			<input type="hidden" name="backurl" value="<?php H::S($backurl);?>">
			<button class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>
		</form>
	</div>
	<!-- /container -->
	<script src="<?php echo URL_STATIC?>js/jquery.min.js"></script>
	<script src="<?php echo URL_STATIC?>js/bootstrap.min.js"></script>
</body>
</html>