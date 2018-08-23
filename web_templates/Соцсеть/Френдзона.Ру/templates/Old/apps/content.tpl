<script type="text/javascript">

var page_cnt_app = 1;
var page_cnt_app_old = 1;

var apphre = req_href.split('apps?i=');
if(apphre[1]) apps.view(apphre[1], req_href, '/apps');

$(window).scroll(function(){
	if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
		apps.showMore();
	}
});

$(document).ready(function(){

$('.fm-class_content').css('max-width', '850px');

$('.fm-index_format, .fm-footer').css('width', '850px');

$('#search_display, .fm-nav, #ads_no_remove').hide();

$('#navappeid').append('<div id="navigator_appen"></div>');

$('#navigator_appen').append('<ul class="fm-nav">'+

'<li id="nav-page" class="fm-navAct"><a href="/{user-id}" onclick="Page.Go(this.href); clear_style(); return false;">Моя страница</a></li>'+

'<li id="app_home-page"><a class="css_load" href="/apps" onclick="Page.Go(this.href); return false;">Главная</a></li>'+

'<div class="apps_app_nav">Игры</div>'+

'<li id="app_default-page"><a class="css_load" href="/apps/appcenter/category/0" onclick="Page.Go(this.href); return false;">Прочее</a></li>'+

'<li id="app_educational-page"><a href="/apps/appcenter/category/1" onclick="Page.Go(this.href); return false;">Приключения</a></li>'+

'<li id="app_simulation-page"><a href="/apps/appcenter/category/2" onclick="Page.Go(this.href); return false;">Симуляторы</a></li>'+

'<li id="app_finance-page"><a href="/apps/appcenter/category/3" onclick="Page.Go(this.href); return false;">Экономические</a></li>'+

'<li id="app_strategy-page"><a href="/apps/appcenter/category/4" onclick="Page.Go(this.href); return false;">Стратегии</a></li>'+

'<li id="app_logic-page"><a href="/apps/appcenter/category/5" onclick="Page.Go(this.href); return false;">Логические</a></li>'+

'<li id="app_platform-page"><a href="/apps/appcenter/category/6" onclick="Page.Go(this.href); return false;">Настольные</a></li>'+

'<li id="app_arcade-page"><a href="/apps/appcenter/category/7" onclick="Page.Go(this.href); return false;"><div>Аркады</div></a></li>'+

'<div class="apps_app_nav">Приложения</div>'+

'<li id="app_default-page"><a class="css_load" href="/apps/appcenter/category/8" onclick="Page.Go(this.href); return false;">Прочее</a></li>'+

'<li id="app_communication-page"><a href="/apps/appcenter/category/9" onclick="Page.Go(this.href); return false;">Общение</a></li>'+

'<li id="app_multimedia-page"><a href="/apps/appcenter/category/10" onclick="Page.Go(this.href); return false;">Мультимедиа</a></li>'+

'<li id="app_drawing-page"><a href="/apps/appcenter/category/11" onclick="Page.Go(this.href); return false;">Рисование</a></li>'+

'<li id="app_educational-page"><a href="/apps/appcenter/category/12" onclick="Page.Go(this.href); return false;">Образовательные</a></li>'+

'<li id="app_shop-page"><a href="/apps/appcenter/category/13" onclick="Page.Go(this.href); return false;">Магазины</a></li>'+

'<li id="app_news-page"><a href="/apps/appcenter/category/14" onclick="Page.Go(this.href); return false;">Новостные</a></li>'+

'</ul>');

});

</script>

<div id="apps_page">

<div class="apps_side">

<img src="/images/loading_mini.gif" class="fl_r no_display" id="apps_se_load" style="margin-left:632px;margin-top:10px;position:absolute" />

<input type="text" value="Поиск по играм" class="fave_input" id="query_application" 

	onBlur="if(this.value==''){this.value='Поиск по играм';this.style.color = '#c1cad0';}" 

	onFocus="if(this.value=='Поиск по играм'){this.value='';this.style.color = '#000'}" 

	onKeyPress="if(event.keyCode == 13)gSearch.go();"

	onKeyUp="apps.gSearch()"

	style="width:663px;margin:0px;color:#c1cad0" 

	maxlength="65" />

</div>

<div id="apps_rows">

<div class="appsslider">

<div class="apps_title">Рекомендуемые приложения</div>

<div class="apps_sider_recommen">

{slider}

<div class="clear"></div>

</div>

</div>

<div class="clear"></div>

<div id="apps_all">

<div class="apps_block" style="margin-right:20px">

<div class="apps_title">Мои игры</div>

<div id="apps_my_application">

{my_application}

</div>

</div>

<div class="apps_block">

<div class="apps_title">Активность друзей</div>

<div id="apps_activity">

{friends_application}

</div>

</div>

<div class="clear" style="height:20px"></div>

<div class="apps_add_more apps_but cursor_pointer" onClick="apps.showMoreOld()">

<span id="apps_text_load_old">Показать больше приложений</span>

</div>

<div class="apps_block" style="margin-right:20px">

<div class="apps_top">Популярные</div>

<div id="apps_pop">

{popular_application}

</div>

</div>

<div class="apps_block"> 

<div class="apps_top">Новые</div>

<div id="apps_new">

{newapplication}

<div class="clear"></div>

</div>

</div>

<div class="clear" style="height:20px"></div>

<div class="apps_add_more apps_but2 cursor_pointer" onClick="apps.showMore()">

<span id="apps_text_load">Показать больше приложений</span>

</div>

</div>

<div id="apps_search" class="no_display">

<div class="apps_title">Найденые игры</div>

<div id="apps_search_res"></div>

</div>

</div>

<div class="clear"></div>

</div>