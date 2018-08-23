[all]<div class="top_notes"></div>
<div class="box_right_owne" style=" margin-top: -6px;">
 <div class="activetab news_a_owne"><a href="/notes/{user-id}" onClick="Page.Go(this.href); return false;"><div>[owner]Мои заметки[/owner][not-owner]Заметки {name}[/not-owner]</div></a></div>
 [owner]<a href="/notes/add" onClick="Page.Go(this.href); return false;">Добавить запись</a>[/owner]
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
</div>
<div class="clear"></div><div style="margin-top:10px;"></div>
[/all]
[add]<div class="top_notes"></div>
<div class="box_right_owne" style=" margin-top: -6px;">
 <a href="/notes" onClick="Page.Go(this.href); return false;">Мои заметки</a>
 <div class="activetab news_a_owne"><a href="/notes/add" onClick="Page.Go(this.href); return false;"><div>Добавить запись</div></a></div>
</div>
<div class="clear"></div><div class="hralbum" style="margin-top:10px;"></div>
[/add]
[edit]
<div class="top_notes"></div>
<div class="box_right_owne" style=" margin-top: -6px;">
 <a href="/notes" onClick="Page.Go(this.href); return false;">Мои заметки</a>
 <div class="activetab news_a_owne"><a href="/notes/edit/{note-id}" onClick="Page.Go(this.href); return false;"><div>Редактирование записи</div></a></div>
 <a href="/notes/add" onClick="Page.Go(this.href); return false;">Добавить запись</a>
</div>
<div class="clear"></div><div class="hralbum" style="margin-top:10px;"></div>
[/edit]
[view]<div class="top_notes"></div>
<div class="box_right_owne" style=" margin-top: -6px;">
 <a href="/notes/{user-id}" onClick="Page.Go(this.href); return false;">[owner]Мои заметки[/owner][not-owner]Заметки {name}[/not-owner]</a>
 <div class="activetab news_a_owne"><a href="/notes/view/{note-id}" onClick="Page.Go(this.href); return false;"><div>Просмотр заметки</div></a></div>
 [not-owner]<a href="/u{user-id}" onClick="Page.Go(this.href); return false;">К странице {name}</a>[/not-owner]
 [owner]<a href="/notes/add" onClick="Page.Go(this.href); return false;">Добавить запись</a>[/owner]
</div>
<div class="clear"></div>
[/view]