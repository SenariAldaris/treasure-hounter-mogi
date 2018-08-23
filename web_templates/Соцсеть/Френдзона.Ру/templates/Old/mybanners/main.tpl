<link media="screen" href="{theme}/style/ads.css" type="text/css" rel="stylesheet" />  
<style>.content{width:633px}</style>
<style type="text/css" media="all">
.active_setings {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>
<script type="text/javascript">
doLoad.data(5);
$(document).ready(function(){
  Xajax = new AjaxUpload('upload', {
    action: '/index.php?go=mybanners&act=upload',
    name: 'uploadfile',
    onSubmit: function(file, ext){
      if(!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))){
        addAllErr(lang_bad_format, 2000);
        return false;
      }
      Page.Loading('start');
    },
    onComplete: function (file, response){
      Page.Loading('stop');
      if(response == 1) addAllErr('Максимальны размер 1 МБ.', 2000);
      else if(response == 2) addAllErr('Ошибка сервера. Попробуйте пожалуйста позже.', 3300);
      else $('#docver').html('<div class="texta" style="width:180px">&nbsp;</div><div id="src" data="'+response+'" style="color:green;margin-top:10px;margin-bottom:-10px">Изображение загружено!</div>');
    }
  });
});
</script>
 <div class="cles_topggg"></div>
 <div class="box_right_owne" style=" margin-top: -12PX;">
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
<div class="activetab news_a"><a href="/mybanners" onClick="Page.Go(this.href); return false;"><div>Баннеры</div></a></div>
   <a href="/vip" onClick="Page.Go(this.href); return false;"><div>VIP Статус</div></a>
   <a href="/obshenie" onClick="Page.Go(this.href); return false;"><div>Хочу общаться</div></a>
   <a href="/balance?act=business" onClick="Page.Go(this.href); return false;"><div>Мои Подарки</div></a>
   <div class="box_name_srtaw">Развлечение</div>
      <a href="/miss" onClick="Page.Go(this.href); return false;"><div>Miss сайта</div></a>
</div>

<div class="ss"></div>

<div class="allbar_title_settings">Настройки рекламы</div>
<div class="page_bg border_radius_5 margin_top_10 margin_bottom_10">
<div class="err_yellow_2 no_display" style="font-weight:normal">Сохранено.</div>
<div class="texta" style="width:180px">Тематика показываемой рекламы:</div>
 <select id="cat_v" class="inpst" style="width:250px">
  <option value="0">Любая</option>
  {cat-2}
 </select>
<div class="mgclr"></div>
<div class="texta"  style="width:180px">&nbsp;</div>
 <div class="button_div fl_l"><button onClick="mybanners.save_sett()" id="sending_2">Сохранить</button></div>
<div class="mgclr"></div>
</div>
<div class="allbar_title_settings">Покупка рекламы</div>
<div class="page_bg border_radius_5 margin_top_10">
<div class="err_red no_display" style="font-weight:normal">У Вас недостаточно рублей на счету. <a class="cursor_pointer" onClick="doLoad.data(2); payment.box()">Пополнить баланс</a></div>
<div class="err_yellow no_display" style="font-weight:normal">Заявка на рекламу успешно отправлена.</div>
<div class="texta" style="width:180px">Тематика:</div>
 <select id="cat" class="inpst" style="width:250px">
  <option value="0">Любая</option>
  {cat}
 </select>
<div class="mgclr"></div>
<div class="texta" style="width:180px">Расположение рекламы:</div>
 <select id="pos" class="inpst" style="width:250px" onChange="mybanners.update();if(this.value == 5){$('#b').show()}else{$('#b').hide()}">
  <option value="1">Верх (1020х150)</option>
  <option value="2">Низ (560х175)</option>
  <option value="3">Справа №1 (65x90)</option>
  <option value="4">Справа №2 (65x90)</option>
  <option value="5">Справа №3 (65x90)</option>
 </select>
<div class="mgclr"></div>
<div class="texta" style="width:180px">Ссылка:</div>
 <input type="text" id="link" class="inpst" style="width:239px" />
<div class="mgclr"></div>
<div class="texta" style="width:180px">Заголовок:</div>
 <input type="text" id="title" class="inpst" style="width:239px" />
<div class="mgclr"></div>
<div class="texta" style="width:180px">Описание:</div>
 <textarea type="text" id="descr" class="inpst" style="width:239px;height:40px"></textarea>
<div class="mgclr"></div>
<div class="texta" style="padding-top:12px;width:180px">Изображение:</div>
 <div class="button_div_gray fl_l" style="margin-top:5px"><button id="upload">Загрузить изображение</button></div>
<div class="mgclr"></div>
<div id="docver"></div>
<div class="clear margin_top_10" style="margin-top:15px"></div>
<div class="texta" style="width:180px">Сколько переходов:</div>
 <input type="text" class="inpst" id="transitions" style="width:40px" onKeyUp="mybanners.update()" maxlength="6" /><br />
 <div style="margin-left:185px"><small>К оплате <b><span id="cost_num">0</span> руб.</b></small></div>
<div class="mgclr"></div>
<span id="b" class="no_display"><div class="texta" style="width:180px">Ваша цена выкупа за переход:</div>
 <input type="text" class="inpst" id="redemption" style="width:40px" /><br />
<div class="mgclr"></div></span>
<div class="texta" style="width:180px">&nbsp;</div>
 <div class="button_div fl_l"><button onClick="mybanners.send()" id="sending">Оплатить</button></div>
<div class="mgclr"></div>
</div>
<input type="hidden" id="cost_banner_top" value="{cost_banner_top}" />
<input type="hidden" id="cost_banner_bottom" value="{cost_banner_bottom}" />
<input type="hidden" id="cost_banner_right_1" value="{cost_banner_right_1}" />
<input type="hidden" id="cost_banner_right_2" value="{cost_banner_right_2}" />
<input type="hidden" id="cost_banner_right_3" value="{cost_banner_right_3}" />
<div class="allbar_title_settings">Купленная реклама</div>
{banners}