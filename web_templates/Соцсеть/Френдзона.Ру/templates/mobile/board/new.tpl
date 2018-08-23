<script type="text/javascript">
$(document).ready(function(){
	$('#title_n').focus();
});
</script>
<div class="search_form_tab" style="margin-top:-9px;background:#fff">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:31px">
  <a href="/public{id}" onClick="Page.Go(this.href); return false;"><div><b>К публичной странице</b></div></a>
  <a href="/board/{id}" onClick="Page.Go(this.href); return false;"><div><b>Обсуждения</b></div></a>
  <div class="buttonsprofileSec"><a href="/board/new/{id}" onClick="Page.Go(this.href); return false;"><div><b>Новая тема</b></div></a></div>
 </div>
</div>
<div class="clear"></div>
<div class="note_add_bg">
<div class="videos_text">Заголовок</div>
<input type="text" class="videos_input" style="width:700px" maxlength="65" id="title_n" />
<div class="input_hr"></div>
<div class="videos_text">Текст</div>
<textarea class="videos_input wysiwyg_inpt" id="text" style="height:200px"></textarea>
<div class="clear"></div>
<div id="attach_files" class="no_display"></div>
<input id="vaLattach_files" type="hidden" />
<div class="clear"></div>
<div class="button_div fl_l margin_top_10"><button onClick="Forum.New('{id}'); return false" id="forum_sending">Создать тему</button></div>
<div class="clear"></div>
</div>