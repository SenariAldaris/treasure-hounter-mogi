<script type="text/javascript">
$(document).ready(function(){
	Xajax = new AjaxUpload('upload', {
		action: '/index.php?go=editprofile&act=upload',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
		if (!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
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
				$('#ava').html('<img  class="ava_style" src="'+response+'" alt="" />');
				$('body, html').animate({scrollTop: 0}, 250);
				$('#del_pho_but').show();
			}
		}
	});
});
</script>

<div class="load_photo_pad">
<div class="err_red" style="display:none;font-weight:normal;"></div>
 <div class="photo_bg_loassdadadd">  <img src="{ava_load}"  class="photo_bg_load" />
 </div>


  <div class="photo_bg_load_text">
<h4>Зачем нужна фотография?</h4>
<p class="ta-l">
— Людям с реальной фотографией пишут чаще;
<br>
— Ваши друзья смогут легко узнать вас;
<br>
— Без фото вас не смогут найти и увидеть другие люди.
</p></div>
<div class="load_photo_but"><div class="button_div fl_l"><button style="width: 192px;" id="upload">Выбрать фотографию</button></div>
</div>

</div>
<a href="#" onclick="diplay_hide('#block_id');return false;"><div class="photo_bg_loassdadassssssdd">Ознакомиться с правилами</div></a>
<div id="block_id" style="display: none;">
  <div class="photo_bg_load_text_ls">
<p style="line-height:11px;">
Аватаркой может быть любое изображение (размером не более 10 МБ и в одном из форматов: jpg, png, gif, bmp, tiff), не нарушающее правила социальной сети и этические нормы.
<br>
<br>
<strong>Запрещено размещение аватарки, которая содержит:</strong>
<br>
<br>
— Порнографию или эротику;
<br>
— Сцены насилия, жестокости или убийств (с участием людей или животных);
<br>
— Призывы к разжиганию расовой или межнациональной розни;
<br>
— Призывы к самоубийству;
<br>
— Оскорбления в адрес других людей (выраженные надписями, жестами и т.п.);
<br>
— Спам или рекламу;
<br>
— Призывы к употреблению табака, алкоголя, наркотиков, лекарств.
</p></div>
</div>