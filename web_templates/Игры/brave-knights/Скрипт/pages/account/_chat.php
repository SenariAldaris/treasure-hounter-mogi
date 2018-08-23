<?php
define('TIME', time());

header("Content-Type: text/html; charset=windows-1251");

function relative_date_chat($t, $rdl = '<br />') 
{
  $reldays = ($t - strtotime(date('d.m.Y'))) / 86400;
    
  if ($reldays >= 0 && $reldays < 1)
  { 
    return '<b>Сегодня</b>'.$rdl.date('H:i:s', $t);
  }  
  else if ($reldays >= -1 && $reldays < 0)
  { 
    return '<b>Вчера</b>'.$rdl.date('H:i:s', $t);
  }  
  else 
  {     
    return date('d.m.Y', $t).$rdl.date('H:i:s', $t);     
  }  
}

$db->Query("SELECT * FROM db_users_a WHERE id = '".$_SESSION['user_id']."'");
$users_info = $db->FetchAssoc();

if (isset($_GET['noban']) && $users_info['chat_moder'])
{
  $db->Query("UPDATE db_users_a SET ban_chat = '0' WHERE `id` = '".(int)$_GET['noban']."'");
} 

//print_r($users_info['ava']);


?>
<script type="text/javascript" src="http://yandex.st/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="/js/chat.js"></script>
<script type="text/javascript" language="JavaScript">
function message_to_user(user)
{
  var name = "<?php echo $users_info['user']; ?>";
  if (user != name)
  {
    $("#tr-message-user").show();
    $("#message-to-user").text(user);
  }  
} 
$(document).ready(function() {
   setInterval(function(){ refresh($('.chat-message-block:last').attr('id')); }, '5000');
   scroll();
   
});</script>
<?php

$smile = isset($_COOKIE['chsmile']) ? (int)$_COOKIE['chsmile'] : 0;
$sound = isset($_COOKIE['chsound']) ? (int)$_COOKIE['chsound'] : 1;
$scroll = isset($_COOKIE['chscroll']) ? (int)$_COOKIE['chscroll'] : 1;
?>
  <style>
   #chat {
/*    height: 400px;*/
    margin: 0px 0px 10px 0px;
    text-decoration: none;
    font-style: normal;
   }
   
