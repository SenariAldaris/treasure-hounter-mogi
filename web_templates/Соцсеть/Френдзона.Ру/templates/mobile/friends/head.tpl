[all-friends]
<div class="pcont friends">
<div class="panel">
<ul class="tabs">
<li class="cur">
<a class="al_tab" href="/friends/{user-id}" onclick="Page.Go(this.href); return false;">
Все
</a>
</li>

<li>
<a class="al_tab" href="/friends/online/{user-id}" onclick="Page.Go(this.href); return false;">
Онлайн
</a>
</li>[owner]
<li>
<a class="al_tab" href="/friends/requests" onclick="Page.Go(this.href); return false;">
Заявки {demands}</a>
</li>[/owner]


</ul>
</div>
 
 [not-owner]<a href="/u{user-id}" onclick="Page.Go(this.href); return false">К странице {name}</a>[/not-owner]
</div>
<div class="clr"></div>
[/all-friends]

[online-friends]
<div class="pcont friends">
<div class="panel">
<ul class="tabs">
<li>
<a class="al_tab" href="/friends/{user-id}" onclick="Page.Go(this.href); return false;">
Все
</a>
</li>

<li class="cur">
<a class="al_tab" href="/friends/online/{user-id}" onclick="Page.Go(this.href); return false;">
Онлайн
</a>
</li>


</ul>
</div>
[/online-friends]

[request-friends]
<div class="pcont friends">
<div class="panel">
<ul class="tabs">
<li>
<a class="al_tab" href="/friends/{user-id}" onclick="Page.Go(this.href); return false;">
Все
</a>
</li>

<li>
<a class="al_tab" href="/friends/online/{user-id}" onclick="Page.Go(this.href); return false;">
Онлайн
</a>
</li>

<li class="cur">
<a href="/friends/requests" onclick="Page.Go(this.href); return false">Заявки {demands}</a></
</li>
</ul>
</div>
[/request-friends]