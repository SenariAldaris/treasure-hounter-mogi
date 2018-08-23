
<div id="page_tabs_bar_blue">

<a href="/editapp/info_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Информация</b>

</div>

</a>

<div class="page_tabs_active">

<a href="/editapp/options_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Настройки</b>

</div>

</a>

</div>

<a href="/editapp/payments_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Платежи</b>

</div>

</a>

<a href="/editapp/admins_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Администраторы</b>

</div>

</a>

<div class="fl_r">

<a href="/app{id}" onclick="return nav.go(this, event, {noback: true})">К приложению</a>

</div>

</div>

<div id="app_edit_cont_opt">

<div style="padding: 0 60px;">

<div id="apps_options_saved" class="apps_edit_success"></div>

<div class="apps_edit_top"></div>

<table class="apps_edit_table">

<tbody>

<tr>

<td class="label">ID приложения:</td>

<td class="apps_edit_t"> <b>{id}</b>

<input type="hidden" id="app_id" value="{id}">

<input type="hidden" id="app_hash" value="{hash}">

</td>

</tr>

<tr>

<td class="label">Защищенный ключ:</td>

<td class="apps_edit">

<input type="text" class="text" id="app_secret2" value="{secret}">

</td>

</tr>

</tbody>

</table>

<div style="">

<table class="apps_edit_table">

<tbody>

<tr>

<td class="label">Состояние:</td>

<td>

<select name="status" id="status"  class="inpst">{option}</select>

</td>

</tr>

</tbody>

</table>

</div>

<div id="apps_edit_container_opts" style="">

<div class="apps_edit_header">Настройки контейнера</div>

<table class="apps_edit_table">

<tbody>

<tr>

<td class="label">Тип приложения:</td>

<td>

<select id="type" name="type" class="inpst" onchange="AppsEdit.type()">{type} </select>

</td>

</tr>

</tbody>

</table>

<table id="apps_edit_iframe_options" class="apps_edit_table"  style="display: {siframe};">

<tbody>

<tr>

<td class="label">Адрес IFrame:</td>

<td>

<input class="text" type="text" id="app_iframe_url" value="{url}">

</td>

</tr>

<tr>

<td class="label">Размер IFrame:</td>

<td>

<input class="text text_small" type="text" id="app_iframe_width" value="{width}"> <span class="apps_edit_iframe_res">x</span>

<input class="text text_small" type="text" id="app_iframe_height" value="{height}">

</td>

</tr>

</tbody>

</table>

<div id="apps_edit_flash_options" style="display: {sflash};">

<div class="apps_edit_header">Загрузка SWF-приложения</div>

<table class="apps_edit_table">

<tbody><tr><td class="label"></td><td><a onclick="AppsEdit.updateSWF({id});" class="cursor_pointer">Загрузить приложение</a></td></tr>

</tbody></table>

</div>

</div>

<table id="apps_edit_save" class="apps_edit_table">

<tbody>

<tr>

<td class="label"></td>

<td>

<div class="button_div fl_l">

<button id="app_save_btn" onclick="AppsEdit.SaveOptions('save_options',{id});">Сохранить изменения</button>

</div>

<div id="app_save_info" style="padding: 5px; margin-left: 150px;"></div>

</td>

</tr>

</tbody>

</table>

</div>

</div>

<div class="apps_edit_other">

<center>

<div class="clear" style="margin: 10px 0;color: #2B587A;font-weight: bold;font-size: 14px;">Удаление приложения</div>

<div class="clear" style="margin:10px 0;">Если Вы удалите это приложение, Вы уже не сможете его восстановить.</div>

<div class="button_div">

<button id="app_save_btn" onclick="AppsEdit.DeleteApp({id});">Удалить приложение</button>

</div>

</center>

</div>
