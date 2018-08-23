<div class="pcont prof">
<div class="m" style="display:none;">
<div class="ok"></div>
</div>
<div class="panel prof_panel">
<img class="u" align="left" src="{ava}">
<div class="cont">
<h2>
{name} {lastname}</h2>
<div class="lv"></div>
<div class="status">
</div>
<div class="info"> {city}</div>
</div>
<div class="cb"></div>

</div>
<div class="clr" style="margin-top:10px"></div>
<div style="padding-left:40px;padding-right:40px;">
[not-owner][blacklist][privacy-msg]<button class="button" onClick="messages.new_({user-id}); return false" style="width:100%">Написать сообщение</button>[/privacy-msg][/blacklist]
[no-friends][blacklist]<button class="button" onClick="friends.add({user-id}); return false" style="width:100%;margin-top:10px">Добавить в друзья</button>[/blacklist][/no-friends]
[yes-friends]<button class="button" onClick="friends.goDelte({user-id}); return false" style="width:100%;margin-top:10px">Убрать из друзей</button>[/yes-friends][/not-owner]
</div>
<br><br>
[albums]
<div class="prof_info">
<a class="h4" href="/albums/{user-id}" onclick="Page.Go(this.href); return false">
<h4>
<span>Альбомы {albums-num}</span>
</h4>
</a>
<div class="cont">
<div class="top_photos_wrap">
<div class="top_photos">

						{albums}
						
</div>
</div>
</div>
</div>
[/albums]
[privacy-info] <div class="prof_info">
<a class="h4"  href="/editmypage" onclick="Page.Go(this.href); return false" >
<h4>
<span>Информация</span>
 <span class="rl">ред.</span> 
<div class="cb"></div>
</h4>
</a>
<div class="cont">
<div>[not-all-birthday]
 <dl class="pinfo">
<dt>День рождения:</dt><dd><a href="/?go=search&day=26&month=8&year=1993" onClick="Page.Go(this.href); return false">{birth-day}</a></dd>
</dl>[/not-all-birthday][sp]
 <dl class="pinfo">
<dt>Семейное положение:</dt><dd><a href="/?go=search&sp=1" onClick="Page.Go(this.href); return false">{sp}</a></dd>
</dl> [/sp]

[not-contact-phone]
 <dl class="pinfo">
<dt>Моб. телефон: </dt><dd><a href="/" onClick="Page.Go(this.href); return false">{phone}</a></dd>
</dl> [/not-contact-phone]

 </div>
 </div>[/privacy-info] [not-owner]
<div class="prof_info">
<h4>Действия</h4>
<ul class="page_menu">

<li>
<a onclick="gifts.box('{user-id}'); return false" href="/">
<i class="p gift"></i>
Отправить подарок
</a>
</li>
 [no-fave]

<li>
<a href="/" onClick="fave.add({user-id}); return false" id="addfave_but">
<b id="text_add_fave">Добавить в закладки</b>
</a>
</li>
[/no-fave]
 [yes-fave]
<li>
<a href="/" onClick="fave.delet({user-id}); return false" id="addfave_but">
<b id="text_add_fave">Удалить из закладок</b>
</a>
</li>
[/yes-fave]
 [no-subscription]
<li>
<a id="lnk_unsubscription" onclick="subscriptions.add({user-id}); return false" href="/"><b id="text_add_subscription">Подписаться на обновления</b></a>
</li>
[/no-subscription]
 [yes-subscription]

<li>
<a id="lnk_unsubscription" onclick="subscriptions.del({user-id}); return false" href="/"><b id="text_add_subscription">Отписаться от обновлений</b></a>
</li>
[/yes-subscription][/not-owner]
 <div class="prof_info">
<h4>Другое</h4>
<ul class="page_menu">
 [friends]
<li>
<a href="/friends/{user-id}" onclick="Page.Go(this.href); return false">
Друзья
<em>{friends-num}</em>
</a>
</li>
[/friends]


 [groups]

<li>
<a href="/" onclick="groups.all_groups_user('{user-id}'); return false">
Интересные страницы
<em>{groups-num}</em>
</a>
</li>
[/groups]
 [gifts]

<li>
<a href="/gifts{user-id}" onclick="Page.Go(this.href); return false">
Подарки 
<em>{gifts-text}</em>
</a>
</li>
[/gifts]
</div>

<a class="h4" href="/" onclick="return false">
<h4>
<span>Стена  {wall-rec-num} </span>
<div class="cb"></div>
</h4>
</a>

<div class="post_add">
<form onblur="return false">
<div class="iwrap">
<textarea id="wall_text" placeholder="[owner]Что у Вас нового?[/owner][not-owner]Написать сообщение...[/not-owner]"></textarea>
</div>
<div class="near_box">
<input class="btn" type="submit" value="Отправить" onClick="wall.send({user-id}); return false" id="wall_send">
</div>
</form>
</div>


<div id="wall_records">{records}[no-records]<div class="wall_none" [privacy-wall]style="border-top:0px"[/privacy-wall]>На стене пока нет ни одной записи.</div>[/no-records]</div>
[wall-link]<span id="wall_all_record"></span><div onClick="wall.page('{user-id}'); return false" id="wall_l_href" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="wall_link">к предыдущим записям</div></div>[/wall-link]