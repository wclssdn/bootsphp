$.get('http://plugin.bootsphp.com/background.js',function(data){
	$('body').append(data.message);
}, 'json');