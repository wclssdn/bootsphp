<script>
<?php include __DIR__ . '/js/lib.js';?>
holdMessage('getStatus', function(data){
	return getStatus();
});
chrome.webRequest.onBeforeRequest.addListener(
	function(details) {
		if (details.url.indexOf("http://pingjs.qq.com/ping.js") != -1){
			return {cancel : true};
		}
		if (details.url.indexOf("http://cpro.baidu.com/cpro/ui/c.js") != -1){
			return {cancel : true};
		}
		if (details.url.indexOf("http://cpro.baidustatic.com/cpro/ui/c.js") != -1){
			return {cancel : true};
		}
		if (details.url.indexOf("http://cpro.baidustatic.com/cpro/ui/f.js") != -1){
			return {cancel : true};
		}
		return {cancel : false};
	},
	{urls : [ "<all_urls>" ]}, 
	[ "blocking" ]);
</script>