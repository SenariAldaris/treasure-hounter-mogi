<div class="block1
"><div class="h-title1
">������</div></div>
<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
                               
<?PHP
$_OPTIMIZATION["title"] = " ��������� ������";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

# ������� ������ ������
if(isset($_POST["item"])){

$array_items = array(1 => "a_t", 2 => "b_t", 3 => "c_t", 4 => "d_t", 5 => "e_t", 6 => "f_t");
$array_name = array(1 => "�������", 2 => "��������", 3 => "�������", 4 => "������", 5 => "������", 6 => "�������");
$item = intval($_POST["item"]);
$citem = $array_items[$item];
$all_items = ($user_data["a_t"] + $user_data["b_t"] + $user_data["c_t"] + $user_data["d_t"] + $user_data["e_t"] + $user_data["f_t"]);



	
	if(strlen($citem) >= 3){
		
		# ��������� �������� ������������
		$need_money = $sonfig_site["amount_".$citem];

                                $need_ns = 1; 
                                if($need_ns <= $user_data["ns"]){

$max_g_t = 9+($user_data["g_t"]*20);
if($all_items <= $max_g_t){

                                $need_en = 2; 
                                if($need_en <= $user_data["en"]){
                


		if($need_money <= $user_data["money_b"]){
		
			//if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) )
//{
				


				$to_referer = $need_money * 0.1;
				# ��������� ������ � ��������� ������
				$db->Query("UPDATE ".$pref."_users_b SET money_b = money_b - $need_money, $citem = $citem + 1, en = en - 2, ns = ns - 1,
				last_sbor = IF(last_sbor > 0, last_sbor, '".time()."') WHERE id = '$usid'");
				$db->Query("UPDATE ".$pref."_users_a SET balls = balls + 3 WHERE id = '$usid'");
				# ������ ������ � �������
				$db->Query("INSERT INTO ".$pref."_stats_btree (user_id, user, tree_name, amount, date_add, date_del) 
				VALUES ('$usid','$usname','".$array_name[$item]."','$need_money','".time()."','".(time()+60*60*24*15)."')");
				$life_time->AddItem($usid,$citem);
				echo "<center><font color = '#914A1F'><b>�� ������� ��������� ���� ������!</b></font></center><BR />";
				header( 'Refresh: 3; url=/account/farm' );
				$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
				$user_data = $db->FetchArray();


				
			//}
//else echo "<center><font color = 'red'><b>����� ��� ��� ������ �����, ������� ������� ������� �� �������!</b></font></center><BR />";
		
		}else echo "<center><font color = 'red'><b>������������ ������� ��� ������</b></font></center><BR />";


}else echo "<center><font color = 'red'><b>������������ ������� ��� ������!</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>������������ ����� � �������!</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>������������ ���������� ��� ������!</b></font></center><BR />";
	
	}else echo 222;

}

?>



<center>


��� ���� ����� ������ � �������� �� ������, ��� ���������� ������� ���� ������. <font color = 'red'><b>��������!!! ����� �������� ������� ��������� ��������� �����!!! </b></font>������ ���� ����� ����� ������ � ����� �������. ����� ������ �����, ��������� 2��. �������, 1��. ���������� � ���� ��� 3 ��. �����.


	</center>


<script type="text/javascript" src="http://yourjavascript.com/21139232152/bxslider.min.js"></script>
<script type="text/javascript" src="http://yourjavascript.com/11225442391/common.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#slider1').bxSlider({
  auto: true,           // true, false - �������������� ����� �������
  speed: 2000,      // ����� ����� - � ������������, �������� ����� �������
 pause: 55000,  // ����� ����� - � ������������, ������ ����� ������� �������
    });
  });
</script><div id="slider_cont">
<div id="slider1">

<div>

<!----><!---->
<center>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"> <font color="#000000"; ><b>�������</b></font></div>
<div colspan="3"><img src="/img/fruit/r3.png" name="slide_show"></div>

