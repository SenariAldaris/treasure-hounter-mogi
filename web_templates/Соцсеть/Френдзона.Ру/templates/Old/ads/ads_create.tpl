
<link media="screen" href="{theme}/style/ads.css" type="text/css" rel="stylesheet" />  
<div class="ads_edit_creat">

<div class="err_yellow no_display" id="result"></div> 

<div class="page_bg border_radius_5 margin_top_10"> 

<div class="texta" style="width:180px">Тематика:</div> 

<select id="category" class="inpst" style="width:250px"> 

<option value="0">Любая</option> 

<option value="1">Охота, рыбалка</option> 

<option value="2">Электроника и техника</option>

<option value="3">Фото, оптика</option>

<option value="4">Услуги и деятельность</option>

<option value="5">Телефоны и связь</option>

<option value="6">Строительство и ремонт</option>

<option value="7">Публичная страница</option>

<option value="8">Одежда, обувь, аксессуары</option>

<option value="9">Недвижимость</option>

<option value="10">Музыка, искусство</option>

<option value="11">Мебель, интерьер</option>

<option value="12">Компьютерная техника</option>

<option value="13">Книги, учебники, журналы</option>

<option value="14">Игры</option>

<option value="15">Видео</option>

<option value="16">Авто и мото</option> 

</select> 

<div class="mgclr"></div> 

<div class="texta" style="width:180px">Ссылка на изображение:</div> 

<input type="text" id="link_photos" class="inpst ads_inp" style="width:239px" /> 

<div class="mgclr"></div> 

<div class="texta" style="width:180px">Ссылка на проект:</div> 

<input type="text" id="link_site" class="inpst ads_inp" style="width:239px" /> 

<div class="mgclr"></div> 

<div class="texta" style="width:180px">Название:</div> 

<input type="text" id="title" class="inpst ads_inp" style="width:239px" /> 

<div class="mgclr"></div>

<div class="texta" style="width:180px">Описание:</div> 

<input type="text" id="description" class="inpst ads_inp" style="width:239px" /> 

<div class="mgclr"></div>  

<div class="clear margin_top_10" style="margin-top:15px"></div> 

<div class="texta" style="width:180px">Сколько переходов:</div> 

<input type="text" class="inpst ads_inp" id="transitions" style="width:40px" onKeyUp="ads.update()" maxlength="6" /><br /> 

<div style="margin-left:185px"><small>Рублей к оплате <b><span id="cost_num">0</span>.</b></small></div> 

<div class="mgclr"></div> 

<div class="mgclr"></div>

<div class="texta" style="width:180px">&nbsp;</div> 

<div class="button_div fl_l"><button onClick="ads.send()" id="sending">Заказать</button></div> 

<div class="mgclr"></div> 

</div>

</div>