<div class="cles_topggg"></div><div class="box_right_owne" style=" margin-top: -7px">
<a href="/support" onClick="Page.Go(this.href); return false;"><div><b>[group=4]Вопросы от пользователей[/group][not-group=4]Мои вопросы[/not-group]</b></div></a>
<div class="activetab news_a"><a href="/support?act=show&qid={qid}" onClick="Page.Go(this.href); return false;"><div><b>Просмотр вопроса</b></div></a></div>
</div>
<div class="note_full_title" style="min-height: 27px; margin-top: 7px; border-bottom: 3px solid rgb(0, 139, 200); background: none repeat scroll 0% 0% transparent;">

 <div class="ava_mini_no_sow" style="float:width:60px"><a href="/u{uid}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" title="" /></a></div>
 <div class="box_swqrclears">
 <span><a href="/support?act=show&qid={qid}" onClick="Page.Go(this.href); return false">{title}</a></span><br />
 <div id="status">{status}</div>
 <span class="uuu"><a href="/" onClick="support.delquest('{qid}'); return false">Удалить вопрос</a></span>
</div></div>
<div class="note_text">
<div style="float:left;width:571px;margin-bottom:10px">
<div class="walltext">
 <div style="padding-left:2px">
  {question}
  <br /><span class="color77777">{date}</span> 
 </div>
</div>
</div>
</div>
<div class="clear"></div>
<div id="answers">{answers}</div>
<div class="note_add_bg clear support_addform">
<div class="ava_mini_add">
 [group=4]<img src="{theme}/images/support.png" alt="" />[/group]
 [not-group=4]<a href="/u{uid}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" /></a>[/not-group]
</div>
<textarea 
	class="videos_input wysiwyg_inpt fl_l" 
	id="answer" 
	style="width:471px;height:78px;color:#c1cad0;resize:none;"
	onblur="if(this.value==''){this.value='Комментировать..';this.style.color = '#c1cad0';}" 
	onfocus="if(this.value=='Комментировать..'){this.value='';this.style.color = '#000'}"
>Комментировать..</textarea>
<div class="clear"></div>
<div class="button_div fl_l" style="margin-left:60px"><button onClick="support.answer('{qid}', '{uid}'); return false" id="send">Отправить</button></div>
[group=4]<div class="button_div_nostl fl_r" id="close_but"><button onClick="support.close('{qid}'); return false" id="close">Закрыть вопрос</button></div>[/group]
<div class="clear"></div>
</div>