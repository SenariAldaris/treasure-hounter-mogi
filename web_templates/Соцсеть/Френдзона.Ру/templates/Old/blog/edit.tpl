<script type="text/javascript" src="{theme}/js/upload.photo.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	Xajax = new AjaxUpload('bb_photo_1', {
		action: '/index.php?go=blog&act=upload',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if (!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
				addAllErr(lang_bad_format, 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, response){
			if(response == 'big_size'){
				addAllErr(lang_max_size, 3300);
				Page.Loading('stop');
			} else {
				bbcodes.tag('[img]', '[/img]', response);
				Page.Loading('stop');
			}
		}
	});
});
</script>
<div class="clear_top"></div>
<div class="box_newx"></div>
<div class="box_right_owne" style="position: absolute;margin-top: -8px;  background: none repeat scroll 0 0 rgba(0, 0, 0, 0); border-left: 5px solid rgba(0, 0, 0, 0);">

 <div class="news_text">Меню</div>
  <div class="activetab news_a"><a onclick="Page.Go(this.href); return false" href="?act=edit&id=4">Редактировать новость</a></div>
    <div class=" news_a"><a href="/blog" onClick="Page.Go(this.href); return false">Вернуться назад</a></div>

</div>
<form method="POST" action="" name="entryform">
<div class="note_add_bg">
<div class="videos_text">Заголовок</div>
<input type="text" class="videos_input" style="width:500px" maxlength="65" id="title" value="{title}" />
<div class="input_hr"></div>
<div class="videos_text">Текст</div>
<div class="wysiwyg_bbpanel" style="width:502px;">
 <div onClick="bbcodes.tag('[b]', '[/b]')" class="wysiwyg_icbold cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', 'Жирный', 'bb_bold_', '0')" id="bb_bold_1"></div>
 <div onClick="bbcodes.tag('[i]', '[/i]')" class="wysiwyg_ici cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', 'Курсивный', 'bb_i_', '0')" id="bb_i_1"></div>
 <div onClick="bbcodes.tag('[u]', '[/u]')" class="wysiwyg_icunderline cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', 'Подчеркнутый', 'bb_underline_', '0')" id="bb_underline_1"></div>
 <div onClick="bbcodes.tag('[left]', '[/left]')" class="wysiwyg_icpleft cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', 'Выровнять по левому краю', 'bb_pleft_', '0')" id="bb_pleft_1"></div>
 <div onClick="bbcodes.tag('[center]', '[/center]')" class="wysiwyg_icpcenter cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', 'Выровнять по центру', 'bb_pcenter_', '0')" id="bb_pcenter_1"></div>
 <div onClick="bbcodes.tag('[right]', '[/right]')" class="wysiwyg_icpright cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', 'Выровнять по правому краю', 'bb_pright_', '0')" id="bb_pright_1"></div>
 <div onClick="bbcodes.tag('[quote]', '[/quote]')" class="wysiwyg_icquote cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', 'Добавить цитату', 'bb_quote_', '0')" id="bb_quote_1"></div>
 <div class="wysiwyg_icphoto cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', 'Добавить фотографию', 'bb_photo_', '0')" id="bb_photo_1"></div>
 <!--<div class="wysiwyg_icvideo cursor_pointer border_radius_3" onClick="wall.attach_addvideo(false, false, 1)" onMouseOver="myhtml.title('1', 'Добавить видеозапись', 'bb_video_', '0')" id="bb_video_1"></div>-->
 <div class="wysiwyg_iclink cursor_pointer border_radius_3" onClick="wysiwyg.linkBox()" onMouseOver="myhtml.title('1', 'Добавить ссылку', 'bb_link_', '0')" id="bb_link_1"></div>
 <div class="clear"></div>
</div>
<textarea class="videos_input wysiwyg_inpt" id="text" name="text">{story}</textarea>
<div class="clear"></div>
<div class="button_div fl_l"><button onClick="blog.save('{id}'); return false" id="notes_sending">Сохранить</button></div>
<div class="clear"></div>
</div>
</form>