<?php include 'lib.js';?>
<?php if (is_file($this->js . 'all_sites.min.js')){include $this->js . 'weibo_com.min.js';return;}?>
(function($) {
	until(function(){
		//百度广告
		$('div[id^="BAIDU_DUP_wrapper_"]').remove();
		$('#cproIframe1holder').remove();
		$('#cproIframe2holder').remove();
	}, 10, 1000, 100, 5000);
})(jQuery);