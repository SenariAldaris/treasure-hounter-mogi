
<script type="text/javascript">
$(document).ready(function(){
	Xajax = new AjaxUpload('upload', {
		action: '/index.php?go=editapp&act=upload&id={id}',
		id:'{id}',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
		if (!(ext && /^(jpg|png|gif)$/.test(ext))) {
			Box.Info('load_photo_er', lang_dd2f_no, lang_bad_format, 400);
				return false;
			}
			butloading('upload', '113', 'disabled', '');
		},
		onComplete: function (file, response) {
			if(response == 'bad_format')
				$('.err_red').show().text(lang_bad_format);
			else if(response == 'big_size')
				$('.err_red').show().html(lang_bad_size);
			else if(response == 'bad')
				$('.err_red').show().text(lang_bad_aaa);
			else {
				Box.Close('photo');
				$('#apps_edit_img_small').html('<img src="'+response+'" alt="" />');
				$('#app_load_id').html('<img src="'+response+'" alt="" />');
				$('body, html').animate({scrollTop: 0}, 250);
				$('#del_pho_but').show();
				$("div#apps_edit_img_block_reload").load("# img#apps_img_reload");
			}
		}
	});
});
</script>

<div id="app_load_id"></div>

<div class="load_photo_pad">

<div class="err_red" style="display:none;font-weight:normal;"></div>

<div class="load_photo_but"><div class="button_div fl_l"><button id="upload">Выбрать фотографию</button></div></div>

<small>Файл не должен превышать 5 Mб. Если у Вас возникают проблемы с загрузкой, попробуйте использовать фотографию меньшего размера.</small>

</div>
