
<div id="app{id}" class="apps_application">

<a class="apps_mr" onclick="Page.Go(this.href); return false" href="/app{id}">

<img class="fl_l" width="50" height="50" src="{ava}">

</a>

<a onclick="Page.Go(this.href); return false" href="/app{id}">{title}</a>

<div id="appsgan{id}" class="apps_fast_del fl_r cursor_pointer" onmouseover="myhtml.title('{id}', 'Удалить игру', 'appsgan')" onclick="apps.removeApp('{id}','{hash}')">

<img src="/images/close_a.png">

</div>

<div class="apps_num">{nums}</div>

<div class="clear"></div>

</div>
