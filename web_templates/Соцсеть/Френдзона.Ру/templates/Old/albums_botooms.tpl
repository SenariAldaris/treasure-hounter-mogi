<script type="text/javascript">
$(document).ready(function(){
window.search_loading = false;
	window.search_page = 1;
	var search_handler = function(){
		if (!search_loading && $(document).height() - ($(window).scrollTop() + $(window).height()) < 500) {
			search_loading = true;
			$('.search_loading').show();
			var query = decodeURI((RegExp('query=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
			var type = decodeURI((RegExp('type=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
			if (query == 'null') {
				query = '';
			}
			if (type == 'null') {
				type = 1;
			}
			if (type == 1) {
				var user_photo = decodeURI((RegExp('user_photo=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
				var ad_params = '';
				$.each(params_list, function(i, v){
					if (eval(v) != 'null') {
						ad_params = ad_params +  '&' + v + '=' + eval(v);
					}
				});
			}
			$.post('/index.php?go=search&type=' + type + '&query=' + query + '&page=' + ++search_page + ad_params, {"ajax": "yes"}, function(d){
				if (d == 'last_page') {
					$(window).unbind('scroll', search_handler);
					return;
				}
				$('{block_id}:last').after(d);
				search_loading = false;
				$('.search_loading').hide();
			});
		}
	};
	$(window).scroll(search_handler);
});
</script>
[phet]
<div style="float: left; padding: 20px;margin-bottom: 3px; background-color: rgb(89, 123, 165); color: rgb(255, 255, 255); font-weight: bold; margin-top: 0px; margin-left: 3px; width: 531px;">
<span style="float:left;">
Последние загруженные фотографии</span>
  <style>
  .noMarg{margin:1px; float:left;}
  </style>
  </div>
  <div class="photo_container">
{fv_photo}
</div>
  <div class="clear"></div>[/phet]
