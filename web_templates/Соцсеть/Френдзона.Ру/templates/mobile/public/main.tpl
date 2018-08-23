<div class="pcont prof">
<div class="panel prof_panel">
<img class="u" align="left" src="{photo}">
<div class="cont">
<h2>{title}</h2>
<div class="status"><span id="traf">{num}</span> </div>
</div>
<div class="cb"></div>
<div class="btns list">
<div id="yes" class="{yes}"><button class="button" onClick="groups.login('{id}'); return false" style="width:100%">Подписаться</button></div>
<div id="no" class="{no}"><button class="button" onClick="groups.exit2('{id}', '{viewer-id}'); return false" style="width:100%">Отписаться</button></div>
<br>
</div>
</div>
<div class="upanel">
<div class="prof_info">
<h4>Информация</h4>
<div class="cont">
<div>
<dl class="pinfo">
<dt>О компании:</dt>
<dd>{descr}</dd>
</dl>
<dl class="pinfo">
<dt>Дата создания:</dt>
<dd>
{date}
</dd>
</dl>
</div>
</div>
</div>
<h4>
<span><b id="rec_num">41</b> запись</span>
<div class="cb"></div>
</h4>
[admin]<div class="post_add">
<form onblur="return false">
<div class="iwrap">
<textarea id="wall_text" class="wall_fast_text inp" placeholder="Что у Вас нового?"></textarea>
<button class="button" onClick="groups.wall_send('{id}'); return false">Отправить</button>
</div></form>
</div>
</div>[/admin]
<div id="public_wall_records">{records}</div>
<div class="clr"></div>
<div class="cursor_pointer {wall-page-display}" onClick="groups.wall_page('{id}'); return false" id="wall_all_records"><div class="photo_all_comm_bg" id="load_wall_all_records">к предыдущим записям</div></div>
<input type="hidden" id="page_cnt" value="1" />
<input type="hidden" id="public_id" value="{id}" />