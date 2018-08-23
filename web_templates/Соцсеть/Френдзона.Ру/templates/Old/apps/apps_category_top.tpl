
<script>

$(document).ready(function(){

$('.fm-menu').show(); 

$('#navigator_appen').show(); 

$('.fm-class_content').css('max-width', '850px');

$('.fm-index_format, .fm-footer').css('width', '850px');

$('#search_display, .fm-nav, #ads_no_remove').hide();

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

<div class="fm_wrap_bar" id="fm_wrap_bar" style="display: block;">{summary}</div>

<div id="page_rows_summary" class="summary_wrap"><div class="summary">Всего {summary_num}</div></div>
