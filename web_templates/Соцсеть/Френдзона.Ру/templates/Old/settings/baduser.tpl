<style type="text/css" media="all">
.active_setings {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>

<div class="black_list_users" id="u{user-id}"><a href="/u{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" align="left" /></a><a href="/u{user-id}" onClick="Page.Go(this.href); return false"><b>{name}</b></a><div style="margin-top:7px"><a href="/u{user-id}" onClick="settings.delblacklist('{user-id}'); return false" id="del_{user-id}">Удалить из списка</a></div></div>