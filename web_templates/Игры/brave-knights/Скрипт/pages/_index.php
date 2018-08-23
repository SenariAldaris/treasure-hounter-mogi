<div class="silver-bk5"><div class="clr"></div>

<?php
		if(isset($_SESSION["user"])){
		print '<div class="fr-te-gr"><BR /><BR /><BR /><font color="red">Тут пишем чтото о проекте!</font></div>';
		} else {
		?>

<div class="autoriz">
<div class="h-title">Экономическая игра</div>

<?PHP

	if(isset($_POST["log_email"])){
	
	$lmail = $func->IsMail($_POST["log_email"]);
	
		if($lmail !== false){
		
			$db->Query("SELECT id, user, pass, referer_id, banned FROM ".$pref."_users_a WHERE email = '$lmail'");
			if($db->NumRows() == 1){
			
			$log_data = $db->FetchArray();
			$pass = $func->md5Password($_POST["pass"]);
				if($log_data["pass"] == $pass){
				
					if($log_data["banned"] == 0){
						
						# Считаем рефералов
						$db->Query("SELECT COUNT(*) FROM ".$pref."_users_a WHERE referer_id = '".$log_data["id"]."'");
						$refs = $db->FetchRow();
						
						$db->Query("UPDATE ".$pref."_users_a SET referals = '$refs', date_login = '".time()."', ip = INET_ATON('".$func->UserIP."') WHERE id = '".$log_data["id"]."'");
						
						$_SESSION["user_id"] = $log_data["id"];
						$_SESSION["user"] = $log_data["user"];
						$_SESSION["referer_id"] = $log_data["referer_id"];
						exit(header("Location: /account/pole"));
						
					}else echo "<center><div class='h-title3'><font color = 'red'><b>Аккаунт заблокирован</b></font></div><BR /></center>";
				
				}else echo "<center><div class='h-title3'><font color = 'red'><b>Email и/или пароль неверны</b></font></div><BR /></center>";
			
			}else echo "<center><div class='h-title3'><font color = 'red'><b>Email у нас не зарегистрирован</b></font></div><BR /></center>";
			
		}else echo "<center><div class='h-title3'><font color = 'red'><b>Email указан неверно</b></font></div><BR /></center>";
	
	}

?>

	<form action="" method="post">
		
<table width="200" border="0" align="center">
  <tr>
    <td colspan="2"><input name="log_email" type="text" size="23" placeholder="E-mail" maxlength="35" class="lg"/></td>
  </tr>
  
  <tr>
    <td colspan="2"><input name="pass" type="password" size="23" placeholder="Пароль" maxlength="45" class="ps"/></td>
  </tr>

  <tr height="5">
    <td align="center" valign="top"><input type="submit" value="Войти" class="btn_in"/></form></td>
    
  </tr>
<tr>
 <td align="center" valign="top"> <a href="/recovery" class="rs-ps">Забыли пароль?</a>
</td>
  </tr>
<tr>
<td align="center" valign="top"><a href="/signup" class="rs-ps1"><font color="#fff">Регистрация</font></a></td></tr>
</table>
</form>

</div>

<?php } ?>



<div id="link1" style="
    width: 400px;
    height: 445px;
    position: absolute;
    top: 300px;
    left: 50%;
    margin-left: -470px;
    background: url('../img/boy.png') 0 0 no-repeat;
    z-index: 10;
    cursor: pointer;

"></div>

</div>
<div class="clr"></div>
