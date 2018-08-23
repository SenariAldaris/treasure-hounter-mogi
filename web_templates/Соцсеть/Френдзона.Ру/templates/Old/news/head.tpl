<div class="sssswetwwegdasdasdsdasdasdsdas"></div>
	<script src="{theme}/js/jquery.cookie.js"></script>
[news]<script type="text/javascript">
var page_cnt = 1;
$(document).ready(function(){
	music.jPlayerInc();
	$('#wall_text, .fast_form_width').autoResize();
	$(window).scroll(function(){
		if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
			news.page();
		}
	});
});
$(document).click(function(event){
	wall.event(event);
});
</script>
	<script>
		$(document).ready(function() {
			function setState (blockName) {
				$('#shb-'+blockName).find('.block-header').click(function() {
					var blockStateCookie = $.cookie('blockState');
					if (blockStateCookie == null) var blockState = [1, 1, 1, 1, 1];
					else var blockState = blockStateCookie.split('');
					var arrEl = blockName-1;
					if ($(this).parent().is('.hide')) blockState [arrEl] = 1;
					else blockState [arrEl] = 0;
					var blockStateCookie = blockState.join('');
					$.cookie('blockState', blockStateCookie, { expires: 10000, path: '/' });
					
					$('.cookie-h').text('Кука «blockState» записана и равна: ' + blockStateCookie);
				});
			};
			function restoreState (blockName) {
				var arrEl = blockName-1,
					blockStateCookie = $.cookie('blockState');
				if (blockStateCookie != null) {
					blockState = blockStateCookie.split('');
					if (blockState [arrEl] == 0) { 
						$('#shb-'+blockName).addClass('hide');
					}
				
					$('.cookie-h').text('Кука «blockState» записана и равна: ' + blockStateCookie);
				}
			};		
			restoreState ('1'); setState ('1');
			restoreState ('2'); setState ('2');
			restoreState ('3'); setState ('3');
			restoreState ('4'); setState ('4');
			restoreState ('5'); setState ('5');
			$('.block-header').each(function() {
				var thisBlock = $(this);
				var parentBlock = thisBlock.parent();
				var element = parentBlock.find('.block-body');

				thisBlock.click(function(){
					if(parentBlock.hasClass('hide')){
						element.slideDown(300).animate(200);
						parentBlock.removeClass('hide');
					}
					else {
						element
							.animate(200)
							.slideUp(300, function() {
											parentBlock.addClass('hide');
						 				   });
					}
				});
			});	
		});
	</script>
<style>.newcolor000{color:#000}</style>
<style type="text/css" media="all">
.active_news {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="type" value="{type}" />

<div class="box_right_owne" style=" margin-top: -7px;">

 <div class="{activetab-} news_a_owne"><a href="/news" onClick="Page.Go(this.href); return false;"><div>Новости</div></a></div>
 <div class="{activetab-notifications} news_a_owne"><a href="/news/notifications" onClick="Page.Go(this.href); return false;"><div>Ответы</div></a></div>
 <div class="{activetab-photos} news_a_owne"><a href="/news/photos" onClick="Page.Go(this.href); return false;"><div>Фотографии</div></a></div>
 <div class="{activetab-videos} news_a_owne"><a href="/news/videos" onClick="Page.Go(this.href); return false;"><div>Видеозаписи</div></a></div>
 <div class="{activetab-updates} news_a_owne"><a href="/news/updates" onClick="Page.Go(this.href); return false;"><div>Обновления</div></a></div>
   <div class=" news_a_owne"><a href="/miss" onClick="Page.Go(this.href); return false;"><div>Мисс сайта</div></a></div>
  <div class=" news_a_owne"><a href="/index.php?go=compare" onClick="Page.Go(this.href); return false;"><div>Фото-дуэли</div></a></div>
</div>
<div class="clear"></div>[/news]
<div class="iit_claess"></div>

[bottom]<span id="news"></span>
[bottom]<span id="news"></span>
<div onClick="news.page()" id="wall_l_href_news" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="loading_news" style="width:750px">Показать предыдущие новости</div></div>[/bottom]