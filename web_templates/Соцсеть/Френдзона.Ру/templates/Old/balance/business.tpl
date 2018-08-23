<script type="text/javascript">
$(document).ready(function(){
	aj1 = new AjaxUpload('upload', {
		action: '/index.php?go=balance&act=upload',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(jpg|jpeg|jpe)$/.test(ext))){
				addAllErr('Загружать разрешено только фотографии в формате JPG.', 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, response){
			Page.Loading('stop');
			if(response == 1) addAllErr('Загружать разрешено только фотографии в формате JPG.', 3300);
			else if(response == 2) addAllErr('Максимальны размер 5 МБ.', 3300);
			else if(response == 3) addAllErr('Картинка объязательно должна быть разрешения 256х256.', 3300);
			else if(response == 4) addAllErr('Ошибка сервера. Попробуйте пожалуйста позже.', 3300);
			else {
				$('#file1').html('<div class="texta" style="width:200px">&nbsp;</div><img id="img1" src="/uploads/gifts/'+response+'" style="margin-top:10px" />').show();
			}
		}
	});	
	aj2 = new AjaxUpload('upload_2', {
		action: '/index.php?go=balance&act=upload_2',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(png)$/.test(ext))){
				addAllErr('Загружать разрешено только фотографии в формате PNG.', 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, response){
			Page.Loading('stop');
			if(response == 1) addAllErr('Загружать разрешено только фотографии в формате PNG.', 3300);
			else if(response == 2) addAllErr('Максимальны размер 5 МБ.', 3300);
			else if(response == 3) addAllErr('Картинка объязательно должна быть разрешения 96х96.', 3300);
			else if(response == 4) addAllErr('Ошибка сервера. Попробуйте пожалуйста позже.', 3300);
			else {
				$('#file2').html('<div class="texta" style="width:200px">&nbsp;</div><img id="img2" src="/uploads/gifts/'+response+'" style="margin-top:10px" />').show();
			}
		}
	});
});
</script>
  <div class="box_right_owne" style="margin-top: -30px;">
  <div class="box_name_srtaw">Настройки</div>
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Личный счёт</b></div></a>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div><b>Приглашённые друзья</b></div></a>
  <a href="/settings/notify" onClick="Page.Go(this.href); return false;">Оповещения</a>
 <div class="box_name_srtaw">Редактирование моей страницы</div>
 <a href="/editmypage" onClick="Page.Go(this.href); return false;"><div>Основное</div></a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;"><div>Контакты</div></a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;"><div>Интересы</div></a>
 <a href="/editmypage/all" onClick="Page.Go(this.href); return false;"><div>Другое</div></a>
  <div class="box_name_srtaw">Платное</div>
 <a href="/ads&act=ads_target" onClick="Page.Go(this.href); return false;"><div>Реклама</div></a>
<a href="/mybanners" onClick="Page.Go(this.href); return false;"><div>Баннеры</div></a>
   <a href="/vip" onClick="Page.Go(this.href); return false;"><div>VIP Статус</div></a>
   <a href="/obshenie" onClick="Page.Go(this.href); return false;"><div>Хочу Общаться</div></a>
   <div class="activetab news_a"><a href="/balance?act=business" onClick="Page.Go(this.href); return false;"><div>Мои Подарки</div></a></div>
   <div class="box_name_srtaw">Развлечение</div>
      <a href="/miss" onClick="Page.Go(this.href); return false;"><div>Miss сайта</div></a>
</div>

  <div class="ss"></div>
<div class="margin_top_10"></div><div class="allbar_title">Добавление нового подарка</div>
<div class="err_yellow name_errors no_display" id="ok" style="font-weight:normal;margin-top:5px">Ваш подарок отправлен на проверку.</div>
 <div class="texta" style="width:200px">Цена:</div><input type="text" id="price" class="inpst" maxlength="5"  style="width:50px;" /><div class="mgclr"></div>
 <div class="texta" style="width:200px">Категория:</div><select class="inpst" id="cat"><option value="0"></option>{cats}</select><div class="mgclr"></div>
 <div class="texta" style="width:200px;padding-top:6px">Оригинал <b>.JPG</b>, 256x256:</div><div class="button_div_gray fl_l"><button id="upload">Выбрать файл</button></div><div class="mgclr"></div>
 <div id="file1" class="no_display"><div class="texta">&nbsp;</div><img src="" id="img1" /></div>
 <div class="mgclr" style="height:5px"></div>
 <div class="texta" style="width:200px;padding-top:5px">Уменьшеная копия <b>.PNG</b>(прозрачный фон), 96x96:</div><div class="button_div_gray fl_l" style="margin-top:5px"><button id="upload_2">Выбрать файл</button></div><div class="mgclr"></div>
 <div id="file2" class="no_display"><div class="texta">&nbsp;</div><img src="" id="img2" /></div>
 <div class="mgclr"></div>
 <div class="texta" style="width:200px">&nbsp;</div><div class="button_div fl_l" style="margin-top:10px"><button onClick="balance.sendgift()" id="sending">Отправить</button></div><div class="mgclr"></div>
 [ver]<div class="texta" style="width:200px">&nbsp;</div><div class="button_div_gray fl_l" style="margin-top:10px"><button onClick="balance.box('{business_rating}')">Увеличить лимит подарков на +1</button></div><div class="mgclr"></div>[/ver]
[gifts]<div class="margin_top_10"></div><div class="allbar_title">Статистика Ваших подарков<div class="fl_r online">Всего заработано: <b>{num}</b> mix</div></div>
{my-gifts}[/gifts]