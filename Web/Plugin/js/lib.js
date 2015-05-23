<?php if (is_file($this->js . 'lib.min.js')){include $this->js . 'lib.min.js';return;}?>
function until(func, interval, timeout, repeatInterval, repeatTimeout){
	func();
	interval = typeof interval == 'undefined' ? 300 : parseInt(interval);
	timeout = typeof timeout == 'undefined' ? 8000 : parseInt(timeout);
	if (typeof repeatInterval != 'undefined'){
		var repeat = true;
		repeatInterval = parseInt(repeatInterval);
		repeatTimeout = typeof repeatTimeout == 'undefined' ? 0 : parseInt(repeatTimeout);
	}
	var now = new Date().getTime();
	var i = setInterval(function(){
		if (timeout != 0 && new Date().getTime() > now + timeout){
			clearInterval(i);
			if (repeat){
				until(func, repeatInterval, repeatTimeout, repeatInterval);
			}
			return false;
		}
		var result = func();
		if (result){
			clearInterval(i);
			if (repeat){
				until(func, repeatInterval, repeatTimeout, repeatInterval);
			}
		}
	}, interval);
}
function checkKeywords(content){
	if (!keywords){
		console.log('no keywords');
		return false;
	}
	for (var i = 0; i < keywords.length; i++) {
		if (content.indexOf(keywords[i]) >= 0){
			return true;
		}
	};
	return false;
}