
<?PHP

	if(isset($_POST["log_email"])){
	
	$lmail = $func->IsMail($_POST["log_email"]);
	
		if($lmail !== false){
		
			$db->Query("SELECT id, user, pass, referer_id, banned FROM ".$pref."_users_a WHERE email = '$lmail'");
			if($db->NumRows() == 1){
			
			$log_data = $db->FetchArray();
			
				if(strtolower($log_data["pass"]) == strtolower($_POST["pass"])){
				
					if($log_data["banned"] == 0){
						
						# Считаем рефералов
						$db->Query("SELECT COUNT(*) FROM ".$pref."_users_a WHERE referer_id = '".$log_data["id"]."'");
						$refs = $db->FetchRow();
						
						$db->Query("UPDATE ".$pref."_users_a SET referals = '$refs', date_login = '".time()."', ip = INET_ATON('".$func->UserIP."') WHERE id = '".$log_data["id"]."'");
						
						$_SESSION["user_id"] = $log_data["id"];
						$_SESSION["user"] = $log_data["user"];
						$_SESSION["referer_id"] = $log_data["referer_id"];
						Header("Location: /account");
						
					}else echo "<center><font color = 'red'><b>Аккаунт заблокирован</b></font></center><BR />";
				
				}else echo "<center><font color = 'red'><b>Email и/или Пароль указан неверно</b></font></center><BR />";
			
			}else echo "<center><font color = 'red'><b>Указанный Email не зарегистрирован в системе</b></font></center><BR />";
			
		}else echo "<center><font color = 'red'><b>Email указан неверно</b></font></center><BR />";
	
	}

?>


<div class="autoriz">
	<form action="" method="post">
	<div class="h-title">Вход в Админпанель</div>	
<table width="200" border="0" align="center">
  <tr>
    <td colspan="2">Email:<BR /><input name="log_email" type="text" size="23" maxlength="35" class="lg"/></td>
  </tr>
  
  <tr>
    <td colspan="2">Пароль [<a href="/recovery" class="rs-ps">Забыли пароль?</a>]:<BR /><input name="pass" type="password" size="23" maxlength="35" class="ps"/></td>
  </tr>

  <tr height="5">
    <td align="center" valign="top"><input type="submit" value="Войти" class="btn_in"/></form></td>
    <td align="center" valign="top"><form action="/signup" method="post"><input type="submit" value="Регистрация" class="btn_reg"/></form></td>
  </tr>
  
</table>

</div>