function scroll()
{
  $("#chat-message").scrollTop(document.getElementById('chat-message').scrollHeight); 
}

function descchange(elem)
{
    if (elem.value.length > 255) {
        elem.value = elem.value.substr(0,255);
    }
    document.forms['mailform'].scount.value = 'Осталось '+(255-elem.value.length)+' символов';
}

function mailappendtag(text1, text2)
{
    if (document.forms['mailform']) {
        if ((document.selection))
        {
            document.forms['mailform'].message.focus();
            document.forms['mailform'].document.selection.createRange().text = text1+document.forms['mailform'+ndx].document.selection.createRange().text+text2;
        } else 
        if (document.forms['mailform'].message.selectionStart != undefined) {
            var element = document.forms['mailform'].message;
            var str = element.value;
            var start = element.selectionStart;
            var length = element.selectionEnd - element.selectionStart;
            element.value = str.substr(0, start) + text1 + str.substr(start, length) + text2 + str.substr(start + length);
        } else document.forms['mailform'].message.value += text1+text2;
    }
    return true;
}

function appendcommtag(text1, text2)
    {
        if ((document.selection))
        {
            document.mailform.message.focus();
            document.mailform.document.selection.createRange().text = text1+document.mailform.document.selection.createRange().text+text2;
        } else if(document.mailform.message.selectionStart != undefined) {
            var element    = document.mailform.message;
            var str     = element.value;
            var start    = element.selectionStart;
            var length    = element.selectionEnd - element.selectionStart;
            element.value = str.substr(0, start) + text1 + str.substr(start, length) + text2 + str.substr(start + length);
        } else document.mailform.message.value += text1+text2;
    };

    function AppendSmile(asmile) {
        appendcommtag(asmile,'');
    }    

function chat_control(name)
{ 
  var sm = getCookie('ch'+name);
    
  if (sm == '1')
  { 
    document.cookie="ch"+name+"=0";
    $(".chat-control-"+name).removeClass("ch-"+name+"-yes");
    $(".chat-control-"+name).addClass("ch-"+name+"-no");   
  }
  else
  {
    document.cookie="ch"+name+"=1"; 
    $(".chat-control-"+name).removeClass("ch-"+name+"-no");
    $(".chat-control-"+name).addClass("ch-"+name+"-yes");
  }
  
  if (name == 'smile')
  {
    $(".smiles").toggle();
  } 
}

function chat_ban(id, elem)
{
  issend = confirm('Вы уверены что хотите забанить пользователя?');  
  
  if (issend)
  {       
//    var test = $(elem).parent();
// 
//    var test2 = $(test).attr('name');
//   
//    $('.'+test2).css('text-decoration', 'line-through');
//  
//    $(elem).remove();
//  
//    $('.'+test2).after('<span class="chat-ban" onclick="chat_razban('+id+', this);"></span>');
    
    var data = {'mode':'ban_users', 'id':id}; 
 
    //var bantime = $("#chat-ban-time").val();
    //var data = {'mode':'ban_users', 'id':id, 'bantime':bantime}; 
 
    $.ajax({
    cache: false,
    data: data,
    dataType: "json",
    type: "post",
    timeout: 5000,
    url: '/ajax/us-chat.php',
    success: function(data) {     
      if (data.status == 'yes')
      {     
        $('#entermsg').html('<div class=msgbox-success>Пользователь забанен</div>'); 
        
      }
      else
      {
        $('#entermsg').html('<div class=msgbox-error>Не получается почему-то...</div>');        
      }
    }
  });
    
  return false;
  }
}

function getCookie(name) {
  var cookie = " " + document.cookie;
  var search = " " + name + "=";
  var setStr = null;
  var offset = 0;
  var end = 0;
  if (cookie.length > 0) {
    offset = cookie.indexOf(search);
    if (offset != -1) {
      offset += search.length;
      end = cookie.indexOf(";", offset)
      if (end == -1) {
        end = cookie.length;
      }
      setStr = unescape(cookie.substring(offset, end));
    }
  }
  return(setStr);
}

