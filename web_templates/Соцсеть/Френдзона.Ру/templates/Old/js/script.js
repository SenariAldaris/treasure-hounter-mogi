$(document).ready(function(){
	var camera = $('#camera'),
	screen =  $('#screen');
	screen.html(
		webcam.get_html(screen.width(), screen.height())
	);
});