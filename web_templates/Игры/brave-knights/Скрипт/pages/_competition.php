<?PHP
$_OPTIMIZATION["title"] = "������� ���������";
$_OPTIMIZATION["description"] = "������� ���������";
$_OPTIMIZATION["keywords"] = "�������, ������� ���������";
?>
<div class="block1
"><div class="h-title1
">������� ���������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
	
<center><a href="/competition" class="stn">������� ��������</a> || <a href="/competition/list" class="stn">�����������</a></center><BR />
<?PHP

# ������ ���������
if(isset($_GET["list"])){


	# ������ �������������
	$db->Query("SELECT * FROM ".$pref."_competition WHERE status > 0");
	if($db->NumRows() > 0){
	
	?>
	
	
	<?PHP
		while($data = $db->FetchArray()){
		
		?>
			<table width="99%" border="0" align="center">
			<tr bgcolor="#efefef">
				<td align="center" width="75" class="m-tb">ID</td>
				<td align="center" class="m-tb">�����</td>
				<td align="center" class="m-tb">��������</td>
				<td align="center" class="m-tb">����</td>
			</tr>
			<tr class="htt" >
				<td align="center"><?=$data["id"]; ?></td>
				<td align="center"><?=date("d.m.Y", $data["date_add"]); ?></td>
				<td align="center"><?=date("d.m.Y", $data["date_end"]); ?></td>
				<td align="center"><?=$data["1m"]+$data["2m"]+$data["3m"]; ?> RUB</td>
		 	</tr>
			<tr bgcolor="#efefef">
				<td align="center" width="75" class="m-tb">������</td>
				<td align="center" class="m-tb">1 ����� / ����</td>
				<td align="center" class="m-tb">2 ����� / ����</td>
				<td align="center" class="m-tb">3 ����� / ����</td>
			</tr>
			<tr class="htt" >
				<td align="center"><?=($data["status"] > 1) ? "�������" : "��������"; ?></td>
				<td align="center"><?=$data["user_1"]; ?> / <?=$data["1m"]; ?></td>
				<td align="center"><?=$data["user_2"]; ?> / <?=$data["2m"]; ?></td>
				<td align="center"><?=$data["user_3"]; ?> / <?=$data["3m"]; ?></td>
		 	</tr>
			</table>
		<BR /><BR />
		<?PHP
		}

	}else echo "<center><b><font color = 'red'>��� ����������� ���������</font></b></center><BR />";


?>
</div></div></div><div class="block3"></div>
<div class="clr"></div>	
<?PHP

return;
}


$db->Query("SELECT * FROM ".$pref."_competition WHERE status = 0 LIMIT 1");
if($db->NumRows() == 1){
$comp = $db->FetchArray();	
	?>
<center>
<b>������� ��������� � <?=$comp["id"]; ?> � ����� �������� ������ <?=$comp["1m"]+$comp["2m"]+$comp["3m"]; ?> RUB<BR /><BR /></b>
����� ��������: <?=date("d.m.Y � H:i:s", $comp["date_add"]); ?> <BR />����������: <?=date("d.m.Y � H:i:s", $comp["date_end"]); ?>
<BR /><BR />

<font color = '#914A1F'><b><u>�������� �����:</u><BR />
1 - <?=$comp["1m"]; ?> RUB <BR />
2 - <?=$comp["2m"]; ?> RUB <BR />
3 - <?=$comp["3m"]; ?> RUB <BR /><BR /></b></font>

� �������� ����������� ������ �������� ��������, ������� ������������������ ����� ������� ��������. <BR />�� ������ ���������� ������� ����� ��������� ��� ����������� �����, 1 RUB = 1 �����. ��� ������ ������, ��� ������ ���� �������� � ��������. <BR /><BR />
</center>
	<?PHP
	
	# ������ �������������
	$db->Query("SELECT * FROM ".$pref."_competition_users ORDER BY points DESC LIMIT 100");
	if($db->NumRows() > 0){
	
	?>
	<center><b>������� �������</b></center>
<table width="99%" border="0" align="center">
  <tr bgcolor="#efefef">
    <td align="center" width="75" class="m-tb">�������</td>
    <td align="center" class="m-tb">������������</td>
    <td align="center" class="m-tb">������</td>
	<td align="center" class="m-tb">����</td>
  </tr>
	<?PHP
		$position = 1;
		while($data = $db->FetchArray()){
		
		?>
			<tr class="htt" >
				<td align="center" width="75"><?=$position; ?></td>
				<td align="center"><?=$data["user"]; ?></td>
				<td align="center"><?=sprintf("%.0f",$data["points"]); ?></td>
				<td align="center"><?=(intval($comp["{$position}m"]) > 0) ? $comp["{$position}m"]." RUB" : "-" ?></td>
		 	</tr>
		<?PHP
		$position++;
		}
	
	?>
</table>
<BR />
	<?PHP
	
	}else echo "<center><b><font color = 'red'>��� ���������� � ��������</font></b></center><BR />";

}else echo "<center><b><font color = 'red'>� ������ ������ ������� �� ����������</font></b></center><BR />";

?>
</div></div></div>
<div class="block3"></div>
<div class="clr"></div>


<style>
.block2 {background: url('/img/block2.png') repeat-y;
    position: relative;
    z-index: 10;
    left: 50%;
    margin-left: -160px;
    padding: 0px 50px 10px 50px;
    float: center;
    height: 450px;
    overflow: auto;
    color: #000000;
    font-family: 'Comic Sans MS', cursive;
    font-size: 11pt;
    width: 560px;}
</style>