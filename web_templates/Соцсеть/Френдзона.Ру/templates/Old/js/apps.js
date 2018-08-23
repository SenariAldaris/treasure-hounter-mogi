//APPS
var vii_apps_search_delay = false;
var vii_apps_search_val = '';
var apps_preload = true;
var doload = 5;
var loads = 20;
var apps = {
	close:function(h){
		history.pushState({link:h}, null, h);
		$('#newbox_miniature').remove();
		$('html,body').css({'overflow':'auto','margin':'0'});
	},
	c:function(){
		$('#newbox_miniature').remove();
	},
	sendWall:function(id){
		$.post('/index.php?go=apps&act=mywall', {id:id},function(){
			Box.Info('msg_info', 'Приложения', 'Вы успешно рассказали друзьям.', 300);
		});
	},
	gSearch: function(){
		var a = $('#query_application').val();
		if(!a){
			$('#apps_all').show();
			$('#apps_search').hide();
			$('#apps_se_load').fadeOut(100);
			apps_preload = true;
		}
		if(a != 0){
			apps_preload = false;
			$('#apps_se_load').fadeIn('fast');
			0 == vii_apps_search_val != a && a != 0 < a.length && (clearInterval(vii_apps_search_delay), vii_apps_search_delay = setInterval(function(){
				apps.xSearch();
			}, 600));
		}
	},
	xSearch: function(){
		clearInterval(vii_apps_search_delay);
		var a = $('#query_application').val();
		$.post('/index.php?go=apps&act=search', {query_application: a}, function(d){
			if(a != 0){
				$('#apps_all').hide();
				$('#apps_search').show();
				$('#apps_se_load').fadeOut(100);
				$('#apps_search_res').html(d);
				$(".apps_last:last").css('border', '0px');
			} else {
				$('#apps_all').show();
				$('#apps_search').hide();
				$('#apps_se_load').fadeOut(100);
			}
		});
	},
	showMore: function(){
		if($('#apps_text_load').text() == 'Показать больше приложений' && apps_preload){
			textLoad('apps_text_load');
			$.post('/index.php?go=apps&act=loads', {num:loads}, function(d){
				loads = loads+20;
				row = d.split('||');
				$('#apps_pop').append(row[0]);
				$('#apps_new').append(row[1]);
				$('#apps_text_load').text('Показать больше приложений');
				if(!row[0] && !row[1]) $('.apps_but2').remove();
			});
		}
	},
	showMoreOld: function(){
		if($('#apps_text_load_old').text() == 'Показать больше приложений'){
			textLoad('apps_text_load_old');
			$.post('/index.php?go=apps&act=doload',{num:doload},  function(d){
				doload = doload+5;
				row = d.split('||');
				$('#apps_my_application').append(row[0]);
				$('#apps_activity').append(row[1]);
				$('#apps_text_load_old').text('Показать больше приложений');
				if(!row[0] && !row[1]) $('.apps_but').remove();
			});
		}
	},
	view: function(a, h, c){
		history.pushState({link:h}, null, h);
		$('html,body').css('overflow', 'hidden');
		$.post('/index.php?go=apps&act=view', {id: a}, function(d){
			$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 607px;margin-top:30px;"><div class="miniature_title fl_l">Установка приложения</div><a class="cursor_pointer fl_r" onclick="apps.close(\'/apps\')">Закрыть</a><div class="clear"></div>'+d+'</div></div></div>');
		});
	},
	deleteApp: function(aid, hash){
		$.post('/index.php?go=apps&act=quit', {id: aid, hash: hash}, function(d){
	 		if(d == 'ok')  window.location.href = "http://"+location.host+"/apps";
		
		});
	},

	removeApp: function(i, hash){
		$('.js_titleRemove').remove();
		$('#app'+i).html('<div align="center" style="color:#777;height:40px;padding-top:10px">Игра успешно удалена.</div>');
		$.post('/index.php?go=apps&act=quit', {id: i, hash: hash});
	},

	approveInstall: function(aid, hash){
		$.post('/index.php?go=apps&act=install', {id: aid, hash: hash});
	},
	loadSettings: function(i,hash) {
		viiBox.start();
		$.post('/index.php?go=apps&act=show_settings',{id: i, hash: hash}, function(data){
	 		viiBox.win('show_settings', data);
		});
 	},
 	saveSettings: function(aid, hash){
 		var i = $('#app_pay_add').val();
 		$.post('/index.php?go=apps&act=save_settings',{aid: aid, add: i, hash: hash}, function(data){	
 			if(data == 'ok') viiBox.clos('show_settings', 1);
 		});

 	}
}