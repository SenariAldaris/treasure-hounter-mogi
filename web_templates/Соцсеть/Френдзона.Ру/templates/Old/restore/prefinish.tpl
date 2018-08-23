<link media="screen" href="{theme}/reg_style/restore.css" type="text/css" rel="stylesheet" />
<div class="search_form_tab" style="background:#fff;margin-top:-9px">
<div class="h1ss">Восстановление доступа к странице</div>
</div>
<div style="margin-top:29px"></div>
<div class="note_add_bg support_bg" id="step1">
<div style="width: 530px; margin-top: -23px; font-size: 14px;"><b>{name}</b>, в целях безопасности вашего аккаунта администрация <b>MixNet</b> рекомендует вам регулярно менять пароль. Эта процедура не займет у вас много времени, но значительно уменьшит риски доступа третьих лиц к вашей учетной записи. Для изменения пароля к аккаунту введите новый пароль в специальное поле под данным сообщением.</div>
<div class="errorsss_reg no_display name_errors" id="err" style="font-weight:normal;width:509px;margin-top:10px;margin-bottom:0px"></div>
<input type="password" 
	class="videos_input fl_l" 
	style="width:510px;margin-top:10px" 
	maxlength="65" 
	id="new_pass"
	placeholder="Новый пароль"
/>
<div class="clear"></div>
<div class="input_hr" style="width:315px"></div>
<input type="password" 
	class="videos_input fl_l" 
	style="width:510px" 
	maxlength="65" 
	id="new_pass2"
	placeholder="Повторите еще раз новый пароль"
/>
<input type="hidden" id="hash" value="{hash}" />
<div class="clear"></div>
<div class="input_hr" style="width:315px"></div>
<div class="but_logs"><button style="margin-top: 11px;" onClick="restore.finish(); return false" id="send">Сменить</button></div>
<div class="clear"></div>
</div>
<div class="note_add_bg support_bg no_display"  id="step2"><div class="blox_s"><b>{name}</b>, Ваш пароль был успешно изменён на новый, теперь Вы можете зайти на сайт используя новый пароль.</div></div>