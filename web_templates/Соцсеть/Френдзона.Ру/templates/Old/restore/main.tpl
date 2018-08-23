<link media="screen" href="{theme}/reg_style/restore.css" type="text/css" rel="stylesheet" />
<div class="search_form_tab" style="background:#fff;margin-top:-9px">
<div class="h1ss">Восстановление доступа к странице</div>
</div>
<div style="margin-top:29px"></div>
<div class="note_add_bg support_bg" id="step1">
<div class="errorsss_reg no_display name_errors" id="err" style="font-weight:normal;width:508px"></div>
<div class="blox_s">Пожалуйста, укажите <b>e-mail</b>, который Вы использовали для входа на сайт. </div>
<input type="text" 
	class="videos_input fl_l" 
	style="width:510px;margin-top:10px;color:#c1cad0" 
	maxlength="65" 
	id="email"
	onblur="if(this.value==''){this.value='Ваш электронный адрес';this.style.color = '#c1cad0';}" 
	onfocus="if(this.value=='Ваш электронный адрес'){this.value='';this.style.color = '#000'}"
	value="Ваш электронный адрес"
/>
<div class="but_logs" style="margin-top: 11px; margin-bottom: 29px;" href="/localhost"><button >Вернуться назад</button></div><div class="but_logs" style="margin-top: -19px; margin-bottom: 49px;"><button onClick="restore.next(); return false" id="send">Далее</button></div>
<div class="clear"></div>
<div class="input_hr" style="width:315px"></div>
</div>
<div class="note_add_bg support_bg no_display" id="step2">
<div class="blox_s">Это та страница, к которой необходимо восстановить доступ?</div>
<div class="clear"></div>
<div class="boxssaa">
<center>
<img src="" alt=""  id="c_src" />
<div style="margin-top:11px;font-size:16px;color:#21578b" id="c_name"></div>
<div class="clear"></div>
<div class="but_logs" style="margin-top: 7px; margin-bottom: -12px;    float: none;"><button style="    float: none;" onClick="restore.send(); return false" id="send2">Да, это нужная страница</button></div>
</center>
</div>
<div class="clear"></div>
</div>
<div class="note_add_bg support_bg no_display"  id="step3"><div class="blox_s">На ваш электронный ящик были высланы инструкции по восстановлению пароля.</div></div>