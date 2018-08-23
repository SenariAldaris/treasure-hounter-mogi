<div id="album_{aid}" class="albums_profile_page" [owner]style="cursor:move"[/owner]>
<a href="/albums/view/{aid}" onClick="Page.Go(this.href); return false"><div class="albums_cover_page"><span id="cover_{aid}" class="albums_cover_page"><img src="{cover}" alt="" /></span></div></a>
<a href="/albums/view/{aid}" onClick="Page.Go(this.href); return false" id="albums_name_{aid}"><div class="albums_name_page">{name}</div></a>
<a href="/albums/view/{aid}" onClick="Page.Go(this.href); return false" id="albums_name_{aid}"><div class="caption_albums">
<a href="/" onClick="Albums.Delete({aid}, '{hash}'); return false"><div class="deletes"></div></a>
<a href="/" onClick="Albums.EditBox({aid}); return false"><div class="edit_albumsw"></div></a>
<div class="albums_photo_num">Обновлён {date}</div>
<div class="album_desc"><span id="descr_{aid}">{descr}</span></div>
<div class="albums_photo_num">{photo-num}, {comm-num}</div>
</div>
</div></a>

