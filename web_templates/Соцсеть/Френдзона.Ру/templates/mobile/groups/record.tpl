[record]<div class="onewallrec wallrecord" id="wall_record_{rec-id}">
<div class="ewllfs"><a href="/{adres}" onclick="Page.Go(this.href); return false;"><img src="{ava}" width="40" height="40" align="left" /></a></div>
<div class="wallwTEXT">
<a href="/{adres}" onclick="Page.Go(this.href); return false;"><b>{name}</b></a><br />
<div>{text}</div>
<div class="clr"></div>
<span class="color777">{date} <img src="{theme}/images/index2.png" style="margin-left:5px;margin-right:5px" /><b id="wall_like_cnt{rec-id}" class="wall_like_cnt">{likes}</b></span>
<div class="panelsuvd"><a href="/" id="wall_like_link{rec-id}" onClick="{like-js-function}; return false" class="{yes-like-color}">Мне нравится</a>[owner] - <a href="/" class="size10 fl_r" id="fast_del_{comm-id}" onClick="groups.wall_delet('{rec-id}'); return false" style="font-weight:normal">Удалить</a>[/owner]</div>
[comments-link][privacy-comment]<div id="fast_form_{rec-id}"><textarea class="wall_fast_text inp" style="height:33px;color:#000;margin:0px;margin-top:10px;width:98%;margin-bottom:10px" id="fast_text_{rec-id}" placeholder="Комментировать.."></textarea>
<div class="clr"></div>
<button class="button" onClick="groups.wall_send_comm('{rec-id}', '{user-id}'); return false">Отправить</button></div>[/privacy-comment][/comments-link]
</div>
<div class="clr"></div>
</div>
[comments-link]<div id="wall_fast_block_{rec-id}" class="public_wall_rec_comments"></div>[/comments-link]
[/record]
[all-comm]<div class="cursor_pointer" onClick="groups.wall_all_comments('{rec-id}', '{public-id}'); return false" id="wall_all_but_link_{rec-id}"><div class="public_wall_all_comm" id="wall_all_comm_but_{rec-id}">Показать {gram-record-all-comm}</div></div>[/all-comm]
[comment]<div class="wall_fast_block" id="wall_fast_comment_{comm-id}">
<div class="wall_fast_ava"><a href="/u{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" width="25" height="25" /></a></div>
<div class="wall_fast_pad">
<div><a href="/u{user-id}">{name}</a></div>
<div class="wall_fast_comment_text">{text}</div>
<div class="color777" style="font-size:11px">{date} [owner]- <a href="/" class="size10 fl_r" id="fast_del_{comm-id}" onClick="groups.comm_wall_delet('{comm-id}', '{public-id}'); return false" style="font-weight:normal;font-size:11px">Удалить</a>[/owner]</div>
<div class="clear"></div>
</div>
</div>[/comment]
[comment-form]<div style="margin-left:50px;margin-bottom:10px" id="fast_form_{rec-id}"><textarea class="wall_fast_text inp" style="height:33px;color:#000;margin:0px;margin-top:5px;width:99%;margin-bottom:10px" id="fast_text_{rec-id}" placeholder="Комментировать.."></textarea>
<div class="clr"></div>
<button class="button" onClick="groups.wall_send_comm('{rec-id}', '{user-id}'); return false">Отправить</button></div>[/comment-form]