document.onkeyup = function(e) 
{ 
  e = e || window.event; 
  if (e.keyCode === 13) 
  { 
    if ($('#message').is( ":focus" ))
    { 
      send_message();
    } 
    else
    {
      send_reklama();
    } 
  } 
}

function send_reklama()
{
  var message = $(".truuu").val();
  
  var data = {'mode':'add_reklama', 'message':message}; 
  
  $.ajax({
    cache: false,
    data: data,
    dataType: "json",
    type: "post",
    timeout: 5000,
    url: '/ajax/us-chat.php',
    success: function(data) {
      if (data.status == 'yes')
      {             
        alert('Выполнено!');
      }      
    }
  });
    
  return false;
}

function send_message()
{
  var message = $("#message").val();
  var touser = $("#message-to-user").text();
  var private = $('.private-check').is(':checked') && touser != '' ? '1' : '0';
  var data = {'mode':'add_message', 'message':message, 'touser':touser, 'private':private}; 
  var tm;
  
  function hidemsg()
  {
    $('#entermsg').fadeOut('slow');
    if (tm) clearTimeout(tm);
  }
  
  if (!message) return;
  
  $.ajax({
    cache: false,
    data: data,
    dataType: "json",
    type: "post",
    timeout: 5000,
    url: '/ajax/us-chat.php',
    success: function(data) {
      if (data.status == 'yes')
      {             
        $('#chat-message').append(data.html);
        $('#message').val('');
        if (getCookie('chsound') == '1' || getCookie('chsound') == null) { $("#sound-message-send")[0].play(); }
        
        if (getCookie('chscroll') == '1' || getCookie('chscroll') == null) 
        {        
          scroll();
        }  
      }
      else
      {
        $('#entermsg').show();
        $('#entermsg').html('<span class="msgbox-error">'+data.msg+'</span>');                              
        tm = setTimeout(function() { hidemsg(); }, 5000);
        if (getCookie('chsound') == '1' || getCookie('chsound') == null) 
        { 
          $("#sound-message-error")[0].play();         
        }  
      }
    }
  });
    
  return false;
}


function delmsg(id)
{
  issend = confirm("Вы уверены что хотите удалить сообщение?");
 
  if (issend)
  {   
 
  var data = {'mode':'del_message', 'id':id}; 
 
  $.ajax({
    cache: false,
    data: data,
    dataType: "json",
    type: "post",
    timeout: 5000,
    url: '/ajax/us-chat.php',
    success: function(data) {      
      if (data.status == 'yes')
      {     
        $('#entermsg').hide();
        $('#'+id).remove();
        $('#message').val('');
        
        if (getCookie('chscroll') == '1' || getCookie('chscroll') == null) 
        {        
          scroll();
        }         
      }
      else
      {
        $('#entermsg').html('<span class="msgbox-error">'+data.msg+'</span>');
        
        var tm;
        
        function hidemsg()
        {
          $('#entermsg').fadeOut('slow');
          if (tm) clearTimeout(tm);
        }
        
        tm = setTimeout(function() { hidemsg() }, 2000);
      }
    }
  });
    
  return false;
  }
}

function refresh(id)
{
  var new_online = $('#count-online').val();
 
  var data = {'mode':'refresh', 'id':id, 'online':new_online};  
  
  $.ajax({
    cache: false,
    data: data,
    dataType: "json",
    type: "post",
    timeout: 5000,
    url: '/ajax/us-chat.php',
    success: function(data) {
      if (data.status == 'yes')
      {            
        $('#chat-message').append(data.html);
        $('#chat-online').html(data.html2);
        
        if (getCookie('chsound') == '1' || getCookie('chsound') == null) 
        { 
          if (data.html) { $("#sound-message-send")[0].play(); }
          if (data.sound) { $("#sound-message-get")[0].play(); }
          
          $('#count-online').val(data.sound_new);
       
          if (data.sound_new > new_online) 
          {            
            $("#sound-message-new")[0].play(); 
          }
        }  
        
        if ((getCookie('chscroll') == '1' || getCookie('chscroll') == null) && data.html != '') 
        {        
          scroll();
        }  
      }
    }
  });
    
  return false;
}