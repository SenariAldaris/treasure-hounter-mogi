<div class="friends_onefriendswr" id="friend_{user-id}">
 <a href="/u{user-id}" onClick="Page.Go(this.href); return false"><div class="friends_ava"><img src="{ava}" alt="" id="ava_{user-id}" /></div></a>
 <div class="fl_l" style="">
  <a href="/u{user-id}" onClick="Page.Go(this.href); return false"><b>{name}</b></a><div class="friends_clr"></div>
  {country}{city}<div class="friends_clr"></div>
  {age}<div class="friends_clr"></div>
<div class="friends_clr"></div>
 </div>
  <div id="action_{user-id}">
 <div class="sfw">
	 <div class="box_messrq_but"><button onMouseDown="friends.take({user-id}); return false">Дружить</button></div>
     <div class="box_messrq_but"><button onMouseDown="friends.reject({user-id}); return false">Отклонить</button></div>
	 </div>	 </div>
</div>

