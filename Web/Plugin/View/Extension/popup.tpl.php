<style>
<?php include __DIR__ . '/css/popup.css';?>
<?php include __DIR__ . '/css/toaster.css';?>
</style>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">插件状态</h3>
  </div>
  <div class="panel-body"><span id="text-cuttent-status"></span> <button type="button" id="btn-status" class="btn btn-xs btn-warning">停用</button></div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">作者微博</h3>
  </div>
  <div class="panel-body">
  	<a href="http://weibo.com/178880888" target="_blank">新浪微博</a>
	<a href="http://t.qq.com/wclssdn" target="_blank">腾讯微博</a>
  </div>
</div>
<script>
<?php include __DIR__ . '/js/lib.js';?>
<?php include __DIR__ . '/js/toaster.min.js';?>
function initStatus(){
	var status = getStatus();
	if (status){
		$('#text-cuttent-status').removeClass('text-warning').addClass('text-success').text('启用');
		$('#btn-status').removeClass('btn-success').addClass('btn-warning').text('停用');
	}else{
		$('#text-cuttent-status').removeClass('text-success').addClass('text-warning').text('停用');
		$('#btn-status').removeClass('btn-warning').addClass('btn-success').text('启用');
	}
}
initStatus();
$('#btn-status').click(function(){
	changeStatus();
	initStatus();
	toast('刷新页面后生效');
});
</script>