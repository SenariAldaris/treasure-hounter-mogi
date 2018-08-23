
var AppsEdit = {
	CreateApp: function(){
		var name = $("#app_name").val();
		var desc = $("#app_desc").val();
		var category = $('#category').val();
		if(name!='' && desc!=''){
			$.post('/index.php?go=editapp&act=do_create', {title: name, desc: desc, category: category}, function(data){
				if(data > 0){
					 Page.Go(this.href='/editapp/options_'+data);
				}
			});
		}else Box.Info('msg_info', 'Ошибка', 'Заполните все поля!.' , 330, 1600);
	},
	changeReason_game: function(type1){
		$('.settings_reason').removeClass('on');
		$(event.target).addClass('on');
		var type1 = $('#type1').val();
		$('#type1').show();
		$('#apps_name_cat').show();
		$('#type2').hide();
	},
	changeReason_apps: function(type2){
		$('.settings_reason').removeClass('on');
		$(event.target).addClass('on');
		var type2 = $('#type2').val();
		$('#type2').show();
		$('#apps_name_cat').show();
		$('#type1').hide();

	},
	SaveOptions: function (type,id) {
			var app_name = $("#app_name").val();
			var app_desc = $("#app_desc").val();
			var app_hash = $("#app_hash").val();
			var app_secret = $("#app_secret2").val();
			var app_type = $("#type").val();
			var app_status = $("#status").val();
			var app_url = $("#app_iframe_url").val();
			var app_width = $("#app_iframe_width").val();
			var app_height = $("#app_iframe_height").val();

			$.post('/index.php?go=editapp&act='+type, {app_title: app_name, app_desc: app_desc, app: id, app_hash: app_hash, app_secret: app_secret, app_status: app_status, app_url: app_url, app_width: app_width, app_height: app_height, app_type: app_type}, function(data){
				if(data == 'ok'){
					$('#apps_options_saved').show();
					$('#apps_options_saved').html(lang_infosave);
					setTimeout("$('#apps_options_saved').hide()", 2000);
				} else 	setErrorInputMsg('app_'+ data);
			});
	},
	LoadPhoto: function(id){
		$.get('/index.php?go=editapp&act=load_photo&id='+id, function(data){
			Box.Show('photo', 400, lang_title_load_photo, data, lang_box_cancel);
		});
	},
	updateSWF: function(id){
		$.get('/index.php?go=editapp&act=load_flash&id='+id, function(data){
			Box.Show('flash', 400, 'Выберите файл для загрузки', data, lang_msg_close);
		});
	},
	type: function(){
		var type = $('#type').val();
		if(type == 1) {
			$(apps_edit_flash_options).css("display", "none"); 
			$(apps_edit_iframe_options).css("display", "table"); 
		}else{
			$(apps_edit_flash_options).css("display", "table"); 
			$(apps_edit_iframe_options).css("display", "none"); 
		}

	},
	DeleteApp: function(id){
		Box.Show('del_app_'+id, '400', 'Удаление приложения', '<div style="padding:15px;"><b>Внимание!</b> Удаленное приложение не может быть восстановлено. Вы уверены, что хотите удалить это приложение?</div>', lang_box_cancel, lang_box_yes, 'AppsEdit.DeleteAppOk('+id+');');
	},
	DeleteAppOk: function(id){
		var app_hash = $("#app_hash").val();
		$.post('/index.php?go=editapp&act=deleteapp', {app: id, app_hash: app_hash}, function(data){
			if(data == 'ok'){
				  window.location.href = "http://"+location.host;
			}else {
				Box.Info('msg_info', 'Ошибка', 'Удалить приложение может только главный администратор.' , 330, 1600);
			}
		});
	},
	uSearch: function(){
    	viiBox.start();
		$.post('/index.php?go=editapp&act=search_admin', function(d){
	  		Box.Show('add_admin', 400, 'Добавление администратора', d, lang_box_cancel,'Добавить', 'AppsEdit.save();');
		});
  	},
	save: function(){
		var idadmin = $('#upage').val();
		var id = $('#app_id').val();
		var hash = $('#app_hash').val();

    	$.post('/index.php?go=editapp&act=save_admin', {id: id, addr: idadmin, hash: hash}, function(d){
    		if(d == 'ok'){
    			Box.Close('add_admin','undefrend')
				
				$("div#content_reload").load("# div#app_edit");

    			Box.Info('msg_info', 'Изменения сохранены.', 'Добавлен администратор приложения.' , 300, 1600);
			} else {
				if(d == 'not_user') Box.Info('msg_info', 'Ошибка', 'Данного пользователя не существует.' , 300, 1600); else Box.Info('msg_info', 'Ошибка', 'Пользователь уже есть в администраторах.' , 300, 1600);
			}
	  	});

  	},
  	uRemoveAdmin: function(u){
		var id = $('#app_id').val();
		var hash = $('#app_hash').val();
		$.post('/index.php?go=editapp&act=del_admin_form', {id: id, addr: u, hash: hash}, function(d){

	  		Box.Show('add_admin', 400, 'Удаление администратора', d, lang_box_cancel,'Удалить', 'AppsEdit.uDoRemoveAdmin('+u+');');
		});
	},
	uDoRemoveAdmin: function(u){
		var id = $('#app_id').val();
		var hash = $('#app_hash').val();

    	$.post('/index.php?go=editapp&act=del_admin', {id: id, addr: u, hash: hash}, function(d){
    		if(d == 'ok'){
    			Box.Close('add_admin','undefrend')
    			$('#apps_edit_admin'+u).hide();

				$("div#content_reload").load("# div#app_edit");

    			Box.Info('msg_info', 'Изменения сохранены.', 'Администратор был удален.' , 300, 1600);
			} else {
				if(d == 'general') Box.Info('msg_info', 'Ошибка', 'Нельзя удалить главного администратора.' , 300, 1600); else Box.Info('msg_info', 'Ошибка', 'Пользователя нету в администраторах.' , 300, 1600);
			}
	  	});
	},
  	checkAdmin: function(){
		var upage = $('#upage').val();
		var pattern = new RegExp(/^[0-9]+$/);
		if(pattern.test(upage)){
			$.post('/index.php?go=editapp&act=checkAdmin', {id: upage}, function(d){
				d = d.split('|');
				if(d[0]){
					if(d[1])
						$('#feedimg').attr('src', '/uploads/users/'+upage+'/50_'+d[1]);
					else
						$('#feedimg').attr('src', '/images/no_ava_50.png');

				} else {
	  				setErrorInputMsg('upage');
					$('#feedimg').attr('src', '/images/no_ava_50.png');
				}
			});
		} else
			$('#feedimg').attr('src', '/images/no_ava_50.png');
  	}

}