.block222 {
    background: url('/img/block2.png') repeat-y;
    position: relative;
    z-index: 10;
    left: 50%;
    margin-left: -160px;
    padding: 0px 40px 0px 45px;
    float: center;
   margin-bottom: -10px;
    
    color: #000000;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10pt;
    width: 570px;
}

   #chat-online {
    height: 400px;
	  width: 130px;
	  border-right: #904A1E solid 1px;
	  overflow: auto;
	  float: left;
   }
   
   .chat-online-block {
    padding: 0px;
    border-bottom: #904A1E solid 1px;
   }
   
   .chat-online-name {
    font-weight: bold;
    color: #008011;
    cursor: pointer;
    font-size: 14px;
    display: inline-block;
    margin-left: 10px;
   }
   
   #chat-message {
    height: 400px;
    width: 430px;
	  overflow: auto;
	  float: left;
    margin-left: 5px;
   }
   
   .chat-message-block {    
    padding-left: 10px;
	  border-bottom: 1px solid #904A1E;
   }
   
   .chat-message-blockleft {
    float: left;
    width: 80px;
   }
   
   .chat-message-blockright {
    float: right;
   }
   
   .chat-message-name {
    font-weight: bold;
    color: #008011;
    font-size: 14px;
    cursor: pointer;
/*    display: block;*/
/*    border: 1px solid black;*/
   }
   
   .chat-message-time {
    font-size: 12px;
    color: #904A1E;
   }
   
   .chat-message-text {
    color: #000000;
    font-size: 14px;
/*    display: inline-block;*/
	  width: 280px;

    float: left;
/*    border: 1px solid;*/
   
   }
   
   .chat-clear {
    clear: both;
   }
   
   .private-check {
    float: right;
    margin-top: 4px;
    margin-right: 5px;
   }
   
   .chat-control-smile, .chat-control-sound, .chat-control-scroll {
    margin-right: 10px;
    cursor: pointer; 
    float: right;
    width: 16px;
    height: 16px;
    
   }
   
   .chat-ban {
    width: 16px;
    height: 16px;
    display: inline-block;
    float: right;
    cursor: pointer;
    background: url('/img/ban.png');
   }
   
   .chat-ban-time {
    font-size: 14px;
    color: #114C5B;
    width: 60px;
   }
   
   .ch-scroll-yes {
     background: url('/img/scroll.png');
   }
   
   .ch-scroll-no {
     background: url('/img/noscroll.png');
   }
   
   .ch-smile-yes {
     background: url('/img/smile.png');
   }
   
   .ch-smile-no {
     background: url('/img/nosmile.png');
   }
   
   .ch-sound-yes {
    background: url('/img/sound.png');
   }
   
   .ch-sound-no {
    background: url('/img/nosound.png');
   }
   
   .btn-bold, .btn-uline, .btn-italic, .btn-url {
    float: left;
    display: block;
    height: 24px;
    width: 22px;
    outline: none;
    border: none;
    margin: -1px 0 -3px 0;
    padding-right: 2px;
    cursor: pointer;
    color: #fff;
    font: 12px arial, tahoma, verdana;
    text-align: center;
    line-height: 1.9;
    text-shadow:1px 1px 1px #547d1e;
    background: url(/img/btn-text.png) no-repeat left top;
}
.btn-bold {
    font-weight: bold;
}
.btn-uline {
    text-decoration: underline;
}
.btn-italic { 
    font-style: italic;
    width: 21px;
    padding-right: 3px;
}
.btn-url { 
    line-height: 1.8;
    font-family: tahoma, arial, verdana;
    background: url(/img/btn-text-long.png) no-repeat left top;
    width: 46px;
}
.btn-bold:hover, .btn-uline:hover, .btn-italic:hover, .btn-url:hover {
    background-position: left bottom;
    text-shadow:1px 1px 1px #b44d1c;
}

table.profile tbody td input.scount {
  color: #FFF;
  text-align: right;
  font: 11px Tahoma, Arial, sans-serif;
  padding: 1px 0;
  border: none;
  padding-top: 4px;
  padding-left: 10px;
  background: none;
  cursor: auto;
  box-shadow: none;
}

table.profile {
    border-collapse: collapse;
    margin-bottom: 10px;
    border: none;
    border-spacing: 0;
    padding: 0;
    width: 100%; 
/*    margin-left: 10px;*/
}

table.profile tbody td {
  text-align: left;
  font-size: 13px;margin-right: 10px;
  padding: 6px 20px 6px 10px;
  border-bottom: solid 1px #292929;
  background-color: #A99D73;
}

table.profile tbody td input.val {
    font: 12px Tahoma, Arial, sans-serif;
    width: 96%;
    padding: 2px 4px;
    border: 1px solid #8B9DA6;
}

table.profile tbody td.value {
  font-size: 12px;
  color: #E7F50E;
  padding: 5px 10px;
  background-color: #A99D73;
  border-bottom: solid 1px #292929;
}

table.profile tbody td input.scount:focus {
 color: #68A0BF;
    text-align: right;
    font: 11px Tahoma, Arial, sans-serif;
    padding: 1px 0;
    border: none;
    padding-top: 4px;
    padding-left: 10px;
    background: none;
    cursor: auto;
    box-shadow: none;
}

.scon-delete {
    height: 16px;
    width: 16px;
    display: block;
    border: none;
    outline: none;
    cursor: pointer;
    float: right;
    margin-right: 3px;
    margin-top: 3px;
    margin-left: 5px;
}

.msgbox-error {
    font-size:14px;
    color:#fff;
    text-align:center;
    text-shadow:1px 1px 1px #913807;
    background-color:#F35C0B;
    display:block;
    margin-bottom:10px;
    padding:10px 20px;
    margin-left: 10px;
}

