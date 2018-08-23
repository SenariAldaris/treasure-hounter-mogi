<div class="tt_miss">
 <a href="/miss/{user-id}" onClick="Page.Go(this.href); return false">
 <div class="tt_ava_miss">
 <img src="{ava}" alt="" id="ava_{user-id}" />
  <div class="tt_bloc1">
 <div class="tt_ava_miss_name"> {name} </div>
  <div class="tt_ava_miss_rating"> Рейтинг {rate} </div>
   </div>
 </div>

 </a>   
 <div class="menu_miss">
  <a href="/" onClick="miss.vote({user-id},1); return false"><div><span class="like_miss">   </span>Мне нравится</div></a>
    <a href="/" onClick="miss.vote({user-id},2); return false"><div><span class="like_miss_no">   </span>Мне <b>не</b> нравится </div></a>
 </div>
</div>