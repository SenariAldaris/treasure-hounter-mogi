<div id="photo_view_{id}" class="photo_view" onClick="Photo.setEvent(event, '{close-link}')">
<span id="photo_view_{id}" class="photo_viewswqclose" onClick="Photo.setEvent(event, '{close-link}')" ></span>
<a href="/photo{uid}_{prev-id}{section}" onClick="Photo.Show(this.href); return false"><div id="i-photo-prev" class="unselectable" onclick="fsimp.imgPrev();">
<i class="tr-opacity-03"></i>
</div></a>
 <div class="photo_bg"><div id="i-photo-close" class="tr-opacity-03" onClick="Photo.Close('{close-link}'); return false;"></div>
  [mark-block]<div class="mark_userid_bg" id="mark_userid_bg{id}">
   <div class="fl_l"><a href="/u{mark-user-id}" onClick="Page.Go(this.href); return false">{mark-user-name}</a> {mark-gram-text} Вас на этой фотографии.</a></div>
   <div class="button_div_gray margin_left fl_r" style="margin-top:-5px"><button onClick="{mark-del-link}; return false">Удалить отметку</button></div>
   <div class="button_div fl_r" style="margin-top:-5px"><button onClick="Distinguish.OkUser({id}); return false">Потвердить</button></div>
   <div class="clear"></div>
  </div>[/mark-block]
   <div id="distinguishSettings{id}" class="distinguishSettings" style="display:none" onMouseOver="Distinguish.HideTag({id})">
	<div style="position:absolute;border-right:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_left{id}"></div>
	<div style="position:absolute;border-bottom:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_top{id}"></div>
	<div style="position:absolute;border-left:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_right{id}"></div>
	<div style="position:absolute;border-top:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_bottom{id}"></div>
    <div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_left{id}"></div>
	<div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_top{id}"></div>
	<div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_right{id}"></div>
	<div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_bottom{id}"></div>
   </div>
   <a href="/photo{uid}_{next-id}{section}" onClick="[all]Photo.Show(this.href)[/all][wall]Photo.Close('{close-link}')[/wall]; return false" id="photo_href"><div class="photo_img_box"><img id="ladybug_ant{id}" class="ladybug_ant" src="{photo}" alt="" /><div id="frameedito{id}"></div></a></div>
  <div class="clear"></div>
  <div id="save_crop_text{id}" class="save_crop_text no_display" style="padding:20px">
   Укажите область, которая будет сохранена как фотография Вашей страницы.
   <div class="button_div_gray margin_left fl_r" style="margin-top:-5px"><button onClick="crop.close({id}); return false">Отмена</button></div>
   <div class="button_div fl_r" style="margin-top:-5px"><button onClick="crop.save({id}, {uid}); return false">Готово</button></div>
  </div>

<div id="i-photo-tops">
<div class="i-photo-autor">
  <img class="user-avar" src="{ava_autor}">
      <div><a href="/u{uid}" class="usernamew" onClick="Page.Go(this.href); return false">{author}</a></div>
    <span style="color:#888; font-size: 13px;">{author-info}</span><br />
   </div>
   <div class="i-photo-ss fl_r">
   <div class="photo_com_titlesrrr" style="">[all]Фотография {jid} из {photo-num}[/all][wall]Просмотр фотографии[/wall]</div>

   </div>  </div>
  <div id="pinfo_{id}" class="pinfo viewphotoinf">
  <div id="i-photo-info-wrap" class="tr-opacity-03 nclear">
<div id="i-photo-left">
<div id="i-photo-description" class="message-form h">
<div id="i-photo-description-text"></div>
<div class="message-form-buttons nclear">
<div class="message-form-limit"></div>
</div>
</div>
<div id="i-photo-comments">
<div class="clear"></div>
<div id="i-photo-wrap-comment" class="nclear" style="opacity: 1;">
  <div class="photo_leftcol">

   <input type="hidden" id="i_left{id}" />
   <input type="hidden" id="i_top{id}" />
   <input type="hidden" id="i_width{id}" />
   <input type="hidden" id="i_height{id}" />
        [owner]<div class="box_ppadqq"><textarea class="inpst" id="descr_{id}" placeholder="Введите описание" style="height: 32px; width: 508px;resize: vertical; max-height: 100px;"></textarea>
  <div class="message-form-save-btn btn btn-blue btn-disabled unselectable fl-r" onClick="Photo.SaveDescr({id}); return false" style="margin-top: 4px; margin-right: 3px;">Сохранить</div>
</div>
<div class="req_sss" onClick="Photo.MoreInfo(); return false"> Редактировать описание  </div>        [/owner]
<div class="[no-descr] photo_descr-w[/no-descr]  clear" id="photo_descr_{id}" >{descr}</div>
   [all-comm]<a href="/" onClick="comments.all({id}, {num}); return false" id="all_href_lnk_comm_{id}"><div class="photo_all_comm_bg" id="all_lnk_comm_{id}">Показать предыдущие {comm_num}</div></a><span id="all_comments_{id}"></span>[/all-comm]
   <span id="comments_{id}">{comments}</span>
  [sinfos]  <div class="no_comeents">Комментариев нет</div>[/sinfos]
   </div>
</div>
<div id="i-photo-addcomment" class="message-form nclear">
<img class="user-ava" src="{ava_comsw}">
<textarea class="message-form-text form-text" id="textcom_{id}"  placeholder="Ваш комментарий"></textarea>
<div class="message-form-save-btn btn btn-blue btn-disabled unselectable fl-r" id="add_comm" onClick="comments.add({id}); return false">Отправить</div>
<div class="message-form-buttons nclear">
<div class="message-form-limit"></div>
</div>
</div>
</div>
</div>
  <div id="i-photo-right">
  	  <div class="i-photo-albums">
	   <div id="i-photo-album-name-box">Альбом <a href="/albums/view/{aid}" onClick="Page.Go(this.href); return false">  <span class="ellipsis">{album-name}</span></a></div>
	  <div id="i-photo-upload-date"> Добавлена  <span class="ellipsis">{date}</span></div>
   </div>
   <div class="menuleftsa">
         <a class="qqr_bue message-form-save-btn btn btn-blue btn-disabled unselectable fl-r" onClick="Report.Box('photo', '{id}')"><div>Пожаловаться на фотаграфию</div></a>
        [owner]
   <a class="qqr_bue message-form-save-btn btn btn-blue btn-disabled unselectable fl-r" href="/" onClick="crop.start({id}); return false"><div>Поместить на мою страницу</div></a>
   <a class="qqr_bue message-form-save-btn btn btn-blue btn-disabled unselectable fl-r" href="/" onClick="Photo.MsgDelete({id}, {aid}, 1); return false"><div>Удалить фотографию</div></a>[/owner]
   [owner]<div class="photos_gradus_pos">
    <div class="fl_l">Повернуть:</div>
	<div class="photos_gradus_left fl_l" onClick="Photo.Rotation('right', '{id}')"></div>
	<div class="photos_gradus_right fl_l" onClick="Photo.Rotation('left', '{id}')"></div>
	<div class="fl_l" style="margin-left:5px"><img src="{theme}/images/loading_mini.gif" id="loading_gradus{id}" class="no_display" /></div>
   </div>[/owner]
 
  </div>
  </div>
  </div>
 </div> </div>  </div>
<div class="clear"></div>