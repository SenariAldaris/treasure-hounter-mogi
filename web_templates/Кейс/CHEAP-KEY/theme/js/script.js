$(document).ready(function(){
	$.arcticmodal('setDefault', {
		beforeOpen: function(data, el) {
			$('.bg, .header-panel').hide();
		},
		afterClose: function(data, el) {
			$('.bg, .header-panel').fadeIn(300);
		}
	});
	
	$('.tabs-nav').on('click', 'li:not(.active)', function() {
		$(this).addClass('active').siblings().removeClass('active').closest('.tabs').find('.tabs-content').removeClass('active').eq($(this).index()).addClass('active');
	});
});