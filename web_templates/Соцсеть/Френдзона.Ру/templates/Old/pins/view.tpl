<style>
.miniature_pos{padding: 0}
</style>

<div class="miniature_boxkid" >

	<div class="miniature_pos_pins">
		<div class="pins_header">
			<div class="fl_l ss_box_pins">
				<div class="fl_l"><a href="/u{uid}"><img src="{ava}"></a></div>
				<span class="top_pinsw"><a href="/u{uid}">{name}</a></span>
				<span class="bor_pins">Загруженно {date} в {category}</span>
							<div class="close_profile_photos" onclick="viiBox.clos('view', 1)" style="margin-right: 11px; float: right; margin-top: -8px;"></div>
			</div>

			<div class="clear"></div>
		</div>
		<div style="margin-top: 10px">
			<center><img src="{photo}">
				<div style="padding-top: 2px; margin-left:9px; font-size: 11px">{descr}</div>
			<div class=" pins_share_but" onClick="pins.share({id})" id="pins_share_but">Поделиться</div>
			<div class=" pins_share_but" style="display:none" id="pins_share_but_yes">Успешно</div>
			</center>
					
		
			
		</div>

		<div class="fl_r" id="like_block" style="margin-top: -40px; margin-right: 40px"></div>
		<div class="clear"></div>
		<div class="pins_comment">
			{comments}
			<div id="add_comm"></div>
			{comm_butt}
		</div>
		<div class="pins_comm_block">
			<div class="fl_l"><a href="/u{my-id}" onClick="Page.Go(this.href)"><img src="{my-ava}"></a></div>
			<div class="fl_l"><textarea class="ui-TextField" placeholder="Добавить комментарий..." id="pins_text"></textarea></div>
			<div class="bur_add" style="margin-left: 0;margin-top: 56px"><button  onClick="pins.comm_send({id})">Комментировать</button></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="miniature_boxlose"onclick="viiBox.clos('view', 1)"></div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	likes.init({id}, 'pin', 'like_block');
});
var pins_comment_page = 1;
function show_more_comment(id){
	$.post('/index.php?go=pins&act=more_comment', {id: id, page: pins_comment_page}, function(d){
		pins_comment_page++;
		if(d) $('.pins_once_comment_block:last').after(d);
		else $('#likes_more').remove();
	});
}
</script>
