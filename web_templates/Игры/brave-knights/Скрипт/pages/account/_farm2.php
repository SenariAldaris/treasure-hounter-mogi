
<div class="block1
"><div class="h-title1
">������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">

<?PHP
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];
$name_tree = $build->GetNames($_POST["item"]);
    $price = $build->GetPriceAndResource($_POST["item"]);
    $price = $price['price'];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();


# ������� ������ ������
if(isset($_POST["item"])){
$need_en = 5;
if($need_en <= $user_data["en"]){
//if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) )
	//{
		echo $build->Build($usid,$_POST["item"]);

	//}
	//else echo "<center><font color = 'red'><b>����� ��� ��� ������ ������� ������� ������� ������� �� ������!</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>������������ �������.</b></font></center><BR />";
}

?>


<?php if($user_data["q_t"] == 0) { ?>


<center>
��� ������������� ������ ��������� ��������� ����������� ������������ ������������ ����������, ������� ����� ������ � �����. � ��� ����� ���� ��������� ���� �������� ��������, ������� ����� ��������� ��� ������ ��������� � ������� �� ������� � �����. </center>
<BR ><BR >

<?php echo $build->GetBuildingTable(0, "q_t"); ?>		
</br>
</br>
<?php echo $build->GetBuildProcess($usid, "q_t"); ?>


<?php } else { ?>

<center>
����� ��������. ��������� �� ������ ����.<BR />

<a href="/account/market"><span><button class="btn_8" type="button"style="height: 30px;">������</button></span></a></center>

<?PHP } ?>


<div class="clr"></div>
</div></div>

</div>

<div class="block3"></div>
<div class="clr"></div>	