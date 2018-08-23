<script type="text/javascript">
[new]var msg_num = parseInt($('#new_msg').text().replace(')', '').replace('(', ''))-1;
if(msg_num > 0)
	$('#new_msg').html("+"+msg_num);
else
	$('#new_msg').html('');[/new]

$(document).ready(function(){
	music.jPlayerInc();
	$('#msg_value').autoResize();
	$('#msg_value').focus();
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	vii_interval_im = setInterval('im.update()', 2000);
	music.jPlayerInc();
	$('.im_scroll').scroll(function(){
		if($('.im_scroll').scrollTop() <= ($('.im_scroll').height()/2)+250)
			im.page('{for_user_id}');
	});
});
func = function(val){
	document.getElementById('message_tab_frm').elements['msg_text'].focus();
	if(document.selection){
		document.getElementById('message_tab_frm').document.selection.createRange().text = document.getElementById('message_tab_frm').document.selection.createRange().text+val;
    } else if(document.getElementById('message_tab_frm').elements['msg_text'].selectionStart != undefined){
		var element = document.getElementById('message_tab_frm').elements['msg_text']; 
		var str = element.value; 
		var start = element.selectionStart; 
		var length = element.selectionEnd - element.selectionStart; 
		element.value = str.substr(0, start) + str.substr(start, length) + val + str.substr(start + length);
	} else {
		document.getElementById('message_tab_frm').elements['msg_text'].value += val; 
    }
}
</script>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="teck_prefix" value="" />
<div class="note_add_bg clear support_addform im_addform">
<div class="ava_mini_im">
 <a href="/u{myuser-id}" onClick="Page.Go(this.href); return false"><img src="{my-ava}" alt="" /></a>
</div>
<form id="message_tab_frm" name="ssm">
<textarea 
	class="ww_im" 
	id="msg_text" 
	style="height:38px"
	placeholder="Введите Ваше сообщение.."
	onKeyPress="
	 if(((event.keyCode == 13) || (event.keyCode == 10)) && (event.ctrlKey == false)) im.send('{for_user_id}', '{my-name}', '{my-ava}')
	 if(((event.keyCode == 13) || (event.keyCode == 10)) && (event.ctrlKey == true)) func('\r\n')
	"
	onKeyUp="im.typograf()"
></textarea>
</form>
<div class="clear"></div>
<div id="attach_files" class="no_display"></div>
<input id="vaLattach_files" type="hidden" />
<div class="clear"></div>
<div class="button_div_sends fl_r " style="margin-right: 10px;"><button onClick="im.send('{for_user_id}', '{my-name}', '{my-ava}')" id="sending">Отправить</button></div>
<div class="sdawfffffs" style="width: 538px;" id="wall_attach">
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addsmile()"><div class="img_smiles"></div>Смайлик</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addphoto()"><div class="img_photo"></div>Фотографию</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addvideo()"><div class="img_videos"></div>Видеозапись</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addaudio()"><div class="img_audios"></div>Аудиозапись</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addDoc()"><div class="img_files"></div>Документ</div>
</div> 
<div class="clear" style="margin-top:10px"></div>
<div class="clear"></div>
</div>
<input type="hidden" id="status_sending" value="1" />
<input type="hidden" id="for_user_id" value="{for_user_id}" />