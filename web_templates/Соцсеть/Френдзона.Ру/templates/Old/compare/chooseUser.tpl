
<div class="friends_onefriendswr" id="friend_{user-id}">
 [status]<a href="/u{user-id}" onClick="Page.Go(this.href); return false">[/status]<div class="friends_ava"><img src="{ava}" alt="" id="ava_{user-id}" /></div>[status]</a>[/status]
 <div class="fl_l" style="">
   [status]<a href="/u{user-id}" onClick="Page.Go(this.href); return false"> [/status]<b>{name}  <span class="qq_friens">{online}</span></b> [status]</a> [/status]<div class="friends_clr"></div>
  {country}{city}<div class="friends_clr"></div>
  {age}<div class="friends_clr"></div>
<div class="friends_clr"></div>
 </div>

    <div class="sfw" style="margin-top: 20px;">
     <a href="/" onClick="messages.new_({user-id}); return false"><div class="box_messrq">Написать сообщение</div></a>
	 <a onclick="Page.Go(this.href); return false" href="/friends/{user-id}"><div class="box_messrq">Просмотреть друзей</div></a>
	 </div>
</div>