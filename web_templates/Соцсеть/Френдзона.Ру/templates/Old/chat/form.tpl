<script language="javascript" type="text/javascript">
<!--
var ie=document.all?1:0;
var ns=document.getElementById&&!document.all?1:0;

function InsertSmile(SmileId)
{
    if(ie)
    {
    document.all.message.focus();
    document.all.message.value+=" "+SmileId+" ";
    }

    else if(ns)
    {
    document.forms['guestbook'].elements['message'].focus();
    document.forms['guestbook'].elements['message'].value+=" "+SmileId+" ";
    }

    else
    alert("Ваш браузер не поддерживается!");
}
// -->
</script>

<div style="background: #f5f5f5;padding: 10px;">
<form method="post" name="guestbook">
<textarea name="message" class="videos_input wysiwyg_inpt fl_l im_msg_texta" id="textcom" style="width:330px;height:14px" placeholder="Введите Ваше сообщение.." onkeypress="if(event.keyCode == 10 || (event.keyCode == 13)) chatz.send()"></textarea>

<div class="button_div fl_l" style="margin-left: 30px;margin-top: 2.5px;"><button onclick="chatz.send(); return false" id="msg_send">Отправить</button></div>

<div class="clear"></div>

<table>
<tr>
    <td style="cursor: pointer;" onclick='InsertSmile(":)")'><img src='http://www.kolobok.us/smiles/icq/smile.gif'></td>
    <td style="cursor: pointer;" onclick='InsertSmile("xD")'><img src='http://www.kolobok.us/smiles/icq/biggrin.gif'></td>
    <td style="cursor: pointer;" onclick='InsertSmile("8)")'><img src='http://www.kolobok.us/smiles/icq/cool.gif'></td>
<td style="cursor: pointer;" onclick='InsertSmile(":*")'><img src='http://www.kolobok.us/smiles/icq/kiss.gif'></td>
<td style="cursor: pointer;" onclick='InsertSmile(":P")'><img src='http://www.kolobok.us/smiles/icq/blum1.gif'></td>
</tr>
</table>

</form>
<div class="clear"></div>
</div>