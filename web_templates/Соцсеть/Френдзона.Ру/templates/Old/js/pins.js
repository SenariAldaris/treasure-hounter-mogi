$(document).ready(function(){
	var query = $('#query_full').val();
	if(query == 'Начните вводить любое слово')
		$('#query_full').css('color', '#c1cad0');
		
	var search_loading = true;
	var search_page = 0;
	var pins_search_status = true;

	if (!search_loading && $(document).height() - ($(window).scrollTop() + $(window).height()) < 500) {
		search_loading = true;
		if(query == 'Начните вводить любое слово') var query_post = '';
		else var query_post = query;
		$.post('/index.php?go=pins', {page_cnt: search_page, query: query_post, doload: 1}, function(d){
			search_page++;
			$('.pin_block:last').after(d);
		});
		    $('#tiles').imagesLoaded(function() {
      var options = {
        autoResize: true,
        container: $('#container'),
        offset: 6,
        itemWidth: 199
      };
      var handler = $('#tiles li');
      handler.wookmark(options);
    });
		search_loading = false;
	}

});
var pins_category = 0;
var pins_my_active = false;
function pinsSearch(){
	var text = $('#query_full').val();
	if(text == 'Начните вводить любое слово') text = '';
	if(text) var doload = 0;
	else var doload = 1;
	$.post('/index.php?go=pins', {query: text, doload: doload, cat: pins_category}, function(d){
		$('#search_block').html(d);
		    $('#tiles').imagesLoaded(function() {
      var options = {
        autoResize: true,
        container: $('#container'),
        offset: 6,
        itemWidth: 199
      };
      var handler = $('#tiles li');
      handler.wookmark(options);
    });
	});
}
function myPins(){
	$.post('/index.php?go=pins', {my: 1, cat: pins_category}, function(d){
		pins_my_active = true;
		$('#search_block').html(d);
		$('#all_pins').removeClass('activetab');
		$('#my_pins').addClass('activetab');
		    $('#tiles').imagesLoaded(function() {
      var options = {
        autoResize: true,
        container: $('#container'),
        offset: 6,
        itemWidth: 199
      };
      var handler = $('#tiles li');
      handler.wookmark(options);
    });
	
	});
}
function ChangePinsCategories(val){
	pins_category = val;
	var text = $('#query_full').val();
	if(text == 'Начните вводить любое слово') text = '';
	if(text) var doload = 0;
	else var doload = 1;
	$.post('/index.php?go=pins', {cat: pins_category, c_change: 1, query: text, my: pins_my_active}, function(d){
		$('#search_block').html(d);
						    $('#tiles').imagesLoaded(function() {
      var options = {
        autoResize: true,
        container: $('#container'),
        offset: 6,
        itemWidth: 199
      };
      var handler = $('#tiles li');
      handler.wookmark(options);
    });
	});
}
