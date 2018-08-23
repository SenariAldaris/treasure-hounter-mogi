
 
    // Sliding Topbar Lang Menu
    var menu = $('#topbar-dropmenu');

    // Toggle menu and active class on flag click
    $('.topbar-menu-toggle').on('click', function() {

        // Toggle menu and active class on flag click
        menu.slideToggle(230).toggleClass('topbar-menu-open');
        $('#topbar-dropmenu').addClass('animated animated-short fadeInDown').css('opacity', 1);

    });
	
///////////////////////////////////////////////////////////////////////////
	 
	// Scroll to top
	$('.footer-to-top').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});

///////////////////////////////////////////////////////////////////////////
	
	// File upload
	$('#fileselectbutton').click(function(e){
		$("#file").trigger('click');
	  });
	 $('#file').change(function(e){
	  var val = $(this).val(); 
	  var file = val.split(/[\\/]/);
	  $('#filename').val(file[file.length-1]);
	 });

	 $('#fileselectbutton2').click(function(e){
		$("#file2").trigger('click');
	  });
	 $('#file2').change(function(e){
	  var val = $(this).val(); 
	  var file = val.split(/[\\/]/);
	  $('#filename2').val(file[file.length-1]);
	 });
	 
///////////////////////////////////////////////////////////////////////////

	// Nofication Close Buttons 
	$('.notification a.close').click(function(e){
		e.preventDefault();

		$(this).parent('.notification').fadeOut();
	});

///////////////////////////////////////////////////////////////////////////

	// Check All Feature
	$(".check-all").click(function(){
		$("table input[type=checkbox]").attr('checked', $(this).is(':checked'));
	});

///////////////////////////////////////////////////////////////////////////

	// Prevent elements classed with "no-link" from linking
	$(".no-link").click(function(e){ e.preventDefault();});

///////////////////////////////////////////////////////////////////////////
	
  //SLIMSCROLL 
  $('.scroll').slimScroll({
		height: '380px',
		size: '3px',
		color: '#609cec'
  });

$("input").attr("autocomplete", "off"); 





