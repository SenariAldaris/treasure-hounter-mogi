
<script type="text/javascript">
var jQpage_cnt = 1;
$(document).ready(function(){
  player.jPlayerInc('');
  $('.staticpl_audios').scroll(function(){
	if($('#jQaudios').height() - $('.staticpl_audios').height() <= $('.staticpl_audios').scrollTop() + ($('.staticpl_audios').height() / 2 + 100 ))
		player.page();
  });
});
</script>

<div id="Xjquery_jplayer"></div>

<div class="staticpl_seadisb"></div>

<div class="staticPlbgTitle">

<div class="staticpl_ictop"></div>

<div class="staticpl_prev" onClick="player.prev()"></div>

<div class="staticpl_play" onClick="player.onePlay()"></div>

<div class="staticpl_pause" onClick="player.pause()"></div>

<div class="staticpl_next" onClick="player.next()"></div>

<div class="staticpl_trackname"><div class="staticpl_rtitle"><div><b id="XjArtis">&nbsp;</b> – <span id="XjTitle">&nbsp;</div></span></div><small id="play_time">00:00</small></div>

<div class="staticpl_progress_bar">

<div id="player_progress_load_bar_2">

<div id="player_progress_play_bar_2"></div>

</div>

</div>

<div class="staticpl_progress_bar_voice" id="player_volume_bar_2">

<div id="player_volume_bar_value_2"></div>

</div>

<div class="staticpl_repeat" onClick="player.refresh()" onMouseOver="myhtml.title('1', 'Повторять эту песню', 'xPlayerVolrefresh')" id="xPlayerVolrefresh1"></div>

<div class="staticpl_rand" onClick="player.rand()" onMouseOver="myhtml.title('1', 'Случайный порядок', 'xPlayerRand')" id="xPlayerRand1"></div>

<div id="xPlayerTranslate1" class="staticpl_translate" onmouseover="myhtml.title('1', 'Транслировать', 'xPlayerTranslate')" onclick="player.translate()"></div>

<div class="clear"></div>

</div>

<div class="staticpl_seachbg">

<img src="/images/loading_mini.gif" class="fl_r no_display" id="jQpLoad" style="margin-left:410px;margin-top:15px;position:absolute" />

<input type="text" value="Поиск" class="search_input_style" 

onBlur="if(this.value==''){this.value='Поиск';this.style.color = '#c1cad0'}" 

onFocus="if(this.value=='Поиск'){this.value='';this.style.color = '#000'}" 

onKeyUp="player.gSearch()"

id="jQpSeachVal"

maxlength="70" />

<div id="jQpaddbutpos"></div>

<div class="clear"></div>

</div>

<div class="staticpl_audios">

<div class="staticpl_shadow"></div>

<div id="jQaudios">

</div>