.msgbox-success {
    font-size:14px;
    color:#fff;
    text-align:center;
    text-shadow:1px 1px 1px #3B6900;
    background-color:#5B9F00;
    display:block;
    margin-bottom:10px;
    padding:10px 20px;
    margin-left: 10px;
}

.banan {
 text-decoration: line-through;
}

.scon-delete { background: url(/img/cross.png) no-repeat left top; }

#message-admin {
/* height: 100px;*/
/* border: 1px solid #00649E;*/
 margin-bottom: 30px;
}

.truuu {
 width: 95%; 
 color: #00649E; 
 margin: 0 auto; 
 display: block; 
 padding: 5px; 
 resize: none; 
}
   
  </style> 
<audio id="sound-message-send" preload="auto">
 <source src="/audio/beep.mp3" />
</audio>
<audio id="sound-message-get" preload="auto">
 <source src="/audio/icq.mp3" />
</audio> 
<audio id="sound-message-error" preload="auto">
 <source src="/audio/error.wav" />
</audio>   
 <audio id="sound-message-new" preload="auto">
 <source src="/audio/stuk.wav" />
</audio>   
  
<div class="block1
"><div class="h-title1
">Стена общения</div></div>

<div class="block222">


<div id="chat">
<div class="some-content-related-div">
<div id="inner-content-div">
 <div id="chat-online">

  <?php 
  $db->query("DELETE FROM db_chat_online WHERE time_add < '".(TIME - 15)."'");	
        
  $db->query("SELECT * FROM db_chat_online");	
  
  $user_is = 0;
  
  $count_online = 0;
  
  if ($db->NumRows())
  {
    $count_online = $db->NumRows(); 
   
    while($row = $db->FetchAssoc())
    {
      if ($row['user_id'] == $_SESSION['user_id'])
      {
        $user_is = 1;        
      } 
       
      $banan = ($row['banan']) ? 'text-decoration: line-through;' : '';
      
      ?>
      <div name="chat-online-name" class="chat-online-block">
       <img src="/<?php if ($row['ava'] != '') { echo $row['ava']; } else { echo 'noavatar.png'; }; ?>" style="width: 28px; height: 28px;"/>
       <div class="chat-online-name" style="color: <?php if ($row['status'])  { echo 'red'; } ?>; <?php echo $banan; ?>" onclick="message_to_user(this.innerHTML);" title="Сообщение пользователю <?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></div>
       <?php if ($users_info['chat_moder'] && $row['user_id'] != $_SESSION['user_id'] && !$row['status']) { ?><span class="chat-ban" onclick="chat_ban(<?php echo $row['user_id']; ?>, this);"></span><?php } ?>
      </div>    
      <?php
      
    }   
  } 
  
  if (!$user_is)
  {
    $db->query("INSERT INTO db_chat_online
        (
          `user_id`,
          `user_name`,
          `ava`,
          `time_add`,
          `status`,
          `banan`
        )
        VALUES
        (
          '".$_SESSION['user_id']."',
          '".$users_info['user']."',
          '".$users_info['ava']."', 
          '".TIME."',
          '".$users_info['chat_moder']."',
          '".$users_info['ban_chat']."' 
        )");
    $banan = ($users_info['ban_chat']) ? ' text-decoration: line-through;' : '';
    
    ?>
    <div name="chat-online-name" class="chat-online-block"><img src="/<?php if ($users_info['ava'] != '') { echo $users_info['ava']; } else { echo 'noavatar.png'; }; ?>" style="width: 28px; height: 28px;"/><div class="chat-online-name" style="color: <?php if ($users_info['chat_moder'])  { echo 'red'; } ?>; <?php echo $banan; ?>" onclick="message_to_user(this.innerHTML);" title="Сообщение пользователю <?php echo $users_info['user']; ?>"><?php echo $users_info['user']; ?></div></div>
    <?php 
    
    $count_online ++;
  }
  else
  {
    $db->query("UPDATE db_chat_online SET time_add = '".TIME."' WHERE user_id = '".$_SESSION['user_id']."'");           
  }
  ?>  
 </div>
 <div id="chat-message">

  <?php
  $db->query("SELECT * FROM db_chat_message ORDER BY id ASC");	
  
  if ($db->NumRows())
  {
    while($row = $db->FetchAssoc())
    {
      
        if ($row['private'] && ($users_info['user'] != $row['user_to_name'] && $users_info['user'] != $row['user_name']))
        {
          continue;
        }
        
       
      ?>
      <div id="<?php echo $row['id']; ?>" class="chat-message-block">
       <div class="chat-message-blockleft">
        <span class="chat-message-name" style="color: <?php if ($row['user_status'])  { echo 'red'; } ?>;" onclick="message_to_user(this.innerHTML);"><?php echo $row['user_name']; ?></span><br>
        <img src="/<?php if ($row['ava'] != '') { echo $row['ava']; } else { echo 'noavatar.png'; }; ?>" style="width: 28px; height: 28px;"/><br>
        <span class="chat-message-time"><?php echo relative_date_chat($row['time_add'], $rdl = '<br />'); ?></span>
       </div>
       <div class="chat-message-blockright">
        <span class="chat-message-text"><?php echo iconv('UTF-8', 'WINDOWS-1251', base64_decode($row['message'])); ?></span><?php if ($users_info['chat_moder']) { ?><span class="scon-delete" title="Удалить" onclick="delmsg(<?php echo $row['id']; ?>);"></span><?php } ?>
       </div>
       <div class="chat-clear"></div>
      </div>
      <?php
    }
    
    if ($db->NumRows() > 50)
    {
      $db->query("DELETE FROM db_chat_message WHERE time_add < '".(TIME - 86400)."'");	    
    } 
  }  
  ?>  
 </div>
 <div style="clear: both;"></div>
</div>
<input id="count-online" type="hidden" name="c_online" value="<?php echo $count_online; ?>" />
<form name="mailform">
 <table class="profile">
  <tbody>
   <tr id="tr-message-user" style="display: none;">
    <td>Сообщение для:</td>
    <td class="value"><span id="message-to-user"></span><span class="scon-delete" title="Удалить" onclick="$('#message-to-user').text(''); $('#tr-message-user').hide(); return false;"></span><input class="private-check" type="checkbox" name="private" value="1" title="Сообщение только указанному собеседнику" /><span style="display: inline-block; float: right; margin-right: 5px;">Приват:</span></td>
   </tr>
   <tr>
    <td>
     <span class="btn-bold" title="Выделить жирным" onclick="javascript:mailappendtag('[b]', '[/b]');">Ж</span>
     <span class="btn-italic" title="Выделить курсивом" onclick="javascript:mailappendtag('[i]', '[/i]');">К</span>
     <span class="btn-uline" title="Выделить подчёркиванием" onclick="javascript:mailappendtag('[u]', '[/u]');">Ч</span>
     <span class="btn-url" title="Выделить URL" onclick="javascript:mailappendtag('[url]', '[/url]');">URL</span>     
    </td>
    <td>
     <input class="scount" name="scount" size="25" maxlength="25" value="Осталось 255 символов" readonly="readonly" type="text">    
     <span class="chat-control-smile <?php if (!$smile) { echo 'ch-smile-no'; } else { echo 'ch-smile-yes'; } ?>" title="Показать/Скрыть смайлы" onclick="chat_control('smile');"></span>
     <span class="chat-control-sound <?php if (!$sound) { echo 'ch-sound-no'; } else { echo 'ch-sound-yes'; } ?>" title="Включить/Выключить звук" onclick="chat_control('sound');"></span>
     <span class="chat-control-scroll <?php if (!$scroll) { echo 'ch-scroll-no'; } else { echo 'ch-scroll-yes'; } ?>" title="Включить/Выключить автопрокрутку" onclick="chat_control('scroll');"></span>
    </td>
   </tr>
   <tr>
    <td class="value" colspan="2">    
     <input id="message" placeholder="Для отправки сообщения нажмите < ENTER >" style="padding: 5px; width: 98%;" name="message" onkeyup="descchange(this);" value="" />
    </td>
   </tr>
  </tbody>
 </table>
 <table <?php if (!$smile) { echo 'style="display: none;"';} ?> class="smiles" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td class="smile"><img src="/smiles/aa.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile01}')" /></td>
         <td class="smile"><img src="/smiles/bj.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile31}')" /></td>
         <td class="smile"><img src="/smiles/ab.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile02}')" /></td>
         <td class="smile"><img src="/smiles/ac.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile03}')" /></td>
         <td class="smile"><img src="/smiles/ad.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile04}')" /></td>
         <td class="smile"><img src="/smiles/ae.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile05}')" /></td>
         <td class="smile"><img src="/smiles/af.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile06}')" /></td>
         <td class="smile"><img src="/smiles/ah.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile07}')" /></td>
         <td class="smile"><img src="/smiles/ai.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile08}')" /></td>
         <td class="smile"><img src="/smiles/cp.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile27}')" /></td>
        </tr>
        <tr>
         <td class="smile"><img src="/smiles/am.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile12}')" /></td>
         <td class="smile"><img src="/smiles/shuher.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile32}')" /></td>
         <td class="smile"><img src="/smiles/aq.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile13}')" /></td>
         <td class="smile"><img src="/smiles/ar.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile14}')" /></td>
         <td class="smile"><img src="/smiles/at.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile15}')" /></td>
         <td class="smile"><img src="/smiles/ay.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile16}')" /></td>
         <td class="smile"><img src="/smiles/cs.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile17}')" /></td>
         <td class="smile"><img src="/smiles/be.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile19}')" /></td>
         <td class="smile"><img src="/smiles/bm.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile21}')" /></td>
         <td class="smile"><img src="/smiles/bp.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile22}')" /></td>
        </tr>
        <tr>
         <td class="smile"><img src="/smiles/bs.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile23}')" /></td>
         <td class="smile"><img src="/smiles/tos.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile33}')" /></td>
         <td class="smile"><img src="/smiles/bt.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile24}')" /></td>
         <td class="smile"><img src="/smiles/cb.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile25}')" /></td>
         <td class="smile"><img src="/smiles/ak.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile10}')" /></td>
         <td class="smile"><img src="/smiles/redbul.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile28}')" /></td>
         <td class="smile"><img src="/smiles/bv.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile30}')" /></td>
         <td class="smile"><img src="/smiles/ba.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile18}')" /></td>
         <td class="smile"><img src="/smiles/aj.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile09}')" /></td>
         <td class="smile"><img src="/smiles/az.gif" border="0" alt="" onclick="javascript:AppendSmile('{smile26}')" /></td>
        </tr>
       </table>
</form>
<div id="entermsg"></div>	
<center><font color ="red"><b>В ЧАТЕ запрещены СПАМ, РЕКЛАМА и НЕЦЕНЗУРА!<b></font></center>

 <?php
 if ($users_info['chat_moder'])
 {
   $db->query("SELECT id, user FROM db_users_a WHERE ban_chat = '1'");
   
   if ($db->NumRows()) 
   { 
     ?>
     <div style="margin: 20px;"> 
      <h2 style="text-align: center;">В бане...</h2>
     <?php
     while ($row = $db->FetchAssoc())
     {
       ?><a href="/account/chat/noban/<?php echo $row['id']; ?>" title="Разбанить" style="display: inline-block; width: 80px; font-weight: bold;"><?php echo $row['user']; ?></a><?php 
     }
     ?>
      </div>
     <?php  
   }  
 }
 ?>
 </div></div></div>
<div class="block3"></div>
<div class="clr"></div>	

