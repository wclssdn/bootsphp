<?php if (is_file($this->js . 'keywords.js')){include $this->js . 'keywords.js';}?>
<?php include 'lib.js';?>
<?php if (is_file($this->js . 'weibo_com.min.js')){include $this->js . 'weibo_com.min.js';return;}?>
(function($) {
	// 发微博窗口下边广告
	$('#pl_content_biztips').remove();
	until(function(){
		//微博应用推广弹窗
		$('div[node-type="outer"][class="layer_tips layer_tips_version layer_tips_intro"]').remove();
		// 发布框内广告
		$('.send_success_travela').remove();
		// 右侧热门商品推荐	
		$('#pl_rightmod_ads36').remove();
		// 右侧广告 + 底部广告
		$('div[ad-data]').remove();
		//微博推广
		$('div[feedtype="ad"]').remove();
		//右侧会员专区会员动态
		$('#trustPagelet_recom_memberv5').remove();
		//开通会员提示
		$('div[node-type="feed_list_shieldKeyword"]').remove();
		//消息页右侧广告
		$('#pl_rightmod_ads35').remove();
		//聚导购·正在团
		$('div[node-type="feed_spread"]').remove();
		$('.WB_feed').children('div:not(".ban_checked")').each(function(i, d){
			$(d).addClass('ban_checked');
			var content = $(d).find('.WB_text').text();
			if (checkKeywords(content)){
				$(d).remove();
			}
		});
	}, 300, 9000, 500);
})(jQuery);