




<style>



body {


background:
  
url(../img/resources_view.jpg) top -280px  center no-repeat, 
  #FFFFFF url(../img/body_bg.png) center repeat-y;  height-min:1060px; 				margin-left: 50px;		
  font-family: "PTSansRegular"; }
img { border:0px; }
.clr { clear:both;}


.stn:link, .stn:visited { color: #609143; text-decoration: none; font-weight: bold; } 
.stn:active, .stn:hover { color: #d77906; text-decoration: none; }

.stn-sort:link, .stn-sort:visited { color: #FFFFFF; text-decoration: none; font-weight: bold; } 
.stn-sort:active, .stn-sort:hover { color: #000000; text-decoration: none; }
</style>







 


<div style="
    
    background: url(/img/1duma.jpg) no-repeat;
    position: relative;
    margin-bottom: -200px;
    height: 788px;
    
    background-repeat: no-repeat;
    background-size: 100% 100%;
">


<div id="link1" style="
    width: 1680px;
    height: 800px;
    background: url(/img/resources4446.png);
    position: relative;
    left: -500px;margin-bottom: -400px;
    top: -100px;
    z-index: 3;
">

</div>

<div id="link1">
<form action="" method="post">

<center><input  type="submit" name="sbor" id="sbor1" class="sbor" value="" style="height:557px;margin-bottom: -200px;"/></center>
</form>
</div>
</div>







<?PHP
$_OPTIMIZATION["title"] = " Ресурсы";
$usid = $_SESSION["user_id"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

                                
                                
	if(isset($_POST["sbor"])){
	

                                $need_ns = 2; 
                                if($need_ns <= $user_data["ns"]){


                                $need_en = 3; 
                                if($need_en <= $user_data["en"]){

                $need_s = 1;
                if($need_s <= $user_data["k_t"]){


		if($user_data["last_sbor"] < (time() - 600) ){
		
			$tomat_s = $func->SumCalc($sonfig_site["a_in_h"], $user_data["a_t"], $user_data["last_sbor"]);
			$straw_s = $func->SumCalc($sonfig_site["b_in_h"], $user_data["b_t"], $user_data["last_sbor"]);
			$pump_s = $func->SumCalc($sonfig_site["c_in_h"], $user_data["c_t"], $user_data["last_sbor"]);
			$peas_s = $func->SumCalc($sonfig_site["d_in_h"], $user_data["d_t"], $user_data["last_sbor"]);
			$pean_s = $func->SumCalc($sonfig_site["e_in_h"], $user_data["e_t"], $user_data["last_sbor"]);
			
                                


$db->Query("UPDATE ".$pref."_users_b SET 
	a_b = a_b + '$tomat_s' +'".$user_data['f_t']."'*'$tomat_s', 
        b_b = b_b + '$straw_s' +'".$user_data['f_t']."'*'$straw_s', 
        c_b = c_b + '$pump_s' +'".$user_data['f_t']."'*'$pump_s', 
        d_b = d_b + '$peas_s' +'".$user_data['f_t']."'*'$peas_s', 
        money_p = money_p + '$pean_s' +'".$user_data['f_t']."'*'$pean_s', 
        all_time_a = all_time_a + '$tomat_s' +'".$user_data['f_t']."'*'$tomat_s',
        all_time_b = all_time_b + '$straw_s' +'".$user_data['f_t']."'*'$straw_s',
        all_time_c = all_time_c + '$pump_s' +'".$user_data['f_t']."'*'$pump_s',
        all_time_d = all_time_d + '$peas_s' +'".$user_data['f_t']."'*'$peas_s',
        all_time_e = all_time_e + '$pean_s' +'".$user_data['f_t']."'*'$pean_s',
        en = en - 3, ns = ns - 2, 
        last_sbor = '".time()."' 
	WHERE id = '$usid' LIMIT 1");
	$db->Query("UPDATE ".$pref."_users_a SET balls = balls + 3 WHERE id = '$usid'");		
			echo "<div class='giv1'><center><font color = 'green'><b>Вы собрали ресурсы</b></font><BR />Проверьте их на складе</center></div>";
			header( 'Refresh: 3; url=/account/store' );
			$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
			$user_data = $db->FetchArray();
			

		}else echo "<div class='giv2'><center><font color = 'red'><b>Ресурсы можно собирать<BR /> не чаще 1го раза за 10 минут</b></font></center><BR /></div>";
header( 'Refresh: 4; url=/account/store' );
}else echo "<div class='giv1'><center><font color = 'red'><b>Вы не можете собрать <BR />ресурсы за оградой. <BR />У вас еще нет склада.</b></font></center></div><BR />";
header( 'Refresh: 4; url=/account/store' );
}else echo "<div class='giv1'><center><font color = 'red'><b>Недостаточно энергии<BR />для сборки!</b></font></center></div><BR />";
header( 'Refresh: 4; url=/account/store' );

	}else echo "<div class='giv1'><center><font color = 'red'><b>Недостаточно настроения<BR />для сборки!</b></font></center></div><BR />";
	header( 'Refresh: 4; url=/account/store' );
	}



?>



<div id="acc-title2" style="
    width: 631px;
    height: 83px;
    background: url(/img/acc2.png);
    position: fixed;  margin-left: -300px; bottom: 0px; left: 50%; z-index: 50;background-size: 100% 100%;padding:30px 0px 0px 0px;
">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td align="center" width="20%"><div class="sm-line-nt1"><img src="/img/fruit/glina.png" /></div></td>
    <td align="center" width="20%"><div class="sm-line-nt1"><img src="/img/fruit/zlaki.png" /></div></td>
	<td align="center" width="20%"><div class="sm-line-nt1"><img src="/img/fruit/brevno.png" /></div></td>
    <td align="center" width="20%"><div class="sm-line-nt1"><img src="/img/fruit/ruda.png" /></div></td>
    <td align="center" width="20%"><div class="sm-line-nt1"><img src="/img/fruit/zlato.png" /></div></td>

    
  </tr>
  <tr>
    <td align="center"><?=$func->SumCalc($sonfig_site["a_in_h"], $user_data["a_t"], $user_data["last_sbor"]);?></td>
    <td align="center"><?=$func->SumCalc($sonfig_site["b_in_h"], $user_data["b_t"], $user_data["last_sbor"]);?></td>
    <td align="center"><?=$func->SumCalc($sonfig_site["c_in_h"], $user_data["c_t"], $user_data["last_sbor"]);?></td>
    <td align="center"><?=$func->SumCalc($sonfig_site["d_in_h"], $user_data["d_t"], $user_data["last_sbor"]);?></td>
    <td align="center"><?=$func->SumCalc($sonfig_site["e_in_h"], $user_data["e_t"], $user_data["last_sbor"]);?></td>
  </tr>
</table>





</div>
<script>
$(document).ready(function(){ 
$("#sbor1").easyTooltip({
yOffset: 70,
xOffset: -80,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Собрать все ресурсы</b></h4>'
});
});
</script>