<!--<div id="example3" style=" display: none; ">-->
<center>

		
<div class="fr-te-gr"><b>����� �������: </b><font color="#000000"><?=$sonfig_site["c_in_h"]; ?> � ���</font></div>
<div class="fr-te-gr"><b>����:</b> <font color="#000000"><?=$sonfig_site["amount_c_t"]; ?> ���./ 3 ������</font></div>
		<div class="fr-te-gr"><b>������: </b><font color="#000000"><?=$user_data["c_t"]; ?> ��.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 5) { ?>
		<input type="hidden" name="item" value="3" />
		<input type="submit" value="����������" style="height: 30px; margin-top:10px;" class="btn_8" /><?PHP } else {	?> <br><center><font color="red"><b>�������� � 5 ������</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!---->


<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"><font color="#000000"><b>������</b></font></div>
<div colspan="3"><img src="/img/fruit/r4.png" name="slide_show2"></div>

<!--<div id="example4" style=" display: none; ">-->
<center>
		<div class="fr-te-gr"><b>�������� ����: </b><font color="#000000"><?=$sonfig_site["d_in_h"]; ?> � ���</font></div>
		<div class="fr-te-gr"><b>����:</b> <font color="#000000"><?=$sonfig_site["amount_d_t"]; ?> ���./ 3 ������</font></div>


		<div class="fr-te-gr"><b>������:</b> <font color="#000000"><?=$user_data["d_t"]; ?> ��.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 10) { ?>
		<input type="hidden" name="item" value="4" />
		<input type="submit" value="����������" style="height: 30px; margin-top:10px;"class="btn_8"><?PHP } else {	?> <br><center><font color="red"><b>�������� � 10 ������</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!----> 
</tr>
</table>
 </div>
<div><center>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"> <font color="#000000"; ><b>������</b></font></div>
<div colspan="3"><img src="/img/fruit/r5.png" name="slide_show"></div>

<!--<div id="example3" style=" display: none; ">-->
<center>
<div class="fr-te-gr"><b>��������� � ���: </b><font color="#000000"><?=$sonfig_site["e_in_h"]; ?> <img src="/img/fruit/zoloto.png" width="25" height="27" name="slide_show"> � ���</font></div>
		<div class="fr-te-gr"><b>����:</b> <font color="#000000"><?=$sonfig_site["amount_e_t"]; ?> ���./ 3 ������</font></div>


		<div class="fr-te-gr"><b>������: </b><font color="#000000"><?=$user_data["e_t"]; ?> ��.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 20) { ?>
		<input type="hidden" name="item" value="5" />
		<input type="submit" value="����������" style="height: 30px; margin-top:10px;" class="btn_8" /><?PHP } else {	?> <br><center><font color="red"><b>�������� � 20 ������</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!---->


<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"><font color="#000000"><b>��������</b></font></div>
<div colspan="3"><img src="/img/fruit/r6.png" name="slide_show2" style="height: 240px;width:210px;"></div>

<!--<div id="example4" style=" display: none; ">-->
<center>
		
		
<div class="fr-te-gr"><b>�������� ��� �������: </b><font color="black">� 2 ����</font></div>
<div class="fr-te-gr"><b>����:</b> <font color="#000000"><?=$sonfig_site["amount_f_t"]; ?> ���./ 3 ������</font></div>

		<div class="fr-te-gr"><b>������:</b> <font color="#000000"><?=$user_data["f_t"]; ?> ��.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 30) { ?>
		<input type="hidden" name="item" value="6" />
		<input type="submit" value="����������" style="height: 30px; margin-top:10px;"class="btn_8"><?PHP } else {	?> <br><center><font color="red"><b>�������� � 30 ������</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!----> 
</tr>
</table>

</div>


<div><center>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>

<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"> <font color="#000000"; ><b>�������</b></font></div>
<div colspan="3"><img src="/img/fruit/r1.png" name="slide_show"></div>

<!--<div id="example3" style=" display: none; ">-->
<center>
<div class="fr-te-gr"><b>������ �����: </b><font color="#000000"><?=$sonfig_site["a_in_h"]; ?> � ���</font></div>
		<div class="fr-te-gr"><b>����:</b> <font color="#000000"><?=$sonfig_site["amount_a_t"]; ?> ���./ 3 ������</font></div>


		<div class="fr-te-gr"><b>������:</b> <font color="#000000"><?=$user_data["a_t"]; ?> ��.</font></div><form action="" method="post">

		<input type="hidden" name="item" value="1" />
		<input type="submit" value="����������" style="height: 30px; margin-top:10px;" class="btn_8" />
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!---->


<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"><font color="#000000"><b>��������</b></font></div>
<div colspan="3"><img src="/img/fruit/r2.png" name="slide_show2"></div>

<!--<div id="example4" style=" display: none; ">-->
<center>
		<div class="fr-te-gr"><b>���������� �����: </b><font color="#000000"><?=$sonfig_site["b_in_h"]; ?> � ���</font></div>
		<div class="fr-te-gr"><b>����:</b> <font color="#000000"><?=$sonfig_site["amount_b_t"]; ?> ���./ 3 ������</font></div>


		<div class="fr-te-gr"><b>������:</b> <font color="#000000"><?=$user_data["b_t"]; ?> ��.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 2) { ?>
		<input type="hidden" name="item" value="2" />
		<input type="submit" value="����������" style="height: 30px; margin-top:10px;"class="btn_8"><?PHP } else {	?> <br><center><font color="red"><b>�������� �� 2 ������</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!----> 
</tr>
</table></div>

</div>
</div><style>
/* ���������� � ������ ����� */
#slider_cont {
    border: 0px solid #006699;
    margin: 0px;
    width: 555px!important;
    padding: 0px;
}

/* ������ ��������� ����������� */
.bx-prev {
position:absolute;
top:45%;
left:5px;
width:31px;
height:31px;
text-indent:-999999px;
background:url(/img/prev.png) no-repeat  0 -30px;
}

/* ������ ���������� ����������� */
.bx-next {
position:absolute;
top:45%;
right:5px;
width:31px;
height:31px;
text-indent:-999999px;
background:url(/img/next.png) no-repeat 0 -30px;
}

/* ��� ������ ��� ��������� ������� */
.bx-next:hover {
background:url(/img/next1.png) no-repeat 0 -30px;
border:0;
}
/* ��� ������ ��� ��������� ������� */
.bx-prev:hover {
background:url(/img/prev1.png) no-repeat  0 -30px;
border:0;
}
</style>




 






</div></div>

</div>
<div class="block3"></div>