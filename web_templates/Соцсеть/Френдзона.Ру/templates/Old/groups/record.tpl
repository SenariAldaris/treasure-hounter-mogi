[record]<div class="wallrecord wall_upage" id="wall_record_{rec-id}" style="padding-bottom:4px;margin-top:5px">
 
 <div class="wall_rec_autoresize" style="  margin-left: -12px;">
 <div class="wallauthoruu fl_l"><div style="float:left;width:45px"><div class="ava_minis [privacy-comment][if-comments]wall_ava_minisw[/if-comments][/privacy-comment]" id="ava_rec_{rec-id}"><a href="/{adres-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" title="" /></a><div class="kolsw"></div></div></div><a href="/{adres-id}" onClick="Page.Go(this.href); return false"> <div class="wallauthoruu_name">{name} <span class="color777"></span></div></a><a href="/wallgroups{public-id}_{rec-id}" onClick="Page.Go(this.href); return false" class="online"><div class="datesw">{date} </div></a><div class="kolsw_box">
 [owner]<div class="wall_delete" onMouseOver="myhtml.title('{rec-id}', 'Удалить запись', 'wall_del_')" onClick="groups.wall_delet('{rec-id}'); return false" id="wall_del_{rec-id}"></div><div class="wall_fasten" onMouseOver="myhtml.title('{rec-id}', '{fasten-text}', 'wall_fasten_')" onClick="groups.{function-fasten}('{rec-id}'); return false" id="wall_fasten_{rec-id}" {styles-fasten}></div>[/owner]
 <div class="wall_tell cursor_pointer" onMouseOver="myhtml.title('{rec-id}', 'Рассказать друзьям', 'wall_tell_')" onClick="groups.wall_tell('{rec-id}'); return false" id="wall_tell_{rec-id}" [owner]style="margin-top:1px;margin-right:1px"[/owner]></div>
 <div class="wall_tell_ok no_display" id="wall_ok_tell_{rec-id}" style="margin-top:-1px;margin-left:-2px;  margin-right: -6px;[owner]margin-top:-1px;margin-left:-2px;  margin-right: 4px;[/owner]"></div>
 <div class="wall_clear"></div> </div></div>
 <div class="wall_clear"></div>
 <div class="walltext_profile">{text}</div>
 <div class="size10 infowalltext_f clear">
  <div class="straps"> <div class="fl_l">[privacy-comment][comments-link]  <span id="fast_comm_link_{rec-id}" class="fast_comm_link"><div class="link_comm" style=" border-right: 1px solid #E3E3E3;"><a href="/" id="fast_link_{rec-id}" onClick="wall.open_fast_form('{rec-id}'); wall.fast_open_textarea('{rec-id}'); return false">Комментировать</a></div></span>[/comments-link][/privacy-comment]<div class="link_comm"><a onClick="Repost.Box('{rec-id}', 1); return false "id="wall_tell_all_{rec-id}">Отправить в сообщество или другу </a></div></div>
 <div class="wall_clear"></div>
 
   <input type="hidden" id="update_like{rec-id}" value="0" />
  <div class="fl_r public_wall_like cursor_pointer" onClick="{like-js-function}" onMouseOver="groups.wall_like_users_five('{rec-id}')" onMouseOut="groups.wall_like_users_five_hide('{rec-id}')" id="wall_like_link{rec-id}">
  <div class="fl_l" id="wall_like_active"></div>
   <div class="public_wall_like_no {yes-like}" id="wall_active_ic{rec-id}"></div>
   <b id="wall_like_cnt{rec-id}" class="{yes-like-color}">{likes}</b>
  </div>
   
  <div class="public_likes_user_block no_display" id="public_likes_user_block{rec-id}" onMouseOver="groups.wall_like_users_five('{rec-id}')" onMouseOut="groups.wall_like_users_five_hide('{rec-id}')">
