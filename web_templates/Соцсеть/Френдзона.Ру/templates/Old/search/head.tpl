<script type="text/javascript">
$(document).ready(function(){
	music.jPlayerInc();
	$('#speedbar').show();
	$('#speedbar').text(lang_search_user);
	$(window).unbind('scroll');
	[search-tab]$('#page').css('min-height', '444px');
	$(window).scroll(function(){
		if($(window).scrollTop() > 103)
			$('.search_sotrt_tab').css('position', 'fixed').css('margin-top', '-80px');
		else
			$('.search_sotrt_tab').css('position', 'absolute').css('margin-top', '39px');
	});[/search-tab]
	myhtml.checked(['{checked-online}', '{checked-user-photo}']);	
	var query = $('#query_full').val();
	if(query == 'Начните вводить любое слово или имя')
		$('#query_full').css('color', '#c1cad0');

	[search_js]window.search_loading = false;
	window.search_page = 1;

	$(window).scroll(function(){
		if (!search_loading && $(document).height() - ($(window).scrollTop() + $(window).height()) < 250) {
			search_loading = true;
			$('.search_loading').show();
			var query = decodeURI((RegExp('query=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
			$.post('/index.php?go=search&query=' + query + '&page=' + ++search_page, {"ajax": "yes"}, function(d){
				$('.friends_onefriend:last').after(d);
				search_loading = false;
				$('.search_loading').hide();
			});
		}
	});[/search_js]
	$(function(){
 if ($(window).scrollTop()>="700") $("#ToTop").fadeIn("fast")
 $(window).scroll(function(){
  if ($(window).scrollTop()<="700") $("#ToTop").fadeOut("fast")
   else $("#ToTop").fadeIn("slow")
 });
 $("#ToTop").click(function(){$("html,body").animate({scrollTop:0},"fast")})
});
});
</script>
<style type="text/css" media="all">
.box_sdsss {
width: 620px;
  background:#fff;
}
.active_search {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>
<div class="search_form_tabss" style="margin-bottom: 3px;">
<input type="text" value="{query}" class="fave_input" id="query_full" 
	onBlur="if(this.value==''){this.value='Начните вводить любое слово или имя';this.style.color = '#c1cad0';}" 
	onFocus="if(this.value=='Начните вводить любое слово или имя'){this.value='';this.style.color = '#000'}" 
	onKeyPress="if(event.keyCode == 13)gSearch.go();" 
	style="width:457px;margin:0px;color:#000" 
maxlength="65" />
<div class="button_div fl_r"><button onClick="gSearch.go(); return false">Поиск</button></div>
<div class="box_right_search" style=" margin-top: -41px;"> 
[yes]<div class="margin_top_10"></div><div class="search_result_title">Найдено {count}</div>[/yes]
 <div class="{activetab-1} news_a" style="width:172px;"><a style="width: 160px;" href="/?{query-people}" onClick="Page.Go(this.href); return false;"><div><b>Люди</b></div></a></div>
 <div class="{activetab-4} news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search{query-groups}" onClick="Page.Go(this.href); return false;"><div><b>Сообщества</b></div></a></div>
 <div class="{activetab-5} news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search{query-audios}" onClick="Page.Go(this.href); return false;"><div><b>Аудиозаписи</b></div></a></div>
 <div class="{activetab-2} news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search{query-videos}" onClick="Page.Go(this.href); return false;"><div><b>Видеозаписи</b></div></a></div>
 <div class="{activetab-3} news_a" style="width:172px;"><a style="width: 160px;" href="/?go=search{query-notes}" onClick="Page.Go(this.href); return false;"><div><b>Заметки</b></div></a></div>
  <div class="news_a" style="width:172px;"><a style="width: 160px;" href="/pins" onClick="Page.Go(this.href); return false;"><div><b>Стикеры</b></div></a></div>
</div>
<input type="hidden" value="{type}" id="se_type_full" />
</div>

[search-tab]<div class="search_sotrtS_tab">
   
 <div class="search_text_style">Основное</div>
 <div class="search_clear"></div>
   
 <div class="padstylej"><select name="country" id="country" class="inpsts search_sel" onChange="Profile.LoadCity(this.value); gSearch.go();"><option value="0">Любая страна</option>{country}</select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
 <div class="search_clear"></div>

 <div class="padstylej"><select name="city" id="select_city" class="inpsts search_sel" onChange="gSearch.go();"><option value="0">Любой город</option>{city}</select></div>
 <div class="search_clear"></div>
   <div class="seass_lcew">
 <div class="html_checkbox" id="online" onClick="myhtml.checkbox(this.id); gSearch.go();">сейчас на сайте</div>
 <div class="html_checkbox" id="user_photo" onClick="myhtml.checkbox(this.id); gSearch.go();" style="margin-top:9px">с фотографией</div>
 </div>
 <div class="search_clear"></div>
  <div class="search_text_style">Пол</div>

 <div class="search_clear"></div>
  
 <div class="padstylej"><select name="sex" id="sex" class="inpsts search_sel" onChange="gSearch.go();"><option value="0">Все</option>{sex}</select></div>
 <div class="search_clear"></div>
  <div class="search_text_style">День рождения</div>

 <div class="search_clear"></div>
 
 <div class="padstylej"><select name="day" class="inpsts search_sel" id="day" onChange="gSearch.go();"><option value="0">Любой день</option>{day}</select>
 <div class="search_clear"></div>
  
 <select name="month" class="inpsts search_sel" id="month" onChange="gSearch.go();"><option value="0">Любой месяц</option>{month}</select>
 <div class="search_clear"></div>
  
 <select name="year" class="inpsts search_sel" id="year" onChange="gSearch.go();"><option value="0">Любой год</option>{year}</select></div>
 <div class="search_clear"></div>
  
</div>[/search-tab]

<div class="clear"></div>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="0" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="teck_prefix" value="" />

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
.note_text {
    border-bottom: 1px solid #DBDBDB;
    margin-bottom: 0;
    overflow: hidden;
    width: 608px;
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

.footer {
    display: none;
}
</style>