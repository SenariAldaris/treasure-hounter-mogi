<div class="wrqsawtyuuiiiii"></div>

[all-friends]
<div class="box_right_owne" style="margin-top: -6px; margin-left: 577px;">
 <div class="activetab  news_a_owne"><a href="/friends/{user-id}" onClick="Page.Go(this.href); return false;"><div>Все друзья</div></a></div>
 <a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false;">Друзья на сайте</a>
 [owner]<a href="/friends/requests" onClick="Page.Go(this.href); return false;">Заявки в друзья {demands}</a>[/owner]
 [not-owner]
 <a href="/u{user-id}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
</div>

<div class="clear"></div>


<div class="search_form_tabss" style="width: 557px;"><div style="padding:5px 0px;"><input type="text" style="width:400px;" id="friendsearch" placeholder="Начните вводить имя..." onkeydown="friends.search({user-id},1);" class="fave_input search_input" value=""></div>
<div class="clear"></div>
</div>



<div id="searchbody" style="display:none;"></div>
[/all-friends]

[request-friends]
<div class="box_right_owne" style="margin-top: -13px; margin-left: 577px;">
 <a href="/friends/{user-id}" onClick="Page.Go(this.href); return false;">Все друзья</a>
 <a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false;">Друзья на сайте</a>
 <div class="activetab  news_a_owne"><a href="/friends/requests" onClick="Page.Go(this.href); return false;"><div>Заявки в друзья {demands}</div></a></div>
</div>
<div class="clear"></div>



[/request-friends]

[online-friends]
<div class="box_right_owne" style="margin-top: -6px; margin-left: 577px;">
 <a href="/friends/{user-id}" onClick="Page.Go(this.href); return false;">Все друзья</a>
 <div class="activetab  news_a_owne"><a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false;"><div>Друзья на сайте</div></a></div>
 [owner]<a href="/friends/requests" onClick="Page.Go(this.href); return false;">Заявки в друзья {demands}</a>[/owner]
[not-owner]
 <a href="/u{user-id}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
</div>
<div class="clear"></div>


<div class="search_form_tabss" style="width: 557px;"><div style="padding:5px 0px;"><input type="text" style="width:400px;" id="friendsearch" placeholder="Начните вводить имя..." onkeydown="friends.search({user-id},2);" class="fave_input search_input" value=""></div>
<div class="clear"></div>
</div>

<div id="searchbody" style="display:none;"></div>
[/online-friends]