<div onClick="groups.wall_all_liked_users('{rec-id}', '', '{likes}')">Понравилось {likes-text}</div>
   <div class="public_wall_likes_hidden">
    <div class="public_wall_likes_hidden2">
     <a href="/u{viewer-id}" id="like_user{viewer-id}_{rec-id}" class="no_display" onClick="Page.Go(this.href); return false"><img src="{viewer-ava}" width="32" /></a>
     <div id="likes_users{rec-id}"></div>
    </div>
   </div>
   <div class="public_like_strelka"></div>
  </div>
  </div>
[comments-link]<div class="wall_fast_form no_display" id="fast_form_{rec-id}">
   <div class="no_display wall_fast_texatrea" id="fast_textarea_{rec-id}">
   <div class="avas_walls"><img src="{ava3}" />   </div>
   <textarea class="wall_inpst fast_form_width wall_fast_text" style="height:19px;padding: 8px;color:#000;margin:0px; min-width: 42px;max-width: 500px;  max-height: 100px;width: 500px;" id="fast_text_{rec-id}"
		onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13)) groups.wall_send_comm('{rec-id}', '{user-id}')"
	></textarea>
    <div class="button_div fl_l margin_top_5"><button onClick="groups.wall_send_comm('{rec-id}', '{user-id}'); return false" id="fast_buts_{rec-id}">Отправить</button></div>
   </div>
   <div class="clear"></div>
  </div>[/comments-link]
  
 </div>
 
 <div class="clear"></div>
 </div>
 <div class="clear"></div>
</div>
[comments-link]<div id="wall_fast_block_{rec-id}" class="public_wall_rec_comments"></div>[/comments-link]
[/record][comment-form] <div class="cleasadsr"></div>[/comment-form]
 <div class="clear"></div>

[all-comm]<div class="cursor_pointer" onClick="groups.wall_all_comments('{rec-id}', '{public-id}'); return false" id="wall_all_but_link_{rec-id}"><div class="public_wall_all_comm_gred" id="wall_all_comm_but_{rec-id}">Показать {gram-record-all-comm}</div></div>[/all-comm]
[comment]<div class="wall_fast_blocks" style="margin-left: -8px;" id="wall_fast_comment_{comm-id}" onMouseOver="ge('fast_del_{comm-id}').style.display = 'block'" onMouseOut="ge('fast_del_{comm-id}').style.display = 'none'">
<div class="wall_fast_ava_profile"><a href="/u{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" /></a></div>
<div><a href="/u{user-id}" onClick="Page.Go(this.href); return false">{name}</a></div>
<div class="wall_fast_comment_text">{text}</div>
<div class="wall_fast_date">{date} [not-owner]&nbsp;-&nbsp; <a href="#" onClick="wall.Answer('{rec-id}', '{comm-id}', '{name}'); return false" id="answer_lnk">Ответить</a>[/not-owner][owner]<a href="/" class="size10 fl_r no_display" id="fast_del_{comm-id}" onClick="groups.comm_wall_delet('{comm-id}', '{public-id}'); return false">Удалить</a>[/owner]</div>
<div class="clear"></div>
</div>[/comment]
[comment-form]<div class="wall_fast_opened_form" style=" margin-left: -12px;" id="fast_form">
<input type="text" class="wall_inpst fast_form_width wall_fast_input" value="Комментировать..." id="fast_inpt_{rec-id}" onMouseDown="wall.fast_open_textarea('{rec-id}', 2); return false" style="margin:0px;" />
 <div class="no_display wall_fast_texatrea" id="fast_textarea_{rec-id}">
  <textarea class="wall_inpst fast_form_width wall_fast_text" style="height:33px;color:#000;margin-top:0px" id="fast_text_{rec-id}"
	onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13))wall.fast_send('{rec-id}', '{author-id}')"
  ></textarea>
  <div class="button_div fl_l margin_top_5"><button onClick="groups.wall_send_comm('{rec-id}', '{user-id}'); return false" id="fast_buts_{rec-id}">Отправить</button></div>
  <div class="wall_answer_for_comm fl_l">
   <a class="cursor_pointer answer_comm_for" id="answer_comm_for_{rec-id}"></a>
   <input type="hidden" class="answer_comm_id" id="answer_comm_id{rec-id}" />
  </div>
 </div>
 <div class="clear"></div>
</div>[/comment-form]

 <div class="clear"></div>