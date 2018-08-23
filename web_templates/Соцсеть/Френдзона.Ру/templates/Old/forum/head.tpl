<style>{background}</style>
<script type="text/javascript">
var page = 1;
$(document).ready(function(){
	$(window).scroll(function(){
		if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
			Forum.Page('{id}');
		}
	});
	langNumric('langForum', '{forum-num}', 'тема', 'темы', 'тем', 'тема', 'В сообществе ещё нет тем.');
});
</script>
  <div class="cles_topggg"></div>
  <div class="box_right_owne" style=" margin-top: -10PX;">
  <a href="/public{id}" onClick="Page.Go(this.href); return false;"><div><b>К сообществу</b></div></a>
  <div class="activetab news_a"><a href="/forum{id}" onClick="Page.Go(this.href); return false;"><div><b>Обсуждения</b></div></a></div>
  <a href="/forum{id}?act=new" onClick="Page.Go(this.href); return false;" class="{no}"><div><b>Новая тема</b></div></a>
 </div>
<div class="clear"></div>
<div class="margin_top_10"></div><div class="allbar_title" style="margin-bottom:0px">{forum-num} <span id="langForum">В сообществе ещё нет тем.</span></div>