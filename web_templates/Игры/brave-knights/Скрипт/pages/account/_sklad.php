<div class="block1
"><div class="h-title1
">���������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<BR />
<?PHP
$_OPTIMIZATION["title"] = "���������";
$usid = $_SESSION["user_id"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
?>

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

//if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) )
	//{
		echo $build->Build($usid,$_POST["item"]);

	
	//}
	//else echo "<center><font color = 'red'><b>����� ��� ��� ������ ������� ������� ������� ������� �� ������!</b></font></center><BR />";

}

?>


<?php if($user_data["k_t"] == 0) { ?>

<center>
��� ������������� ������ ��������� ��������� ����������� ������������ ������������ ����������, ������� ����� ������ � �����. � ��� �� ������� ������� ��� ������������ ��������� � ����� ��� ������������, � ����� ����������������� ������. ��������� �� ������ �� �������� � ��� ������� �� �����������.</center>
<BR ><BR >

<?php echo $build->GetBuildingTable(0, "k_t"); ?>		
</br>
</br>
<?php echo $build->GetBuildProcess($usid, "k_t"); ?>
				

<?php } else { ?>		
<table border="0">
<tbody>
<tr>
<td align="center" width="40%">
<div colspan="3"><img src="/img/fruit/sklad2.png" width="170" height="150" name="slide_show"></div>   
</td>
<td align="center" width="50%">
��� ����� ��� �������� ��������� ���� �������� � ������������ �� ������� ���������. ��� ����� ����� ������� � �����, ���������� � �������� ��� ������������ � ����.

 
</td>
</tr>
</tbody>
</table>				

<hr>

<center>
                   
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/glina.png" id="sk1"/></div></td>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/zlaki.png" id="sk2" /></div></td>
	<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/brevno.png" id="sk3"/></div></td>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/ruda.png" id="sk4"/></div></td>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/zlato.png" id="sk5"/></div></td>
    
  </tr>
  <tr>
    <td align="center"><?=$user_data["a_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["b_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["c_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["d_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["money_p"]; ?> ��.</td>
  </tr>



</tr>
  

</table></center>

<center>
                   
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  
<tr>
<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/kirpichi.png" width="60" height="50"  id="sk6"/></div></td>
<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/muka1.png" width="60" height="50"  id="sk7"/></div></td>
<td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/drevo.png" width="60" height="50"  id="sk8"/></div></td>
    <td align="center" width="20%"><div class="sm-line-nt"><img src="/img/fruit/stall.png" width="60" height="50"  id="sk9"/></div></td>
	
 
   

    
  </tr>
  <tr>
    <td align="center"><?=$user_data["f_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["l_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["h_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["i_b"]; ?> ��.</td>
    
  </tr>


</tr>
  

</table></center>

<center>
                   
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
<tr>
<td align="center" width="15%"><div class="sm-line-nt"><img src="/img/fruit/baranina.png" width="60" height="50"  id="sk10"/></div></td>
<td align="center" width="15%"><div class="sm-line-nt"><img src="/img/fruit/konina.png" width="60" height="50"  id="sk11"/></div></td>
<td align="center" width="15%"><div class="sm-line-nt"><img src="/img/fruit/hleb.png" width="60" height="50"  id="sk12"/></div></td>
<td align="center" width="15%"><div class="sm-line-nt"><img src="/img/fruit/pivo.png" width="60" height="50"  id="sk13"/></div></td>
<td align="center" width="15%"><div class="sm-line-nt"><img src="/img/fruit/shashlik.png" width="60" height="50"  id="sk14"/></div>
<td align="center" width="15%"><div class="sm-line-nt"><img src="/img/fruit/kolbasa.png" width="60" height="50"  id="sk15"/></div>
</td>
	
 
   

    
  </tr>
  <tr>
    <td align="center"><?=$user_data["u_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["v_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["coctel_a"]; ?> ��.</td>
    <td align="center"><?=$user_data["coctel_d"]; ?> �.</td>
    <td align="center"><?=$user_data["coctel_b"]; ?> ��.</td>
    <td align="center"><?=$user_data["coctel_c"]; ?> ��.</td>
    
  </tr>


</tr>
  

</table></center>

<?php } ?>
<div class="clr"></div>
</div></div></div>
<div class="block3"></div>
<div class="clr"></div>	


<script>
$(document).ready(function(){ 
$("#sk1").easyTooltip({
yOffset: 70,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><b>�����</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk2").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>�������</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk3").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>������</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk4").easyTooltip({
yOffset: 70,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><b>����</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk5").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>������</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk6").easyTooltip({
yOffset: 70,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><b>�������</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk7").easyTooltip({
yOffset: 70,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><b>����</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk8").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>�����</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk9").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>�����</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk10").easyTooltip({
yOffset: 70,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><b>��������</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk11").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>������</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk12").easyTooltip({
yOffset: 70,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><b>����</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk13").easyTooltip({
yOffset: 70,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><b>����</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk14").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>������</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#sk15").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>�������</b></h4></p>'
});
});
</script>

<style>
#easyTooltip{
	color: #2C3719;
	margin:0 10px 1em 0;
	width:250px;
	padding:8px;
	background: rgba(255, 255, 255, 0.72);
	border:1px solid #7C7C79;
	line-height:130%;xOffset: -100px;
	border-radius: 15px 15px 15px 15px;
	box-shadow: rgb(243, 252, 57) 0px 0px 5px 0px;
	z-index:100;
	}
#easyTooltip h3{
	margin:0 0 .5em 0;
	font:13px Arial, Helvetica, sans-serif;
	text-transform:uppercase;
	}	
#easyTooltip p{
	margin:0 0 .5em 0;
	}		
#easyTooltip img{
		background:#fff;
		padding:1px;
		border:1px solid #e1e1e1;
		float:left;
		margin-right:10px;
		}	
		
#easyTooltip4{
	color: #2C3719;
	margin:0 10px 1em 0;
	/*width:100px;*/
	padding:8px;height:20px;
	background: rgba(245, 245, 245, 0.92);
	border:1px solid #E0FFFF;
	line-height:130%;
	border-radius: 10px 10px 10px 10px;
        box-shadow: inset 0px 1px 10px 0px rgba(55, 55, 55, 0.400), 3px 5px 10px rgba(0, 0, 0, 0.402); text-align: center;
	z-index:100;
	}
