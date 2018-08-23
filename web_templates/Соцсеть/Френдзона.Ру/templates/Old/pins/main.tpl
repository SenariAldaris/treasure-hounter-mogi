<script type="text/javascript">
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

	$('#speedbar').show();
	$('#speedbar').text(lang_pins);
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
</script>
<style type="text/css" media="all">
.flwsss_lef {
    float: left;
    margin-left: 0;
    margin-top: 2px;
    min-height: 700px;
    padding-left: 0;
    width: 620px;
}

.portfolio-items li {
    display: inline-block;
    float: left;
    list-style: none outside none;
    margin: 3px 0 -1px 3px;
    position: relative;
}
.portfolio-items li img {
    display: block;
    height: 150px;
    width: 203px;
}.portfolio-items li:hover div.caption {
    height: 130px;
    opacity: 1;
    width: 183px;
}.portfolio-items li div.caption {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0.7);
    color: #FFFFFF;
    display: block;
    font-family: Arial,sans-serif;
    font-size: 11px;
    font-weight: 400;
    height: 130px;
    opacity: 0;
    overflow: hidden;
    padding: 10px;
    position: absolute;
    text-shadow: 1px 1px 1px #303857;
    transition: all 0.3s ease-in-out 0s;
    width: 183px;
}
.hint--bottom:before, .hint--bottom:after {
    display: none;
    left: 50%;
    top: 100%;
}
#footer {
    background: url("/templates/Old/images/head.png") repeat-x scroll 0 0 rgba(0, 0, 0, 0);
    bottom: 0;
    box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.52) inset;
    color: #FFFFFF;
    display: block;
    height: 30px;
    margin-bottom: 0;
    margin-left: 222px;
    padding-left: 10px;
    padding-top: 12px;
    position: relative;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
    width: 610px;
}

</style>
  <link rel="stylesheet" href="{theme}/pins/style.css">
<style type="text/css" media="all">
.box_sdsss {
width: 620px;
     background: none repeat scroll 0 0 #E9E9E9;
}</style>

<div class="search_form_tabss" style=" margin-top: -21px; float: left;">
<input type="text" value="{query}" class="fave_input fl_l" id="query_full" 
	onBlur="if(this.value==''){this.value='Начните вводить любое слово';this.style.color = '#c1cad0';}" 
	onFocus="if(this.value=='Начните вводить любое слово'){this.value='';this.style.color = '#000'}" 
	onKeyPress="if(event.keyCode == 13) pinsSearch();" 
	style="width:450px;margin:0px;color:#000" 
maxlength="40" />
<div class="button_div fl_r"><button onClick="pinsSearch(); return false">Поиск</button></div><div class="clear"></div>

</div>
<div class="box_right_search" style=" margin-top: -46px; margin-left: 620px;"> 
 <div class=" news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search&online=1" onClick="Page.Go(this.href); return false;"><div><b>Люди</b></div></a></div>
 <div class="news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search&type=4&query=" onClick="Page.Go(this.href); return false;"><div><b>Сообщества</b></div></a></div>
 <div class=" news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search&type=5&query=" onClick="Page.Go(this.href); return false;"><div><b>Аудиозаписи</b></div></a></div>
 <div class=" news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search&type=2&query=" onClick="Page.Go(this.href); return false;"><div><b>Видеозаписи</b></div></a></div>
 <div class=" news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search&type=3&query=" onClick="Page.Go(this.href); return false;"><div><b>Заметки</b></div></a></div>
 <div class="activetab news_a" style="width:172px;"><div class="news_a" style="width:172px;"><a style="width: 160px;" href="/pins" onClick="Page.Go(this.href); return false;"><div><b>Стикеры</b></div></a></div></div>
 <div class="bolxatyty">
 <div class="search_text_styles">Основное</div>
		<div class="{activetab-1} news_a" style="width: 170px;" id="all_pins"><a href="/pins" style="width: 160px;" onClick="Page.Go(this.href); return false"><div><b>Все стикеры</b></div></a></div>
		<div id="my_pins" style="width: 170px;" class="news_a" href="/"><a href="/" style="width: 160px;" onClick="myPins(); return false"><div><b>Мои стикеры</b></div></a></div>
		<a href="/" style="width: 160px;" onClick="pins.add_box(); return false"><div class="bt_add"><b>Добавить стикер</b></div></a>
  <div class="search_text_styles">Категории</div>
   <div class="bswwqqtyuio"> </div>
 <select  onChange="ChangePinsCategories(this.value)">{category}</select>
 </div> </div>
    <div id="container">
      <ul id="tiles" >
 <div id="search_block" >
 {pins} </div>  </ul> </div>