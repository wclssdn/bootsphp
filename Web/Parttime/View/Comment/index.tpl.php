<?php use BootsPHP\Util\TemplateHelper as H;?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo H::S($title);?></title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL_STATIC_CSS;?>bootstrap.min.css" rel="stylesheet" media="screen">
<link href="<?php echo URL_STATIC_CSS;?>comment.css" rel="stylesheet" media="screen">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<div class="container">
		<div class="col-sm-9">
			<iframe id="window"></iframe>
		</div>
		<div class="col-sm-3 right">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">提示信息</h3>
				</div>
				<div class="panel-body">
					<span class="text-info" id="message">您今天需要完成500条评论任务.<br>请点击开始工作按钮开始工作.<br>祝您工作愉快~</span>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">操作面板</h3>
				</div>
				<div class="panel-body">
					<div class="text-center">
						<a href="#" id="work" class="btn btn-primary">开始工作</a>
					</div>
					<div class="none">
						<form role="form">
							<div class="form-group">
								<label for="exampleInputEmail1">评论</label>
								<textarea rows="4" id="content" class="form-control" placeholder="评论内容. 不能少于8个字"></textarea>
							</div>
							<button type="button" class="btn btn-primary" id="comment">提交</button>
						</form>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">任务进度</h3>
				</div>
				<div class="panel-body">
					<div class="progress">
						<div class="progress-bar progress-bar-info" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"><span></span></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo URL_STATIC_JS?>jquery.min.js"></script>
	<script src="<?php echo URL_STATIC_JS?>bootstrap.min.js"></script>
	<script>
	var twitter_id = 0;
	//提示信息
	function message(msg, timeout){
		$('#message').text(msg);
		if(timeout){
			setTimeout(function(){
				$('#message').text('');
			}, timeout * 1000);
		}
	}
	function showTwitter(tid, shop){
		twitter_id = tid;
		if (tid == 0){
			$('#window').attr('src', '');
		}else{
			if (typeof shop != "undefined" && shop){
				$('#window').attr('src', 'http://www.meilishuo.com/share/item/' + tid);
			}else{
				$('#window').attr('src', 'http://www.meilishuo.com/share/' + tid);
			}
		}
	}
	//获取下一个待评论推
	function getTwitter(){
		$('#content').val('');
		showTwitter(0);
		$.getJSON('/Comment/getTwitter', function(data){
			twitter_id = 0;
			if (data.code == 0){
				message('请在下边操作面板内填写评论后提交');
				showTwitter(data.data.twitter_id, data.data.shop);
			}else{
				message(data.message);
			}
		});
	}
	//提交评论
	function comment(twitterId, content){
		message('提交评论中...');
		$.post('/Comment/comment', {twitter_id:twitterId, content:content}, function(data){
			if (data.code == 0){
				message('评论提交成功... 正在获取下一个...', 5);
				getTwitter();
				getStatistics();
			}else{
				message(data.message);
			}
		}, 'json');
	}
	//设置统计进度条
	function setStatistics(statistics){
		var p = statistics.today / statistics.goal * 100;
		p = Math.min(p, 100);
		$('#progress').css('width', p + '%');
		var css = {};
		var w = $('#progress').parent().width() * p / 100;
		if (w <= 50){
			css.color = '#428bca';
			css['padding-left'] = w + 3;
		}
		$('#progress').children('span').css(css).text(statistics.today + '/' + statistics.goal);;
	}
	//获取统计
	function getStatistics(){
		$.getJSON('/Comment/getStatistics', function(data){
			if (data.code == 0){
				setStatistics(data.data);
			}else{
				message('' + data.message);
			}
		});
	}
	//自动调整高度
	$('#window').height($(window).height() - 10);
	//开始工作
	$('#work').click(function(){
		var t = $(this);
		var p = t.parent();
		p.hide();
		p.next().show();
		message('正在获取宝贝数据...');
		getTwitter();
	});
	//提交评论
	$('#comment').click(function(){
		if (!twitter_id){
			message('请刷新页面,重新开始工作');
			return false;
		}
		comment(twitter_id, $('#content').val());
	});
	$(function(){
		//获取统计
		getStatistics();
	});
	</script>
</body>
</html>