<?PHP
$tfstats = time() - 60*60*24;
$onlinestats = time() - 60*60;
$db->Query("SELECT
(SELECT COUNT(*) FROM ".$pref."_users_a) all_users,
(SELECT SUM(insert_sum) FROM ".$pref."_users_b) all_insert,
(SELECT SUM(payment_sum) FROM ".$pref."_users_b) all_payment,
(SELECT COUNT(*) FROM ".$pref."_users_a WHERE date_reg > '$tfstats') new_users,
(SELECT COUNT(*) FROM ".$pref."_users_a WHERE date_login > '$onlinestats') online_users");

$stats_data = $db->FetchArray();

?>

<?php
		if(isset($_SESSION["user"])){

		} else {
		?>

<style>

.example4 {
    
    
    width: 100%;
    height:110px;
    background:url("/img/a12.png") repeat-x;
   
   
bottom: -35;  z-index:500;
left: 0px;
     position:  fixed;
    /*оформление текста*/
    color: #FAFFBD;
    font-family: 'Comic Sans MS', cursive;
    font-size: 15px; 
    padding-top:20px;

}


.example4:hover {
    width: 100%;
    height:110px;
    background:url("/img/a12.png") repeat-x;
   
    
bottom: -35;  z-index:500;
left: 0px;
     position:  fixed;
    /*оформление текста*/
    color: #FAFFBD;
    font-family: 'Comic Sans MS', cursive;
    font-size: 15px;
    padding-top:20px;

}


.bottom {
    
    width: 150px;
    height: 60px;
    margin: 0px 0px 0px 20px;
    border: 1px solid #0C0C0C;
    background: rgba(66, 39, 22, 0.6);
    border-radius: 0px;
    color: #F7FBCB;
    font-family: 'Comic Sans MS', cursive;
    font-size: 14px;
    padding-top: 6px;

}


.bottom:hover {
    
    width: 150px;
    height: 60px;
    margin: 0px 0px 0px 20px;
    border: 1px solid #0C0C0C;
    background: rgba(66, 63, 61, 0.6);
    border-radius: 0px;
    color: #F7FBCB;
    font-family: 'Comic Sans MS', cursive;
    font-size: 14px;
    padding-top: 6px;

}


</style>

<div class="clr-line3"></div>
<center>
<div class="example4">

<div class="bottom" style=" width: 180px;
    height: 50px;        position: fixed;  margin-left: -450px; bottom: 17px; left: 50%; z-index: 50;

 "/>Рыцарей<br><?=$stats_data["all_users"]; ?>  чел.</div>

<div class="bottom" style=" width: 180px;
    height: 50px;        position: fixed;  margin-left: -270px; bottom: 17px; left: 50%; z-index: 50;

 "/>Новых сегодня<br> + <?=$stats_data["new_users"]; ?> чел.</div>

<div class="bottom" style=" width: 180px;
    height: 50px;        position: fixed;  margin-left:  -90px; bottom: 17px; left: 50%; z-index: 50;

 "/>В казне денег<br><?=sprintf("%.2f",$stats_data["all_insert"]); ?> <?=$config->VAL; ?></div>
	
<div class="bottom" style=" width: 180px;
    height: 50px;        position: fixed;  margin-left: 90px; bottom: 17px; left: 50%; z-index: 50;

 "/>Выплачено<br><a href="/payments" style="text-decoration:none; color: #9CBC70;"><?=sprintf("%.2f",$stats_data["all_payment"]); ?></a> <?=$config->VAL; ?></div>

	
<div class="bottom" style=" width: 180px;
    height: 50px;        position: fixed;  margin-left: 270px; bottom: 17px; left: 50%; z-index: 50;

 "/>Государству<br><font color="#FF4500"><?=intval(((time() - $config->SYSTEM_START_TIME) / 86400 ) +1); ?></font> дн.</div></div>


</center>

<?php } ?>