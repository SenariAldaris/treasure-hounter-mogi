var mybanners = {
  update: function(){
	var add = $('#transitions').val();
	var pr = parseInt(add);
	if(!isNaN(pr)) $('#transitions').val(parseInt(add));
	else $('#transitions').val('');
    var pos = $('#pos').val();
	if(pos == 1) var cost = $('#cost_banner_top').val();
	else if(pos == 2) var cost = $('#cost_banner_bottom').val();
	else if(pos == 3) var cost = $('#cost_banner_right_1').val();
	else if(pos == 4) var cost = $('#cost_banner_right_2').val();
	else if(pos == 5) var cost = $('#cost_banner_right_3').val();
	else var cost = $('#cost_banner_top').val();
	var rCost = $('#transitions').val() * cost;
	$('#cost_num').text(rCost);
  },
  send: function(){
    var pos = $('#pos').val();
    var link = $('#link').val();
    var title = $('#title').val();
    var descr = $('#descr').val();
    var src = $('#src').attr('data');
    var transitions = $('#transitions').val();
    var redemption = $('#redemption').val();
    var cat = $('#cat').val();
	mybanners.update();
	if(link != 0){
	  if(title != 0){
	    if(descr != 0){
		  if(transitions != 0){
		    if(src){
		      butloading('sending', 64, 'disabled');
		      $.post('/index.php?go=mybanners&act=buy', {pos: pos, link: link, title: title, descr: descr, transitions: transitions, img: src, cat: cat, redemption: redemption}, function(d){
			    if(d == 1) 
				  $('.err_red').show();
			    else if(d == 2) 
				  addAllErr('Загрузите изображение!', 3300);
			    else {
			      $('.err_red').hide();
			      $('.err_yellow').show();
				  $('#docver').html('');
				  $('#pos, #link, #title, #descr, #transitions').val('');
				  mybanners.update();
			    }
			    butloading('sending', 64, 'enabled', 'Оплатить');
			  });
			} else
	          addAllErr('Загрузите изображение!', 3300);
		  } else
		    setErrorInputMsg('transitions');
		} else
		  setErrorInputMsg('descr');
	  } else
	    setErrorInputMsg('title');
	} else
	  setErrorInputMsg('link');
  },
  save_sett: function(){
    butloading('sending_2', 64, 'disabled');
	$.post('/index.php?go=mybanners&act=save_sett', {cat: $('#cat_v').val()}, function(){
	  $('.err_yellow_2').show();
	  butloading('sending_2', 64, 'enabled', 'Сохранить');
	});
  }
}