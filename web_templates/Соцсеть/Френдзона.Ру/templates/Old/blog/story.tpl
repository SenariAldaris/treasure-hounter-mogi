<script type="text/javascript">
$(document).ready(function(){
	$('.blog_left_tab').css('min-height', ($('.blog_left_tab').height()+10)+'px').css('height', ($('.blog_left').height()+10)+'px');
});
</script><div class="clear_top"></div>
<div class="box_newx"></div>
<div class="box_right_owne" style="position: absolute;margin-top: -8px;  background: none repeat scroll 0 0 rgba(0, 0, 0, 0); border-left: 5px solid rgba(0, 0, 0, 0);">
<div class="news_text">Новости</div>
 {last-news}
 [group=1]<br />
 <div class="news_text">Меню</div>
 <a href="?act=add" onClick="Page.Go(this.href); return false">Добавить новость</a>
 <a href="" onClick="blog.del('{id}'); return false">Удалить новость</a>
 <a href="?act=edit&id={id}" onClick="Page.Go(this.href); return false">Редактировать новость</a>
 [/group]
</div>
<div class="one_note">
<div class="notes_ava"><img src="{theme}/images/no_ava_groups.png" alt="" /></div>
<br />
<div class="wallauthoruu_name" style="  margin-top: -18px;"><a  href="/blog?id={id}" onClick="Page.Go(this.href); return false">{title}</a> </div>
<div class="wallauthoruu_name">{date}</div>
</div>
<div class="note_text clear" style=" width: 565px;">{story}</div>
