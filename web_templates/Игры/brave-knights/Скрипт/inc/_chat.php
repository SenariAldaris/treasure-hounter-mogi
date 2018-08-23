<?php
if(!isset($_SESSION["user"]))
	return;
	
header("Content-type: text/html; charset=utf-8");
$db->query("SET NAMES utf8");
?>
<script type="text/javascript" src="/js/cookies.js" /></script>
<script type="text/javascript">
function insert_comm(open, close, no_focus)
{
  msgfield = (document.all) ? document.all.forma_com : document.forms['form_com']['comment'];
  if (document.selection && document.selection.createRange)
  {
    if (no_focus != '1' ) msgfield.focus();
	sel = document.selection.createRange();
	sel.text = open + sel.text + close;
	if (no_focus != '1' ) msgfield.focus();
	}else if (msgfield.selectionStart || msgfield.selectionStart == '0'){
	  var startPos = msgfield.selectionStart;
	  var endPos = msgfield.selectionEnd;
	  msgfield.value = msgfield.value.substring(0, startPos) + open + msgfield.value.substring(startPos, endPos) + close + msgfield.value.substring(endPos, msgfield.value.length);
	  msgfield.selectionStart = msgfield.selectionEnd = endPos + open.length + close.length;
	  if (no_focus != '1' ) msgfield.focus();
	    }else{
		msgfield.value += open + close;
		if (no_focus != '1' ) msgfield.focus();
		}return;}
		
		function reset_chat(){
			$.ajax({
				type: "POST",
				url: "/ajax/chat.php?p=get",
				data: "",
				success: function(result){
					if($("#chat .history").html() != result)
						$("#chat .history").html(result);					
				}
			});
		}
		
		function reset_warning(){
			$("#chat .bbcode #warnings").text('');
		}
		
		function swich_close(){
			$('body').css('padding-bottom', '7px');
			$('#chat').css('bottom', '-150px');
			$.cookie('swich', 'close');
		}
		
		function swich_open(){
			$('body').css('padding-bottom', '157px');
			$('#chat').css('bottom', '-0px');
			$.cookie('swich', 'open');
		}
		
		$(function(){	
		
			reset_chat();
			
			setInterval(reset_chat, 7000);
			setInterval(reset_warning, 9000);
								
			$('#chat #form_com').submit(function(e){
				e.preventDefault();	
				$.ajax({
					type: "POST",
					url: "/ajax/chat.php?p=send",
					data: $('#chat #form_com').serialize(),
					success: function(result){
						$("#chat .bbcode #warnings").html(result);
						if(result == '<span style="color:#0f0">Сообщение отправлено</span>'){
							$('#chat .message input[name="comment"]').val('');
							reset_chat();
						}
					}
				});					
						
			});
			
			$('#chat .history .user').click(function(){
				$('#chat .message input[name="comment"]').val($(this).text() + $('#chat .message input[name="comment"]').val());
			});
			
		});
</script>
<style type="text/css">
#chat{position:fixed; 
bottom:<?php
if(!isset($_SESSION['chathide']))
	$_SESSION["chathide"] = false;

if(isset($_GET['chats'])){
	if($_SESSION['chathide'] == false)
		$_SESSION["chathide"] = true;
	else
		$_SESSION["chathide"] = false;
}

echo $_SESSION['chathide'] == false?'10':'-155';
?>px; left:50%; margin-left:-490px; height:200px; width:1002px; z-index:1; background:#d6eed5; border:1px solid #fff; border-radius:5px; outline:1px solid #b8ddb5; box-shadow: #000 0px 0px 3px 0px;}
#chat .history{height:110px; border-bottom:1px solid #fff; font-size:14px; padding:2px; overflow: auto; line-height:20px;}
#chat .swich{position:absolute; display:block; right:-2px; top:-31px; cursor:pointer; height:33px; width:155px; background:url(/img/chat/swich.png); text-align:center; line-height:33px;}
#chat .history .user{font-weight:900; color:00f; text-decoration:underline; cursor:pointer;}
#chat .history .user:hover{text-decoration:none;}
#chat .history .to{background:#a4c5a3;}
#chat .history .private{color:#f00;}
#chat .history .time{color:#999;}
#chat .history img{vertical-align:middle;}
#chat .bbcode, #chat .message{height:36px; line-height:25px; border-bottom:1px solid #fff;}
#chat .bbcode{padding:0 10px; color:#fff;}
#chat .bbcode img{padding:0 1px; vertical-align:middle; cursor:pointer;}
#chat .bbcode #warnings{font-weight:900;}
#chat .message input[name="comment"]{height:28px; width:865px; padding:0; margin:10px 10px; font-size:15px;}
#chat .message input[name="message_sub"]{height:28px; width:106px; border:1px solid #fff;}
</style>
<div id="chat">
	<a href="/index.php?chats" class="swich">Свернуть/Развернуть</a>
	<div class="history">Загрузка...</div>
	<div class="bbcode">
		<img onclick="insert_comm('','*smile*')" src="/img/chat/smile/smile.gif" alt="" />
		<img onclick="insert_comm('','*sadness*')" src="/img/chat/smile/sadness.gif" alt="" />
		<img onclick="insert_comm('','*laugh*')" src="/img/chat/smile/laugh.gif" alt="" />
		<img onclick="insert_comm('','*wonder*')" src="/img/chat/smile/wonder.gif" alt="" />
		<img onclick="insert_comm('','*tongue*')" src="/img/chat/smile/tongue.gif" alt="" />
		<img onclick="insert_comm('','*dance*')" src="/img/chat/smile/dance.gif" alt="" />
		<img onclick="insert_comm('','*THUMBS_UP*')" src="/img/chat/smile/THUMBS_UP.gif" alt="" />
		
		
		<img onclick="insert_comm('','*kez_02*')" src="/img/chat/smile/kez_02.gif"  alt="" />
		<img onclick="insert_comm('','*alvarin_34*')" src="/img/chat/smile/alvarin_34.gif" alt="" />
		<img onclick="insert_comm('','*drag_06*')" src="/img/chat/smile/drag_06.gif" alt="" />
		<img onclick="insert_comm('','*kidrock_07*')" src="/img/chat/smile/kidrock_07.gif" alt="" />
		<img onclick="insert_comm('','*dont*')" src="/img/chat/smile/dont.gif" alt="" />
		|
		<span id="warnings"></span>
	</div>
	<div class="message">
		<form id="form_com" action="#form_com" method="post">
			<input type="text" id="comment" name="comment" maxlength="255" />
			<input type="hidden" name="to" />
			 <input type="submit" name="message_sub" value="Отправить" />
		</form>
	</div>
</div>