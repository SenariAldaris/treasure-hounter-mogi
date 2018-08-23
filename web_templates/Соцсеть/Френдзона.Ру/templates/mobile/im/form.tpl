<div class="wallformbg" style="margin-top:-10px;margin-bottom:10px;border-bottom:1px solid #EFEFEF"> 
<div style="padding:10px"><textarea id="msg_text" class="wall_fast_text inp"></textarea>
<button class="button" onClick="im.send('{for_user_id}', '{my-name}', '{my-ava}')">Отправить</button> <a href="/messages" onClick="im.open('{for_user_id}'); return false">Обновить переписку</a>
</div></div>

<input type="hidden" id="for_user_id" value="{for_user_id}" />