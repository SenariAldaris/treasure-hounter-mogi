<script type="text/javascript">
	$('#speedbar').show();
	$('#speedbar').text(lang_guests);
</script>
 <div class="topss"></div>
<div class="box_right_owne" style="margin-top: -10px;">
 <div class="activetab news_a"><a href="/guests/{user-id}" onClick="Page.Go(this.href); return false;"><div>[owner]Мои гости[/owner][not-owner]Гости {name}[/not-owner]</div></a></div>
   <a href="/u{user-id}" onClick="Page.Go(this.href); return false;"><div><b>[not-owner]К странице {name}[/not-owner][owner]К моей странице[/owner]</b></div></a>
 [owner]<a onclick="guest.clear(); return false" href="/">Очистить список</a>
[/owner]
</div>
<div class="jje_guenst no_display" id="guest_clear" style="font-weight:normal;">Список гостей успешно очищен!</div>
[no-guests] 	<div class="swrf" align="center">  [owner]{name} вашу страницу пока что никто не посетил :([/owner][not-owner]Вы стали первым кто посетил страницу {name}[/not-owner]</div>[/no-guests]
