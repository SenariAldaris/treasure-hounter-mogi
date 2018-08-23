
<div id="page_tabs_bar_blue">

<div class="page_tabs_active">

<a href="/editapp/info_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Информация</b>

</div>

</a>

</div>

<a href="/editapp/options_{id}" onClick="Page.Go(this.href); return false;">

<div><b>Настройки</b>

</div>

</a>

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

<div id="app_edit_cont">

<div id="apps_options_saved" class="apps_edit_success"></div>

<table class="apps_edit_table apps_edit_info">

<tbody>

<td class="apps_edit_info_r" valign="top">

<tr>

<td class="apps_edit_label ta_r">Название:</td>

<td>

<input class="text" type="text" id="app_name" value="{title}">

</td>

</tr>

<tr>

<td class="apps_edit_label ta_r">Описание:</td>

<td>

<textarea class="text" id="app_desc">{desc}</textarea>

</td>

</tr>

<tr>

<td class="label ta_r"></td>

<td class="apps_edit_info_save">

<input type="hidden" id="app_id" value="{id}">

<input type="hidden" id="app_hash" value="{hash}">

<div class="button_div fl_l">

<button id="app_save_btn" onclick="AppsEdit.SaveOptions('save_info',{id});" style="width: 258px;">Сохранить изменения</button>

</div>

</td>

</tr>

</td>

</tbody>

</table>

<div class="clear" style="margin:20px 0;border-bottom: 1px solid #D5DBE4;;"></div>

<table class="apps_edit_table apps_edit_info">

<tbody>

<td>

<tr>

<td class="apps_edit_info_narrow">

<div id="apps_edit_img_block_reload" class="apps_edit_img_block">

<img id="apps_img_reload" src="{img}" align="left" id="apps_edit_img_small" class="apps_edit_img_small">


<div id="apps_edit_upload_small">

<div class="button_div fl_l">

<button onclick="AppsEdit.LoadPhoto({id}); $('.profileMenu').hide(); return false;">Выбрать файл</button>

</div>

</div>

</div>

</td>

</tr>

</td>

</tbody>

</table>

</div>
