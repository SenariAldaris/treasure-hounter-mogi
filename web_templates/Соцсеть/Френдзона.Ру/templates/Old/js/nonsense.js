var nonsense = {
  login: function(){
    butloading('nonsenseLogin', 87, 'disabled');
	$.post('/index.php?go=nonsense&act=login_one', function(d){
	  if(d == 1){
	    $('.err_red').show();
		$('.err_yellow').hide();
	  } else {
	    $('.err_red, #nonsenseButLogin').hide();
	    $('.err_yellow').html(d).show();
	  }
	  butloading('nonsenseLogin', 87, 'enabled', 'Принять участие');
	  Page.Go('/loto?act=one');
	});
  },
  biletBox: function(){
    viiBox.start();
	$.post('/index.php?go=nonsense&act=bilet_box', function(d){
	  viiBox.win('nonsenseBilte', d);
	});
  },
  selNum: function(i){
	var check = $('#sel_'+i).attr('class').split(' ');
	if(check[1] == 'nonsense_bilet_selected'){
	  $('#sel_'+i).removeClass('nonsense_bilet_selected');
	  $('#selected_numbers').val( $('#selected_numbers').val().replace('|'+i+'|', '') );
	  nonsenseNumSelNum--;
	} else {
	  nonsenseNumSelNum++;
	  if(nonsenseNumSelNum > 6){
	    $('#sel_'+nonsensePrevSelNum).removeClass('nonsense_bilet_selected');
	    $('#selected_numbers').val( $('#selected_numbers').val().replace('|'+nonsensePrevSelNum+'|', '') );
	    nonsenseNumSelNum = 6;
	  }
	  nonsensePrevSelNum = i;
      $('#sel_'+i).addClass('nonsense_bilet_selected');
	  $('#selected_numbers').val('|'+i+'|'+$('#selected_numbers').val() );
	}
	if(nonsenseNumSelNum == 6) $('#nonsesneDivBuyt').show();
	else $('#nonsesneDivBuyt').hide();
  },
  buy: function(){
	if(nonsenseNumSelNum == 6){
	  var selected_numbers = $('#selected_numbers').val();
	  $('#nonsenseNoSel, #nonsenseNoBalance').hide();
	  butloading('nonsenseBuyBut', 93, 'disabled');
	  $.post('/index.php?go=nonsense&act=bilet_buy', {selected_numbers: selected_numbers}, function(d){
	    if(d == 1) $('#nonsenseNoBalance').show();
		else {
		  viiBox.clos('nonsenseBilte', 1);
		  Page.Go('/loto?act=two');
		}
		butloading('nonsenseBuyBut', 93, 'enabled', 'Все верно, купить');
	  });
	} else {
	  var nonNum = 6-nonsenseNumSelNum;
	  if(nonNum == 1) nonGramText = 'число';
	  else if(nonNum > 1 && nonNum <= 4) nonGramText = 'числа';
	  else nonGramText = 'чисел';
	  $('#nonsenseNoBalance').hide();
	  $('#nonsenseNoSel').html('Выберите еще <b>'+nonNum+'</b> '+nonGramText).show();
	}
  },
  page: function(){
    var last_id = $('.nonsense_one_bilet:last').attr('id');
	if($('#load_loto_prev_ubut').text() == 'Показать больше билетов'){
	  textLoad('load_loto_prev_ubut');
	  $.post('/index.php?go=nonsense&act=page_bilet', {last_id: last_id}, function(d){
	    $('#mybilets').append(d);
		if(d) $('#load_loto_prev_ubut').text('Показать больше билетов');
		else $('#loto_prev_ubut').hide();
	  });
	}
  }
}