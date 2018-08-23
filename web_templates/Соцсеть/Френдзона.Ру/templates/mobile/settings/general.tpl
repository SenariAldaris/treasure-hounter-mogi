<div id="page" class="mcont">
				<div class="pcont settings">
<div class="upanel bli_cont">
<div class="clr"></div>
<div class="margin_top_10"></div>

<h4>Изменение пароля</h4>
<form onblur="return false;">
<div class="cont bli">
<dl>

<div style="padding:10px">
<div class="infobl err_red no_display pass_errors" id="err_pass_1" style="font-weight:normal;">Пароль не изменён, так как прежний пароль введён неправильно.</div>
<div class="infobl err_red no_display pass_errors" id="err_pass_2" style="font-weight:normal;">Пароль не изменён, так как новый пароль повторен неправильно.</div>
<div class="m"><div class="infobl err_yellow no_display pass_errors" id="ok_pass">Пароль успешно изменён.</div></div>
<dt>Старый пароль:</dt>
<input type="password" id="old_pass" class="text" maxlength="100" /><span id="validOldpass"></span>

<dt>Новый пароль:</dt>
<input class="text" type="password"  id="new_pass"><span id="validNewpass"></span>

<dt>Повторите пароль:</dt>
<input class="text" type="password"  id="new_pass2"><span id="validNewpass2"></span>

<button onClick="settings.saveNewPwd(); return false" id="saveNewPwd" class="button" style="margin-top:10px">Изменить пароль</button>
</div>
</div></div>
</form>
<div class="margin_top_10"></div>
<h4>Изменение имени</h4>
<form onblur="return false;">
<div class="cont bli">
<div style="padding:10px">
<div class="infobl err_red no_display name_errors" id="err_name_1" style="font-weight:normal;">Специальные символы и пробелы запрещены.</div>
<div class="infobl err_yellow no_display name_errors" id="ok_name" style="font-weight:normal;">Изменения успешно сохранены.</div>
<dt>Ваше Имя:</dt>
<input class="text" type="text"  id="name" value="{name}"/><span id="validName"></span>

<dt>Ваша Фамилия:</dt>
<input class="text" type="text" id="lastname" value="{lastname}"/><span id="validLastname"></span>
<button onClick="settings.saveNewName(); return false" id="saveNewName" class="button" style="margin-top:10px">Изменить имя</button></div>