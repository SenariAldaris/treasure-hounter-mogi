
<div id="page_tabs_bar_blue">

<a class="fm_none_href">

<div><b>Информация</b></div>

</a>

</div>

<div id="app_edit_cont">

<div class="app_edit_cont apps_edit_create" style="padding: 0 60px;">

<div class="apps_edit_header">Создание приложения</div>

<table class="apps_edit_table">

<tbody><tr><td align="center" class="label ta_r">Название:</td><td><input class="text" type="text" id="app_name"></td></tr>

</tbody></table>

<table id="app_type" class="apps_edit_table apps_create_type_select">

<tbody>
  
<tr><td class="label ta_r"></td><td class="apps_edit_rs">

<div id="app_type_2" class="radiobtn on" onclick="cur.checkAppType(2);"><div></div>IFrame/Flash приложение</div>

</td></tr>

</tbody></table>

<div id="apps_edit_iframe_options">

<table id="app_type" class="apps_edit_table">

<tbody><tr><td valign="bottom" class="label ta_r">Описание:</td><td><textarea class="text" id="app_desc"></textarea></td></tr></tbody>

</table>

<style>

/* RADIO BUTTON */

.settings_reason {padding: 2px 24px 0px 0px}

</style>

<table class="apps_edit_table">

<tbody>

<tr><td valign="center" class="label ta_r">Тип:</td>

<td><div class="radiobtn settings_reason fl_l" onclick="AppsEdit.changeReason_game(type1);">

<div></div>Игра

</div>

<div class="radiobtn settings_reason fl_l" onclick="AppsEdit.changeReason_apps(type2);">

<div></div>Приложение

</div></td></tr>

</tbody>

</table>

<table class="apps_edit_table">

<tbody><tr><td id="apps_name_cat" align="center" style="display:none;" class="label ta_r">Катигория:</td>

<td>

<div id="type1" style="display:none;">

<select id="category" class="inpst" style="width:260px">

<option value="0">Прочее</option>

<option value="1">Приключения</option>

<option value="2">Симуляторы</option>

<option value="3">Экономические</option>

<option value="4">Стратегии</option>

<option value="5">Логические</option>

<option value="6">Настольные</option>

<option value="7">Аркады</option>

</select>

</div>

<div id="type2" style="display:none;">

<select id="category" class="inpst" style="width:260px"> 

<option value="8">Прочее</option>

<option value="9">Общение</option>

<option value="10">Мультимедиа</option>

<option value="11">Рисование</option>

<option value="12">Образовательные</option>

<option value="13">Магазины</option>

<option value="14">Новостные</option>

</select>

</div>

</td>

</tr>

</tbody>

</table>


<div class="apps_edit_agree" style="margin-top: 15px;text-align: center;line-height: 22px;">Загружая приложение, Вы соглашаетесь с <br /><a class="fm_none_href" onclick="AppsEdit.showRulesBox();">правилами размещения приложений</a></div>

</div>

<table class="apps_edit_table">

<tbody><tr><td class="label ta_r"></td><td>

<div class="button_div fl_l" style="margin-top: 15px;"><button style="width: 259px;" onclick="AppsEdit.CreateApp();">Перейти к загрузке приложения</button></div>

</td></tr>

</tbody></table>

</div>

</div>