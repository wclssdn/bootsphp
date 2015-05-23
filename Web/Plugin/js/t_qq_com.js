<?php if (is_file($this->js . 'keywords.js')){include $this->js . 'keywords.js';}?>
<?php include 'lib.js';?>
<?php if (is_file($this->js . 't_qq_com.min.js')){include $this->js . 't_qq_com.min.js';return;}?>
(function($) {
	/*** 他人首页 ***/
	$('#weibo_SJ_KF_F_banner').remove();
	/*** AT我的 ***/
	$('#weibo_SJ_TDWD_F_banner').remove();
	/*** 听众 ***/
	$('#weibo_N_SJ_TZY_TJPP').remove();
	/*** 收听 ***/
	$('#weibo_N_SJ_STY_TJPP').remove();
	/*** 我的收藏 ***/
	$('#weibo_SJ_SC_F_banner').remove();
	/*** 我的广播 ***/
	$('#weibo_SJ_WDGB_F_banner').remove();
	/*** 首页 ***/
	// 微博客户端二维码广告
	$('.erweimawrap').remove();
	until(function(){
		// 发微博窗口上方广告
		$('#talkBox').find('h2').empty().css('height', 10);
		$('#talkBox').find('style').empty();
		// 发微博窗口下方广告
		$('#homeBannerNew').remove();
		// 推荐收听
		$('#app_recStars').hide();
		// APP推广
		$('#app_ad').remove();
		// 右侧广告
		$('#app_ad3_1').remove();
		$('#sideBanner').remove();
		// 底部广告
		$('#weibo_F_banner_all').remove();
		/*** 单条微博页 ***/
		//底部广告
		$('#weibo_SJ_XXDC_F_banner').remove();
		// 右侧广告
		$('#app_ad2').remove();
		//话题页底部广告
		$('#weibo_SJ_HT_F_banner').remove();
	});
	until(function(){
		// 微博推广
		$('li[tv="2"]').remove();
		// 微博推荐
		$('li[tv="1"]').remove();
		// 转发的微博推广
		$('li[tv="0"]').remove();
		$('#talkList').children('li:not(".ban_checked")').each(function(i, d){
			$(d).addClass('ban_checked');
			var content = $(d).find('.msgCnt').text();
			if (checkKeywords(content)){
				$(d).remove();
			}
		});
		//话题页广告
		$('#app_adoldnob').remove();
		$('#app_adpkt').remove();
	}, 300, 90000, 800);
	// 查看大图右侧底部广告
	until(function(){
		 $('.pv-bottom-ads.clk-pv-link').empty();
	}, 300, 9000, 800);
})(jQuery);