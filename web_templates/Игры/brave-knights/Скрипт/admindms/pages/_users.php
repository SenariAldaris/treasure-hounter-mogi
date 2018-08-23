<div class="s-bk-lf">
	<div class="acc-title3">Пользователи</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<?PHP
# Редактирование пользователя
if(isset($_GET["edit"])){

$eid = intval($_GET["edit"]);

$db->Query("SELECT *, INET_NTOA(".$pref."_users_a.ip) uip FROM ".$pref."_users_a, ".$pref."_users_b WHERE ".$pref."_users_a.id = ".$pref."_users_b.id AND ".$pref."_users_b.id = '$eid' LIMIT 1");

# Проверяем на существование
if($db->NumRows() != 1){ echo "<center><b>Указанный пользователь не найден</b></center><BR />"; }

# Добавляем дерево
if(isset($_POST["set_tree"])){

$tree = $_POST["set_tree"];
$type = ($_POST["type"] == 1) ? "-1" : "+1";

	$db->Query("UPDATE ".$pref."_users_b SET {$tree} = {$tree} {$type} WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(".$pref."_users_a.ip) uip FROM ".$pref."_users_a, ".$pref."_users_b WHERE ".$pref."_users_a.id = ".$pref."_users_b.id AND ".$pref."_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>Покупка добавлена</b></center><BR />";
	
}


# Пополняем баланс
if(isset($_POST["balance_set"])){

$sum = intval($_POST["sum"]);
$bal = $_POST["schet"];
$type = ($_POST["balance_set"] == 1) ? "-" : "+";

$string = ($type == "-") ? "У пользователя снято {$sum} серебра" : "Пользователю добавлено {$sum} серебра";

	$db->Query("UPDATE ".$pref."_users_b SET {$bal} = {$bal} {$type} {$sum} WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(".$pref."_users_a.ip) uip FROM ".$pref."_users_a, ".$pref."_users_b WHERE ".$pref."_users_a.id = ".$pref."_users_b.id AND ".$pref."_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>$string</b></center><BR />";
	
}


# Забанить пользователя
if(isset($_POST["banned"])){

	$db->Query("UPDATE ".$pref."_users_a SET banned = '".intval($_POST["banned"])."' WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(".$pref."_users_a.ip) uip FROM ".$pref."_users_a, ".$pref."_users_b WHERE ".$pref."_users_a.id = ".$pref."_users_b.id AND ".$pref."_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>Пользователь ".($_POST["banned"] > 0 ? "забанен" : "разбанен")."</b></center><BR />";
	
}

$data = $db->FetchArray();

?>

<table width="100%" border="0">
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">ID:</td>
    <td width="200" align="center"><?=$data["id"]; ?></td>
  </tr>
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Логин:</td>
    <td width="200" align="center"><?=$data["user"]; ?></td>
  </tr>
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Email:</td>
    <td width="200" align="center"><?=$data["email"]; ?></td>
  </tr>
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Пароль:</td>
    <td width="200" align="center"><?=$data["pass"]; ?></td>
  </tr>
  
  
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Серебро (Покупки):</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["money_b"]); ?></td>
  </tr>
  
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Золото (Вывод):</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["money_p"]); ?></td>
  </tr>
  
  
  
  
  
  
  
  
  
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Рабочих:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="a_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["a_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="a_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Хозяюшек:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="b_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["b_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="b_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Лесорубов:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="c_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["c_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="c_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Шахтеров:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="d_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["d_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="d_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Рыцарей:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="e_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["e_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="e_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Командиров:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="f_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["f_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="f_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>
  

   
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Постройка Склад:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="k_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["k_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="k_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Постройка Мельница:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="l_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["l_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="l_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Кирпичный Завод:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="m_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["m_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="m_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Пилорама:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="n_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["n_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="n_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Литейный Завод:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="o_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["o_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="o_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Колбасный Завод:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="p_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["p_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="p_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Загон животных:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="q_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["q_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="q_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Пекарня:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="r_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["r_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="r_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Пивоварня:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="s_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["s_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="s_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Шашлычная:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="t_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["t_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="t_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr> 
  



  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Казарма 2:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="g_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["g_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="g_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Овечек:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="u_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["u_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="u_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Лошадей:</td>
    <td width="200" align="center">
	
		<table width="100%" border="0">
		  <tr>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="v_t" />
				<input type="hidden" name="type" value="1" />
				<input type="submit" value="-1" />
			</form>
			</td>
			<td align="center"><?=$data["v_t"]; ?> шт.</td>
			<td>
			<form action="" method="post">
				<input type="hidden" name="set_tree" value="v_t" />
				<input type="hidden" name="type" value="2" />
				<input type="submit" value="+1" />
			</form>
			</td>
		  </tr>
		</table>

	</td>
  </tr>



<tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Глины:</td>
<td align="center"><?=$data["a_b"]; ?> шт.</td>			
  </tr>

  <tr bgcolor="#D8D2C2">
<td style="padding-left:10px;">Пшеницы:</td>
<td align="center"><?=$data["b_b"]; ?> шт.</td>			
  </tr>

  <tr bgcolor="#D8D2C2">
<td style="padding-left:10px;">Бревен:</td>
<td align="center"><?=$data["c_b"]; ?> шт.</td>
  </tr>

<tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Руды:</td>
<td align="center"><?=$data["d_b"]; ?> шт.</td>			
  </tr>

  <tr bgcolor="#D8D2C2">
<td style="padding-left:10px;">Кирпичей:</td>
<td align="center"><?=$data["f_b"]; ?> шт.</td>			
  </tr>

  <tr bgcolor="#D8D2C2">
<td style="padding-left:10px;">Муки:</td>
<td align="center"><?=$data["l_b"]; ?> шт.</td>
  </tr>

  <tr bgcolor="#D8D2C2">
<td style="padding-left:10px;">Досок:</td>
<td align="center"><?=$data["h_b"]; ?> шт.</td>
  </tr>

<tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Стали:</td>
<td align="center"><?=$data["i_b"]; ?> шт.</td>			
  </tr>

  <tr bgcolor="#D8D2C2">
<td style="padding-left:10px;">Баранины:</td>
<td align="center"><?=$data["u_b"]; ?> шт.</td>			
  </tr>

  <tr bgcolor="#D8D2C2">
<td style="padding-left:10px;">Конины:</td>
<td align="center"><?=$data["v_b"]; ?> шт.</td>
  </tr>

  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Хлеба на продажу:</td>
    <td width="200" align="center"><?=$data["coctel_a"]; ?></td>
  </tr>
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Шашлыков на продажу:</td>
    <td width="200" align="center"><?=$data["coctel_b"]; ?></td>
  </tr>
 <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Колбасы на продажу:</td>
    <td width="200" align="center"><?=$data["coctel_c"]; ?></td>
  </tr>
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Пива на продажу:</td>
    <td width="200" align="center"><?=$data["coctel_d"]; ?></td>
  </tr>
  
   <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Хлеба для употребления:</td>
    <td width="200" align="center"><?=$data["coctel_ap"]; ?></td>
  </tr>
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Шашлыков для употребления:</td>
    <td width="200" align="center"><?=$data["coctel_bp"]; ?></td>
  </tr>
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Колбасы для употребления:</td>
    <td width="200" align="center"><?=$data["coctel_cp"]; ?></td>
  </tr>
<tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Пива для употребления:</td>
    <td width="200" align="center"><?=$data["coctel_dp"]; ?></td>
  </tr>


  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Referer:</td>
    <td width="200" align="center">[<?=$data["referer_id"]; ?>]<?=$data["referer"]; ?></td>
  </tr>
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Рефералов:</td>
	
	<?PHP
	$db->Query("SELECT COUNT(*) FROM ".$pref."_users_a WHERE referer_id = '".intval($data["id"])."'");
	$counter_res = $db->FetchRow();
	?>
	
    <td width="200" align="center"><?=$data["referals"]; ?> [<?=$counter_res; ?>] чел.</td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Заработал на рефералах:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["from_referals"]); ?> сер.</td>
  </tr>
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Принес рефереру:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["to_referer"]); ?> сер.</td>
  </tr>
  
  
  
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Зарегистрирован:</td>
    <td width="200" align="center"><?=date("d.m.Y в H:i:s",$data["date_reg"]); ?></td>
  </tr>
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Последний вход:</td>
    <td width="200" align="center"><?=date("d.m.Y в H:i:s",$data["date_login"]); ?></td>
  </tr>
  <tr bgcolor="#D8D2C2">
    <td style="padding-left:10px;">Последний IP:</td>
    <td width="200" align="center"><?=$data["uip"]; ?></td>
  </tr>
  
  
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Пополнено на баланс:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["insert_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
 <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Выплачено на кошелек:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["payment_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
  <tr bgcolor="#B9AF95">
    <td style="padding-left:10px;">Забанен (<?=($data["banned"] > 0) ? '<font color = "red"><b>ДА</b></font>' : '<font color = "#914A1F"><b>НЕТ</b></font>'; ?>):</td>
    <td width="200" align="center">
	<form action="" method="post">
	<input type="hidden" name="banned" value="<?=($data["banned"] > 0) ? 0 : 1 ;?>" />
	<input type="submit" value="<?=($data["banned"] > 0) ? 'Разбанить' : 'Забанить'; ?>" />
	</form>
	</td>
  </tr>
  
  
</table>
<BR />
<BR />
<form action="" method="post">
<table width="100%" border="0">
  <tr bgcolor="#B9AF95">
    <td align="center" colspan="4"><b>Операции с балансом:</b></td>
  </tr>
  <tr>
    <td align="center">
		<select name="balance_set">
			<option value="2">Добавить на баланс</option>
			<option value="1">Снять с баланса</option>
		</select>
	</td>
	<td align="center">
		<select name="schet">
			<option value="money_b">Для покупок</option>
			<option value="money_p">Для вывода</option>
		</select>
	</td>
    <td align="center"><input type="text" name="sum" value="100" size="7"/></td>
    <td align="center"><input type="submit" value="Выполнить" /></td>
  </tr>
</table>
</form>
</div>
<div class="clr"></div>	
<?PHP

return;
}

?>
<form action="index.php?menu=users&search" method="post">
<table width="250" border="0" align="center">
  <tr>
    <td><b>Логин:</b></td>
    <td><input type="text" name="sear" /></td>
	<td><input type="submit" value="Поиск" class="btn_8"/></td>
  </tr>
</table>
</form>
<BR />
<?PHP
if (isset($_GET["sort"])) {
if($_GET["sort"] == 0) {$str_sort = $pref."_users_a.id";}
elseif ($_GET["sort"] == 1) {$str_sort = $pref."_users_a.user";}
elseif ($_GET["sort"] == 2) {$str_sort = "all_serebro";}
elseif ($_GET["sort"] == 3) {$str_sort = "all_trees";}
elseif ($_GET["sort"] == 4) {$str_sort = $pref."_users_a.date_reg";}
} else {$str_sort = $pref."_users_a.id";}

/*
function sort_b($int_s){
	
	$int_s = intval($int_s);
	$pref = $config->BasePrefix;
	switch($int_s){
	
		case 1: return $pref."_users_a.user";
		case 2: return "all_serebro";
		case 3: return "all_trees";
		case 4: return $pref."_users_a.date_reg";
		
		default: return $pref."_users_a.id";
	}

}
$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;

$str_sort = sort_b($sort_b);
*/

$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

if(isset($_GET["search"])){
$search = $db->RealEscape($_POST["sear"]);


$db->Query("SELECT *, (".$pref."_users_b.a_t + ".$pref."_users_b.b_t + ".$pref."_users_b.c_t + ".$pref."_users_b.d_t + ".$pref."_users_b.e_t) all_trees, (".$pref."_users_b.money_b + ".$pref."_users_b.money_p) all_serebro 
FROM ".$pref."_users_a, ".$pref."_users_b WHERE ".$pref."_users_a.id = ".$pref."_users_b.id AND ".$pref."_users_a.user = '$search' ORDER BY '$str_sort' DESC LIMIT {$lim}, 100");

}else $db->Query("SELECT *, (".$pref."_users_b.a_t + ".$pref."_users_b.b_t + ".$pref."_users_b.c_t + ".$pref."_users_b.d_t + ".$pref."_users_b.e_t) all_trees, (".$pref."_users_b.money_b + ".$pref."_users_b.money_p) all_serebro 
FROM ".$pref."_users_a, ".$pref."_users_b WHERE ".$pref."_users_a.id = ".$pref."_users_b.id ORDER BY '$str_sort' DESC LIMIT {$lim}, 100");

//echo $pref."_users_a.id";

if($db->NumRows() > 0){
?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
    <td align="center" width="50" class="m-tb"><a href="index.php?menu=users&sort=0" class="stn-sort">ID</a></td>
    <td align="center" class="m-tb"><a href="index.php?menu=users&sort=1" class="stn-sort">User</a></td>
    <td align="center" width="90" class="m-tb"><a href="index.php?menu=users&sort=2" class="stn-sort">Серебра</a></td>
	<td align="center" width="75" class="m-tb"><a href="index.php?menu=users&sort=3" class="stn-sort">Покупок</a></td>
	<td align="center" width="100" class="m-tb"><a href="index.php?menu=users&sort=4" class="stn-sort">Зарегистрирован</a></td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center"><?=$data["id"]; ?></td>
    <td align="center"><a href="index.php?menu=users&edit=<?=$data["id"]; ?>" class="stn"><font color = "#914A1F"><?=$data["user"]; ?></font></a></td>
    <td align="center"><?=sprintf("%.2f",$data["all_serebro"]); ?></td>
	<td align="center"><?=$data["all_trees"]; ?></td>
	<td align="center"><?=date("d.m.Y",$data["date_reg"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP


}else echo "<center><b>На данной странице нет записей</b></center><BR />";

	if(isset($_GET["search"])){
	
	?>
	</div>
	<div class="clr"></div>	
	<?PHP
	
		return;
	
	}
	
$db->Query("SELECT COUNT(*) FROM ".$pref."_users_a");
$all_pages = $db->FetchRow();

	if($all_pages > 100){
	
	$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;
	
	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;
	
	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 100), "index.php?menu=users&sort={$sort_b}&page="), "</center>";
	
	}
?>
</div>
<div class="clr"></div>	