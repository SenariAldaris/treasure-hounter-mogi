<div class="silver-bk5"><div class="clr"></div><div class="autoriz">
<div class="h-title">Админпанель</div>

<?PHP
if(isset($_SESSION["admin"])){ Header("Location: /".$admFolder.""); return; }

if(isset($_POST["admlogin"])){

	$db->Query("SELECT * FROM ".$pref."_admin_log WHERE id = 1 LIMIT 1");
	$data_log = $db->FetchArray();
	$pass = $_POST["admpass"];
	$pass = $func->md5Password($pass);
	$login = $db->RealEscape($_POST['admlogin']);
	


	if(strtolower($login) == strtolower($data_log["username"]) AND strtolower($pass) == strtolower($data_log["passwordd"]) ){
	
		$_SESSION["admin"] = true;
		Header("Location: /admindms");
		return;
	}else echo "<center><font color = 'red'><b>Неверно введен логин и/или пароль</b></font></center><BR />";
	
}
?>

<form action="" method="post">
<table width="190" border="0" align="center">
  <tr>
    
	<td align="right"><input type="text" placeholder="Логин админа" class="lg" name="admlogin" value="" /></td>
  </tr>
  <tr>
    
	<td align="right"><input type="password" placeholder="Пароль" class="lg" name="admpass" value="" /></td>
  </tr>
  <tr>
	<td style="padding-top:5px;" align="center" colspan="2"><input type="submit" value="Войти" class="btn_in"/></td>
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
<div class="clr"></div>
