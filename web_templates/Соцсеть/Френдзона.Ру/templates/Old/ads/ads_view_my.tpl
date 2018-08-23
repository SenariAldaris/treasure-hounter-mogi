<style>.content{width:633px}</style>
<link media="screen" href="{theme}/style/ads.css" type="text/css" rel="stylesheet" />  
<div id="ads_{id}">

<div id="ads_sb">
<span id="edit_res_show_{id}" class="ads_title_editor" style="display:none;"></span>
<div class="ads_set_hover fl_r" id="ads_edis_byr_{id}" onClick="ads.edit_form('{id}')">Редактировать объявление</div>
<div class="ads_set_hover fl_r no_display" id="ads_edis_byr_show_{id}" onClick="ads.edit_close('{id}')">Закрыть</div>
<div id="image_view_{id}" class="ads_img">

<a href="{links}" target="_blank"><img src="{link}" /></a>

</div>

<div id="edit_info_{id}" class="ads_continfo">

<div class="ads_info"><b>Название:&nbsp;</b>&nbsp;{settings}</div>

<div class="ads_info"><b>Катигория:</b>&nbsp;<span id="category_save_{id}">{category}</span></div>

<div class="ads_info"><b>Описание:</b>&nbsp;<span id="description_save_{id}">{description}</span></div>

<div class="ads_info"><b>Осталось просмотров:&nbsp;</b>&nbsp;{views}</div>

</div>

<div class="clear"></div>

<div id="edit_con_{id}" class="ads_edit_container no_display">

<div class="ads_info"><b>Название:&nbsp;</b></div>

<input type="text" class="videos_input" style="width:335px;" value="{settings}" id="settings_{id}" maxlength="50" size="50" />

<div class="ads_info"><b>Ссылка на изображение:&nbsp;</b></div>

<input type="text" class="videos_input" style="width:335px;"  value="{link}" id="link_{id}" />

<div class="ads_info"><b>Ссылка на проект:&nbsp;</b></div>

<input type="text" class="videos_input" style="width:335px;"  value="{links}" id="links_{id}" />

<br />

<div id="category_load_{id}" class="ads_info"><b>Катигория:&nbsp;</b>&nbsp;{category}</div>

<select id="category_{id}" class="inpst" style="width:250px"> 

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

<div class="ads_info"><b>Описание:&nbsp;</b></div>

<textarea type="text" class="videos_input" id="description_{id}" style="width:335px;"  maxlength="100" size="100">{description}</textarea>

<div class="clear" style="line-height:14px">

<div class="savweswt_sasvw fl_l"><button onClick="ads.edit_save('{id}')">Сохранить</button></div>

<div class="savweswt_sasvw fl_l" id="editClose"><button onClick="ads.edit_close('{id}')">Отмена</button></div>

<div class="savweswt_sasvw fl_l"><button onclick="ads.delete_ads('{id}');">Удалить обявление</button></div>

</div>

<div class="clear"></div>

</div>

<div class="ads_err_yellow no_display" id="result_{id}"></div> 

</div>

</div>