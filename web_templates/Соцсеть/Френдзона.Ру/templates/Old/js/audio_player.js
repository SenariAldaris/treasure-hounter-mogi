var jQplast_id = 1;
var jQpRepeat = 0;
var jQpRand = 0;
var jQpTranslate = 0;
var jQpSeachDelay = false;
var jQpSearchVal = '';
var jQpPreload = true;
var jQlastPage = 0;
var jQaudioPage = 0;
var jQpUserId = 0;
var player = {
  open: function(type, uid, aid){
	$('.staticPlbgTitle').removeClass('mini').css({'padding':'13px 12px 7px'});
    if(!uid) uid = '';
    var pos = $('#fplayer_pos').offset().left-220;
    var ln = $('#staticPlbg').length;
    if(!jQaudioPage){
	  if(ln){
        var tPos = $('.staticPlbg').css('margin-top').replace('px', '');
        if(tPos == 60){
          $('.staticPlbg').animate({'margin-top': -510});
        }else
          $('.staticPlbg').animate({'margin-top': 49});
      } else {
        var temp = '<div class="staticPlbg staticPlbgLoadig no_display" style="margin-left:700px"><div class="staticPlbgTitle" style="cursor:none"><div class="staticpl_ictop"></div><div align="center" style="margin-left:-10px;margin-bottom:1px"><img src="'+template_dir+'/images/load_player.gif" width="32" height="32" /></div></div></div>';
        $('#audioPlayer').html(temp);
        $('.staticPlbgLoadig').fadeIn(300);
		jQpUserId = uid;
        $.post('/index.php?go=audio_player', {get_user_id: uid, aid: aid}, function(d){
          $('#audioPlayer').html('<div class="box_right_owne2 no_display" style=" margin-top: -6px;"><div class="box_name_srtaw">Аудиозаписи</div><a onclick="audio.addBox()"><div><b>Добавить аудиозапись</b></div></a><a href="/?go=search&type=5&query=" onclick="Page.Go(this.href); return false;"><div><b>Поиск по аудио</b></div></a></div><div class="staticPlbg" id="staticPlbg" style="margin-left:700px">'+d+'</div>');
		  if(type) player.change_list(uid);
        });
      }
	}
  },
 close: function(){
    $('.staticPlbg').animate({'margin-top': -510});
  },
  jPlayerInc: function(autoplay){
    $("#Xjquery_jplayer").jPlayer({
      ready: function(){
        var url = $('.staticpl_audio:first').attr('data');
        var name = $('.staticpl_autit:first').text().split(' – ');
        $('#XjArtis').html(name[0]);
        $('#XjTitle').html(name[1]);
        $("#Xjquery_jplayer").change(url);
		if(autoplay) player.onePlay();
      },
      cssPrefix: "different_prefix_example"
    });
    $("#Xjquery_jplayer").jPlayerId("play", "player_play_2");
    $("#Xjquery_jplayer").jPlayerId("pause", "player_pause_2");
    $("#Xjquery_jplayer").jPlayerId("stop", "player_stop_2");
    $("#Xjquery_jplayer").jPlayerId("loadBar", "player_progress_load_bar_2");
    $("#Xjquery_jplayer").jPlayerId("playBar", "player_progress_play_bar_2");
    $("#Xjquery_jplayer").jPlayerId("volumeMin", "player_volume_min_2");
    $("#Xjquery_jplayer").jPlayerId("volumeMax", "player_volume_max_2");
    $("#Xjquery_jplayer").jPlayerId("volumeBar", "player_volume_bar_2");
    $("#Xjquery_jplayer").jPlayerId("volumeBarValue", "player_volume_bar_value_2");
    $("#Xjquery_jplayer").onProgressChange(function(loadPercent, playedPercentRelative, playedPercentAbsolute, playedTime, totalTime){
      var myPlayedTime = new Date(playedTime);
      var ptMin = (myPlayedTime.getMinutes() < 10) ? "0" + myPlayedTime.getMinutes() : myPlayedTime.getMinutes();
      var ptSec = (myPlayedTime.getSeconds() < 10) ? "0" + myPlayedTime.getSeconds() : myPlayedTime.getSeconds();
      var myTotalTime = new Date(totalTime);
      var ttMin = (myTotalTime.getMinutes() < 10) ? "0" + myTotalTime.getMinutes() : myTotalTime.getMinutes();
      var ttSec = (myTotalTime.getSeconds() < 10) ? "0" + myTotalTime.getSeconds() : myTotalTime.getSeconds();
      $("#play_time").text(ptMin+":"+ptSec);
      if(playedPercentRelative >= (99.9)){
      setTimeout(function() { player.next(); }, 1);
      }
    });
  },
  onePlay: function(){
    $('#Xjquery_jplayer').play();
    $('.staticpl_play, #xPlayerPlay'+jQplast_id).hide();
    $('.staticpl_pause, #xPlayerPause'+jQplast_id).show();
	$('.staticpl_player, #xPlayerPlay'+jQplast_id).hide();
    $('.staticpl_pauses, #xPlayerPause'+jQplast_id).show();
    $('#xPlayer'+jQplast_id).addClass('staticpl_audio_active');
    $('#xPlayer'+jQplast_id).attr('onClick', 'player.pause()');
  },
  play: function(i, change){
    var url = $('#xPlayer'+i).attr('data');
    var name = $('#xPlayerTitle'+i).text().split(' – ');

    //Онулируем пред. плеер
    if(jQplast_id != i){
      $('#xPlayer'+jQplast_id).attr('onClick', 'player.play('+jQplast_id+')');
      $('#xPlayer'+jQplast_id).removeClass('staticpl_audio_active');
      $('#xPlayerPlay'+jQplast_id).show();
      $('#xPlayerPause'+jQplast_id).hide();
	  $('#deltack'+jQplast_id).removeClass('staticpl_delic_white');
      $('#dtrack'+jQplast_id).removeClass('staticpl_editic_white');
      $('#atrack_'+jQplast_id).removeClass('staticpl_addmylisy_white');
      $('#atrackAddOk'+jQplast_id).removeClass('staticpl_addmylisok_white');
    }
    
    jQplast_id = i;
    
	//translate on
	if(jQpTranslate){
	  var aid = $('#xPlayer'+i+' b').attr('id').replace('artis', '');
      $.post('/index.php?go=audio_player&act=translate', {aid: aid});
	}
	
    $('#XjArtis').html(name[0]);
    $('#XjTitle').html(name[1]);
    if(!change) $("#Xjquery_jplayer").change(url);
    $("#Xjquery_jplayer").play();
    $('#xPlayer'+i).addClass('staticpl_audio_active');
	
    $('#deltack'+i).addClass('staticpl_delic_white');
    $('#dtrack'+i).addClass('staticpl_editic_white');
    $('#atrack_'+i).addClass('staticpl_addmylisy_white');
    $('#atrackAddOk'+i).addClass('staticpl_addmylisok_white');
	
    $('.staticpl_play, #xPlayerPlay'+i).hide();
    $('.staticpl_pause, #xPlayerPause'+i).show();
	$('.staticpl_player, #xPlayerPlay'+i).hide();
    $('.staticpl_pauses, #xPlayerPause'+i).show();
    $('#xPlayer'+i).attr('onClick', 'player.pause()');
  },
  pause: function(){
    $('#xPlayer'+jQplast_id).attr('onClick', 'player.play('+jQplast_id+', 1)');
    $('#Xjquery_jplayer').pause();
    $('.staticpl_play, #xPlayerPlay'+jQplast_id).show();
    $('.staticpl_pause, #xPlayerPause'+jQplast_id).hide();
	$('.staticpl_player, #xPlayerPlay'+jQplast_id).show();
    $('.staticpl_pauses, #xPlayerPause'+jQplast_id).hide();
  },
  next: function(){
    var new_id = parseInt(jQplast_id) + 1;
    var size = $('.staticpl_audio').size();
    var randId = Math.floor(Math.random() * size);
    
    if(randId == 0) randId = 1;
    if(jQpRand){
      if(randId != jQplast_id) new_id = randId;
      else new_id = randId + 1;
    }
          
    if(jQpRepeat) new_id = jQplast_id;
    
    var check = $('#xPlayer'+new_id).length;
    var check2 = $('#xPlayer1').length;

    if(check) player.play(new_id);
    else if(!check2) player.stop();
    else player.play(1);
    
    //DO LOAD AUDIOS
    var allNum = size - 10;
    if(new_id >= allNum) player.page();
    
    //AUTO SCROLL
    var scroll = 36 * jQplast_id - 180;
    $('.staticpl_audios').animate({scrollTop: scroll});
    
  },
  prev: function(){
    var new_id = parseInt(jQplast_id) - 1;
    var check = $('#xPlayer'+new_id).length;
	var check2 = $('#xPlayer1').length;

    if(check) player.play(new_id);
    else if(!check2) player.stop();
    else player.play(1);
    
    //AUTO SCROLL
    var scroll = 36 * jQplast_id - 180;
    $('.staticpl_audios').animate({scrollTop: scroll});
  },
  stop: function(){
    $('#Xjquery_jplayer').stop();
	$('.staticpl_play').show();
    $('.staticpl_pause').hide();
	$('.staticpl_player').show();
    $('.staticpl_pauses').hide();
  },
  refresh: function(){
    $('.staticpl_repeat').css('opacity', 1).attr('onClick', 'player.noRefresh()');
    jQpRepeat = 1;
  },
  noRefresh: function(){
    $('.staticpl_repeat').css('opacity', 0.8).attr('onClick', 'player.refresh()');
    jQpRepeat = 0;
  },
  rand: function(){
    $('.staticpl_rand').css('opacity', 1).attr('onClick', 'player.noRand()');
    jQpRand = 1;
  },
  noRand: function(){
    $('.staticpl_rand').css('opacity', 0.8).attr('onClick', 'player.rand()');
    jQpRand = 0;
  },
  translate: function(){
    $('.staticpl_translate').css('opacity', 1).attr('onClick', 'player.noTranslate()');
    jQpTranslate = 1;
  },
  noTranslate: function(){
    $('.staticpl_translate').css('opacity', 0.8).attr('onClick', 'player.translate()');
    jQpTranslate = 0;
	$.post('/index.php?go=audio_player&act=notranslate');
  },
  page: function(){
    if($('#jQp_page_but').text() == 'Показать больше аудиозаписей'){
	  var a = $('#jQpSeachVal').val();
	  if(a == 'Поиск') a = '';
      textLoad('jQp_page_but');
      $.post('/index.php?go=audio_player', {page_cnt: jQpage_cnt, query: a, doload: 1, get_user_id: jQpUserId}, function(d){
        jQpage_cnt++;
		if(!a) jQlastPage = jQpage_cnt;
        $('#jQaudios').append(d);
        $('#jQp_page_but').text('Показать больше аудиозаписей');
        if(!d) $('.staticpl_albut').hide();
		if(jQaudioPage) $('.staticpl_panel').show();
      });
    }
  },
  gSearch: function(){
    var a = $('#jQpSeachVal').val();
	$('#jQpLoad').fadeOut('fast');
	if(!a){
		player.xSearch();
	}
	0 == jQpSearchVal != a && a != 0 < a.length && (clearInterval(jQpSeachDelay), jQpSeachDelay = setInterval(function(){
	  player.xSearch();
	}, 200));
  },
  xSearch: function(uid){
  	if(uid) jQpUserId = uid;
	clearInterval(jQpSeachDelay);
	var a = $('#jQpSeachVal').val();
	$('#jQpLoad').fadeIn('fast');
	$('.staticpl_audios').scrollTop(0);
	if(a == 'Поиск') a = '';
	$.post('/index.php?go=audio_player', {query: a, doload: 1, get_user_id: jQpUserId}, function(d){
	  jQpage_cnt = 1;
      $('#jQpLoad').fadeOut('fast');
	  $('#jQaudios').html(d);
	  var size = $('.staticpl_audio').size();
	  if(size == 20) $('.staticpl_albut').show();
	  else $('.staticpl_albut').hide();
	  if(jQaudioPage) $('.staticpl_panel').show();
	});
  },
  doPast: function(i){
    var name = $('#xPlayerTitle'+i).text().split(' – ');
	$('#jQpSeachVal').val(name[0]).css('color', '#000');
	player.xSearch();
  },
  change_list: function(uid){
	if(!uid) uid = '';
	if(jQpUserId) uid = jQpUserId;
	jQpUserId = uid;
    document.title = 'Аудиозаписи';
	history.pushState({link:'/audio'+uid}, null, '/audio'+uid);
	jQaudioPage = 1;
  	$('#speedbar, .staticpl_bottom').hide();
	$('#page').html('');
    $('.box_right_owne2').removeClass('no_display');
    $('.staticPlbg').addClass('page_audio').css('margin', '0px').css('margin-top', '-22px').css('height', '100%');
    $('.staticpl_progress_bar').css('width', '380px');
    $('.staticpl_audios').css('width', '97%');
	$('.staticpl_audios').css('height', '100%');
    $('.staticpl_shadow').css('width', '568px');
    $('#jQpSeachVal').css('width', '495px').css('float', 'left');
    $('#jQpLoad').css('margin-left', '606px');
    $('.staticpl_rtitle').css('max-width', '295px');
    $('.staticpl_trackname').css('width', '215px');
	$('.staticpl_panel').show();
	$('#jQpaddbutpos').html('<div class="jQpnewloadbut" onClick="audio.addBox()" onMouseOver="myhtml.title(\'1\', \'Добавить аудиозапись\', \'jqploadbut\', -2)" id="jqploadbut1"><div class="staticpl_addmylisy staticpl_addmylisy_white"></div></div>');
  },
  reestablish: function(){
	jQaudioPage = 0;
	var pos = $('#fplayer_pos').offset().left-220;
        $('.box_right_owne2').addClass('no_display');
	$('.staticpl_bottom').show();
	$('.staticPlbg').removeClass('page_audio').css('margin', '20px').css('margin-top', '49px').css('margin-left','700px').css('margin-top', '-510px').css('height', '500px');
	$('.staticpl_progress_bar').css('width', '250px');
	$('.staticpl_audios').css('width', '455px');
	$('.staticpl_audios').css('height', '354px');
	$('.staticpl_shadow').css('width', '459px');
	$('#jQpSeachVal').css('width', '415px').css('float', 'none');
	$('#jQpLoad').css('margin-left', '410px');
	$('.staticpl_rtitle').css('max-width', '130px');
	$('.staticpl_trackname').css('width', '250px');
	$('.staticpl_panel').hide();
	$('#jQpaddbutpos').html('');
  }
}