<div class="pcont feed">
<div class="panel">
<ul class="tabs">


[all-albums]
<ul class="tabs"><li class="cur">
<a href="/albums/{user-id}" onclick="Page.Go(this.href); return false">Все</a></li>
 <li ><a href="/albums/comments/{user-id}" onclick="Page.Go(this.href); return false">Комментарии</a></li>
 [not-owner]<li><a href="/u{user-id}" onclick="Page.Go(this.href); return false">К странице {name}</a></li>[/not-owner]
 [new-photos]<a href="/albums/newphotos" onclick="Page.Go(this.href); return false" >Новые фотографии со мной (<b>{num}</b>)</a>[/new-photos]
</div>
<div class="clr"></div>
[/all-albums]
[view]
<div class="pv_all">
<input type="hidden" id="all_p_num" value="{all_p_num}" />
<input type="hidden" id="aid" value="{aid}" />
<div class="tmenuf">
 <ul class="tabs">
<li>
<a href="/albums/{user-id}" onclick="Page.Go(this.href); return false">Все</a>
</li>
 <li class="cur"><a href="/albums/view/{aid}" onclick="Page.Go(this.href); return false">{album-name}</a></li>
 <li><a href="/albums/view/{aid}/comments/" onclick="Page.Go(this.href); return false">Комментарии</a></li>
 [not-owner]<li><a href="/u{user-id}" onclick="Page.Go(this.href); return false">К странице {name}</a></li>[/not-owner]
</div>


[/view]
[comments]
<div class="tmenuf">
 <li >
<a href="/albums/{user-id}" onclick="Page.Go(this.href); return false">Все</a></li>
 <li class="cur"><a href="/albums/comments/{user-id}" onclick="Page.Go(this.href); return false">Комментарии</a></li>
 [not-owner]<li><a href="/u{user-id}">К странице {name}</a></li>[/not-owner]
</div>
<div class="clr"></div>
[/comments]
[albums-comments]
<div class="tmenuf">
 <a href="/albums/{user-id}" onclick="Page.Go(this.href); return false">Все</a>
 <a href="/albums/view/{aid}">{album-name}</a>
 <div><a href="/albums/view/{aid}/comments/">Комментарии</a></div>
 [not-owner]<a href="/u{user-id}">К странице {name}</a>[/not-owner]
</div>
<div class="clr"></div>
[/albums-comments]

</li>
</ul>
</div>