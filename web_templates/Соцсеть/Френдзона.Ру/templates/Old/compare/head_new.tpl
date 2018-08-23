<script>
	$('#speedbar').show();
	$('#speedbar').text(lan_duels);
var prevAnsweName = false;
var comFormValID = false;
var Compare = {

	choose_send: function(rid){
		butloading('fast_buts_'+rid, 56, 'disabled');
		$.post('/index.php?go=compare&act=send', {rid: rid}, function(data){
		
		$('#compareResult').html(data); //выводим сам результат
		wall.fast_form_close();
		
		//butloading('fast_buts_'+rid, 56, 'enabled', lang_box_send);
		});
		
	}
	
}
</script>
<div class="luewwww_box" style="margin-right:297px; text-align: center">Выбирай людей, которые тебе нравятся, и узнай, нравишься ли ты им! Анкеты участников открываются друг другу только после совпадения. Чем дольше ты находишься в онлайне, тем чаще ты будешь показываться другим людям.</div>

<div class="box_right_owne" style=" margin-top: -81px;">

 <div class="{activetab-} news_a_owne"><a href="/news" onClick="Page.Go(this.href); return false;"><div>Новости</div></a></div>
 <div class="{activetab-notifications} news_a_owne"><a href="/news/notifications" onClick="Page.Go(this.href); return false;"><div>Ответы</div></a></div>
 <div class="{activetab-photos} news_a_owne"><a href="/news/photos" onClick="Page.Go(this.href); return false;"><div>Фотографии</div></a></div>
 <div class="{activetab-videos} news_a_owne"><a href="/news/videos" onClick="Page.Go(this.href); return false;"><div>Видеозаписи</div></a></div>
 <div class="{activetab-updates} news_a_owne"><a href="/news/updates" onClick="Page.Go(this.href); return false;"><div>Обновления</div></a></div>
  <div class=" {activetab-1} news_a_owne"><a href="/index.php?go=compare" onClick="Page.Go(this.href); return false;"><div>Фото-дуэли</div></a></div>
 <div class="{activetab-2}  news_a_owne"><a href="/?go=compare&act=choose" onClick="Page.Go(this.href); return false;"><div><b>Мне нравится {cnt-1}</b></div></a></div>
 <div class="{activetab-3}  news_a_owne"><a href="/?go=compare&act=choose&out=1" onClick="Page.Go(this.href); return false;"><div><b>Я нравлюсь {cnt-2}</b></div></a></div>
 <div class="{activetab-4}  news_a_owne"><a href="/?go=compare&act=choose&out=2" onClick="Page.Go(this.href); return false;"><div><b>Взаимно {cnt-3}</b></div></a></div>
</div>

[main]<div class="clear"></div>

[/main]

