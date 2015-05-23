function sendMessage(action, data, func){
	if (typeof data == 'undefined'){
		data = {};
		func = function(){};
	}
	if (typeof func == 'undefined' && typeof data == 'function'){
		func = data;
		data = {};
	}
	chrome.runtime.sendMessage({action:action, data:data}, func);
}
function sendMessageToScript(action, data, func){
	chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
		chrome.tabs.sendMessage(tabs[0].id, {action:action, data:data}, func);
	});
}
function holdMessage(action, func){
	chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
		if (request.action == action){
			sendResponse(func(request.data));
		}
	});
}
function toast(text){
	$("body").cftoaster({content:text});
};
function getStatus(){
	var status = window.localStorage.getItem('status');
	if (status != null){
		return Boolean(parseInt(status));
	}
	return true;
}
function setStatus(status){
	status = status ? 1 : 0;
	window.localStorage.setItem('status', status);
}
function changeStatus(status){
	if (typeof status == "undefined"){
		status = getStatus();
	}
	setStatus(!status);
}
function login(user){
	window.localStorage.user = JSON.stringify(user);
}
function logout(){
	window.localStorage.removeItem('user');
}
function getLoginUser(){
	try{
		return $.parseJSON(window.localStorage.user);
	}catch(e){
		return false;
	}
}
function isLogin(real){
	try{
		if (typeof window.localStorage.user !== 'undefined' && $.parseJSON(window.localStorage.user)){
			if (real){
				$.post('http://plugin.bootsphp.com/isLogin', function(data){
					if (data.code == 0){
						sendMessageToScript('isLogin', true);
					}else{
						var user = getLoginUser();
						$.post('http://plugin.bootsphp.com/reLogin', {sign:user.sign}, function(data){
							if (data.code == 0){
								login(data.data);
								sendMessageToScript('isLogin', true);
							}else{
								logout();
								sendMessageToScript('isLogin', false);
								return false;
							}
						}, 'json');
					}
				}, 'json');
			}
			return true;
		}
	}catch (e){
		logout();
	}
	if (real){
		sendMessageToScript('isLogin', false);
	}
	return false;
}
