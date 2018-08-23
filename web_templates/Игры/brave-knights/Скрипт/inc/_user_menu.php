<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Профиль";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM ".$pref."_users_a, ".$pref."_users_b WHERE ".$pref."_users_a.id = ".$pref."_users_b.id AND ".$pref."_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>

<style>

.example3 {
    
    width: 100%;
   
    height: 60px;
    background: -moz-linear-gradient(#9A9389, #EFFFFF) repeat-x;
background: -ms-linear-gradient(#9A9389, #EFFFFF) repeat-x;
background: -o-linear-gradient(#9A9389, #EFFFFF) repeat-x;
background: -webkit-linear-gradient(#5A3D23, #EFFFFF) repeat-x;
   
    left: 0px;
top: -16;  z-index:30;

     position:  fixed;
    /*оформление текста*/
    color:#FFF;
    font-family:'Comic Sans MS', cursive;
    font-size:20px; 
    padding-top:50px;

}


.example3:hover {
 width: 100%; 
   
    height: 60px;
    background: -moz-linear-gradient(#9A9389, #EFFFFF) repeat-x;
background: -ms-linear-gradient(#9A9389, #EFFFFF) repeat-x;
background: -o-linear-gradient(#9A9389, #EFFFFF) repeat-x;
background: -webkit-linear-gradient(#5A3D23, #EFFFFF) repeat-x;
   
    left: 0px;
top: -16;  z-index:30;

     position:  fixed;
    /*оформление текста*/
    color:#FFF;
    font-family:'Comic Sans MS', cursive;
    font-size:20px; 
    padding-top:50px;

}

.ava {
    
    width: 82px;
    height: 82px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
background: -o-linear-gradient(#6D6C6B, #EFFFFF);
background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
   box-shadow: 1px 1px 3px #000;
    left: 20px;
    top: 1;
    
    border: 10px solid #B5EC6F;
    border-radius: 10px;
    position: fixed;z-index: 50;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;

}


.ava:hover {
    width: 82px;
    height: 82px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
background: -o-linear-gradient(#6D6C6B, #EFFFFF);
background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
   
    left: 20px;
    top: 1;
    
    border: 10px solid #F3E67A;
    border-radius: 10px;
    position: fixed;z-index: 50;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;

}

.stat1 {
    
    left: 189px;
    top: 10;
    
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 50;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;

}


.stat2 {
    
    left: 189px;
    top: 40;
    
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 50;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;

}


.stat3 {
    
    left: 189px;
    top: 70;
    
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 50;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;

}

.tar1 {
    
    left: 140px;
    top: 0;
    
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 51;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;

}


.tar2 {
    
    left: 140px;
    top: 30;
    
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 51;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;

}


.tar3 {
    
    left: 140px;
    top: 60;
    
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 51;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;

}

.pokup {
    
    right: 240px;
    top: 1;
    
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 51;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;

}


.svin {
    
    right: 237px;
    top: 50;
    
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 51;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;

}

.pokup1 {
    
    right: 80px;
    top: 6;
    width: 180px;
    border: 2px solid #5F5D5D;
    background-color: #B5EC6F;
    height: 25px;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 3px;
    border-radius: 10px;
    position: fixed;z-index: 50;
    text-align:center;

}


.svin1 {
    border: 2px solid #5F5D5D;
    background-color: #8F908E;
    right: 80px;
    top: 55;
    width: 180px;
    height: 25px;
    text-align:center;
    border-radius: 10px;
    position: fixed;z-index: 50;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 16px;
    padding-top: 3px;
    

}

.logos {
    width: 480px;
    height: 95px;
    background: url(/img/logo.png) no-repeat;
    color: #000;
    position: fixed;
    z-index: 40;
    left: 50%;
    top: 63;
    text-align: center;
    font-family: 'Comic Sans MS', cursive;
    font-size: 18px;
    padding-top: 20px;
    padding-left: 1px;
    margin-left: -235px;
}

.m1 {
    width: 58px;
    height: 58px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
    background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
    background: -o-linear-gradient(#6D6C6B, #EFFFFF);
    background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
    box-shadow: 1px 1px 3px #000;
    border: 10px solid #B5EC6F;
    border-radius: 50px;
    color: #FFF;
    position: fixed;z-index: 50;
    left: 50%;
    top: 1;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;
    padding-left: 1px;
    margin-left: -168px;
}


.m2 {
    width: 58px;
    height: 58px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
    background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
    background: -o-linear-gradient(#6D6C6B, #EFFFFF);
    background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
    box-shadow: 1px 1px 3px #000;
    border: 10px solid #B5EC6F;
    border-radius: 50px;
    color: #FFF;
    position: fixed;z-index: 50;
    left: 50%;
    top: 1;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;
    padding-left: 1px;
    margin-left: -80px;
}



.m3 {
    width: 58px;
    height: 58px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
    background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
    background: -o-linear-gradient(#6D6C6B, #EFFFFF);
    background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
    box-shadow: 1px 1px 3px #000;
    border: 10px solid #B5EC6F;
    border-radius: 50px;
    color: #FFF;
    position: fixed;z-index: 50;
    left: 50%;
    top: 1;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;
    padding-left: 1px;
    margin-left: 8px;
}

.m4 {
    width: 58px;
    height: 58px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
    background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
    background: -o-linear-gradient(#6D6C6B, #EFFFFF);
    background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
    box-shadow: 1px 1px 3px #000;
    border: 10px solid #B5EC6F;
    border-radius: 50px;
    color: #FFF;
    position: fixed;z-index: 50;
    left: 50%;
    top: 1;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;
    padding-left: 1px;
    margin-left: 96px;
}

.m1:hover {
    width: 58px;
    height: 58px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
    background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
    background: -o-linear-gradient(#6D6C6B, #EFFFFF);
    background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
    box-shadow: 1px 1px 3px #000;
    border: 10px solid #F3E67A;
    border-radius: 50px;
    color: #FFF;
    position: fixed;z-index: 50;
    left: 50%;
    top: 2;
   font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;
    padding-left: 1px;
    margin-left: -168px;
}


.m2:hover {
    width: 58px;
    height: 58px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
    background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
    background: -o-linear-gradient(#6D6C6B, #EFFFFF);
    background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
    box-shadow: 1px 1px 3px #000;
    border: 10px solid #F3E67A;
    border-radius: 50px;
    color: #FFF;
    position: fixed;z-index: 50;
    left: 50%;
    top: 2;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;
    padding-left: 1px;
    margin-left: -80px;
}



.m3:hover {
    width: 58px;
    height: 58px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
    background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
    background: -o-linear-gradient(#6D6C6B, #EFFFFF);
    background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
    box-shadow: 1px 1px 3px #000;
    border: 10px solid #F3E67A;
    border-radius: 50px;
    color: #FFF;
    position: fixed;z-index: 50;
    left: 50%;
    top: 2;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;
    padding-left: 1px;
    margin-left: 8px;
}

.m4:hover {
    width: 58px;
    height: 58px;
    background: -moz-linear-gradient(#6D6C6B, #EFFFFF);
    background: -ms-linear-gradient(#6D6C6B, #EFFFFF);
    background: -o-linear-gradient(#6D6C6B, #EFFFFF);
    background: -webkit-linear-gradient(#6D6C6B, #EFFFFF);
    box-shadow: 1px 1px 3px #000;
    border: 10px solid #F3E67A;
    border-radius: 50px;
    color: #FFF;
    position: fixed;z-index: 50;
    left: 50%;
    top: 2;
    font-family: 'Comic Sans MS', cursive;
    font-size: 20px;
    padding-top: 1px;
    padding-left: 1px;
    margin-left: 96px;
}

.clr-line3 {
    background: url(/img/1.png) repeat-x;
    width: 100%;
    height: 34px;
    bottom: 3;
    left: 0px;
    z-index: 50;
    position: fixed;
}
.clr-line4 {
    background: url(/img/1.png) repeat-x;
    width: 100%;
    height: 34px;
    top: 89;
    left: 0px;
    z-index: 16;
    position: fixed;
}

.exit {
    
    right: 20px;
    top: 15;
    background: url(/img/exit.png);
    border: 0px solid #B5EC6F;
    
    position: fixed;z-index: 51;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 10px;
    padding-top: 0px;


}
</style>

<div class="example3">

<center>
<table><tr><td>
<a href="/account/pole" id="linkm"><div class="m1"><img src="/img/m1.png"></div></a>


</td><td>

<a href="/account/farm" id="linkm2" ><div class="m2"><img src="/img/m2.png"></div></a>

</td><td>

<a href="/account/store" id="linkm3"><div class="m3"><img src="/img/m3.png"></div></a>

</td><td>

<a href="/account/instruktor" id="linkm4"><div class="m4"><img src="/img/m4.png"></div></a>

</td></tr></table>
</center>

<div class="logos">Войско <?=$_SESSION["user"];?>! Уровень: <?php echo user_level::getInstance()->get_level() ;?>.</div>

<table><tr><td>
<a href="#" id="linka"><div class="ava"><?if(empty($prof_data['ava'])) {
echo '<center><img src="/img/c50.gif" style="height: 80px;"></center>';
}else{
echo '<center><img src="/'.$prof_data['ava'].'" style="height: 80px;"></center>';
}
?></div></a>

</td><td>
<a href="#" id="linko"><div class="tar1"><img src="/img/147.png"></div>
<div class="stat1">
             <div id="progressbar" style="  width: 120px;
             border: 2px solid #5F5D5D;
             background-color: #8F908E;
             border-radius: 5px;
             -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
             position: relative;
             margin-top: 2px;
             padding: 1px;
             left: 50%;
             margin-left: -60px;">
             <span id="percent" style="  position: absolute;
             color: #fff;
             font-size: 9px;
             text-align: center;
             width: 100%;
             top: 0;
             left: 0;"><?php echo user_level::getInstance()->get_balls() ;?> / <?php echo user_level::getInstance()->get_next_level() ;?></span>    
			 <div id="bar" style="width: <?php echo  user_level::getInstance()->get_percent(); ?>%; height: 9px;
  background-color: #B5EC6F;
  border-radius: 5px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;"></div>
		</div></a>

<a href="#" id="linken"><div class="tar2"><img src="/img/146.png"></div>
<div class="stat2">
             <?
if(isset($_SESSION["user_id"])):
$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = ".$_SESSION["user_id"]);
$data = $db->FetchArray();
$en = $data['en'];
$perc = $en/100*100;
if ($perc>100)
  $perc = 100;
?>
<div style="  width: 120px;  border: 2px solid #5F5D5D;
             background-color: #8F908E;  border-radius: 5px;  -moz-border-radius: 5px;  -webkit-border-radius: 5px;  position: relative;  margin-top: 2px;  padding: 1px;  left: 50%;  margin-left: -60px;">
  <span style="  position: absolute;  color: #fff;  font-size: 9px;  text-align: center;  width: 100%;  top: 0;  left: 0;"><?=$en;?> / 100</span>
   <div style="width: <?=$perc;?>%; height: 9px;  background-color: #B5EC6F;  border-radius: 5px;  -moz-border-radius: 5px;  -webkit-border-radius: 5px;"></div>
</div>


<?endif; ?>
		</div></a>

<a href="#" id="linkn"><div class="tar3"><img src="/img/145.png"></div>
<div class="stat3">
             <?
if(isset($_SESSION["user_id"])):
$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = ".$_SESSION["user_id"]);
$data = $db->FetchArray();
$en = $data['ns'];
$perc = $en/100*100;
if ($perc>100)
  $perc = 100;
?>
<div style="  width: 120px;  border: 2px solid #5F5D5D;
             background-color: #8F908E;  border-radius: 5px;  -moz-border-radius: 5px;  -webkit-border-radius: 5px;  position: relative;  margin-top: 2px;  padding: 1px;  left: 50%;  margin-left: -60px;">
  <span style="  position: absolute;  color: #fff;  font-size: 9px;  text-align: center;  width: 100%;  top: 0;  left: 0;"><?=$en;?> / 100</span>
   <div style="width: <?=$perc;?>%; height: 9px;  background-color: #B5EC6F;  border-radius: 5px;  -moz-border-radius: 5px;  -webkit-border-radius: 5px;"></div>
</div>

<?endif; ?>
		</div></a>

</td></tr></table>

<div class="exit"><a href="/account/exit" id="linkx"><img src="/img/exit.png"></a></div>

</div>

<a href="#" id="linkp">
<div class="pokup"><img src="/img/serebro.png" width="40" height="40"></div>
<div class="pokup1"><a href="/account/kazna"><span style="color:#FFF;
    font-family:'Comic Sans MS', cursive;
    font-size:16px;text-shadow: #000 0 0 3px; 
    ">{!BALANCE_B!} </a></span></div></a>


<a href="#" id="links">
<div class="svin"><img src="/img/zoloto.png" width="40" height="40"></div>
<div class="svin1"><a href="/account/payment"><span style="color:#FFF;
    font-family:'Comic Sans MS', cursive;
    font-size:16px;text-shadow: #000 0 0 3px; 
    ">{!BALANCE_P!} </a></span></div></a>

<div class="clr-line4"></div>


<style>
.example4 {
    
    
    width: 100%;
    height: 50px;
    background: -moz-linear-gradient(#EFFFFF, #9A9389) repeat-x;
    background: -ms-linear-gradient(#EFFFFF, #9A9389) repeat-x;
    background: -o-linear-gradient(#EFFFFF, #9A9389) repeat-x;
    background: -webkit-linear-gradient(#EFFFFF, #78634F) repeat-x;
    bottom: -39;
    z-index: 34;
    left: 0px;
    position: fixed;
    color: #FAFFBD;
    font-family: 'Comic Sans MS', cursive;
    font-size: 15px;
    padding-top: 20px;

}


.example4:hover {
    width: 100%;
    height: 50px;
    background: -moz-linear-gradient(#EFFFFF, #9A9389) repeat-x;
    background: -ms-linear-gradient(#EFFFFF, #9A9389) repeat-x;
    background: -o-linear-gradient(#EFFFFF, #9A9389) repeat-x;
    background: -webkit-linear-gradient(#EFFFFF, #78634F) repeat-x;
    bottom: -39;
    z-index: 34;
    left: 0px;
    position: fixed;
    color: #FAFFBD;
    font-family: 'Comic Sans MS', cursive;
    font-size: 15px;
    padding-top: 20px;

}


.bottom {
    
    width: 150px;
    height: 60px;
    margin: 0px 0px 0px 20px;
    border: 1px solid #0C0C0C;
    background: rgba(66, 39, 22, 0.6);
    border-radius: 10px;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 18px;
    padding-top: 6px;

}


.bottom:hover {
    
    width: 150px;
    height: 60px;
    margin: 0px 0px 0px 20px;
    border: 1px solid #0C0C0C;
    background: rgba(66, 39, 22, 0.6);
    border-radius: 10px;
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 18px;
    padding-top: 6px;

}


</style>

<div class="clr-line3"></div>
<center>
<div class="example4">




</div>



</center>

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
	z-index:10;
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
	background: rgba(245, 245, 245, 0.72);
	border:1px solid #E0FFFF;
	line-height:130%;
	border-radius: 10px 10px 10px 10px;
        box-shadow: inset 0px 1px 10px 0px rgba(55, 55, 55, 0.400), 3px 5px 10px rgba(0, 0, 0, 0.402); text-align: center;
	z-index:100;
	}
	
	
#easyTooltip5{
	color: #fff;
	margin:0 10px 1em 0;
	/*width:100px;*/
	padding:4px;height:20px;
	background: rgba(128, 128, 128, 0.92);
	border: 2px solid #5F5D5D;
	line-height:130%;
	border-radius: 10px 10px 10px 10px;
         text-align: center;
	z-index:100;
	}
</style>


<script>
$(document).ready(function(){ 
$("a#linkm").easyTooltip({
yOffset: -20,
xOffset: -30,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Деревня</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linkm2").easyTooltip({
yOffset: -20,
xOffset: -30,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Рыцари</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linkm3").easyTooltip({
yOffset: -20,
xOffset: -30,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Ресурсы</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linkm4").easyTooltip({
yOffset: -20,
xOffset: -40,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Инструкция</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linkx").easyTooltip({
yOffset: -20,
xOffset: -30,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Выход</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linko").easyTooltip({
yOffset: -20,
xOffset: -20,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Опыт</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linken").easyTooltip({
yOffset: -20,
xOffset: -30,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Энергия</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linkn").easyTooltip({
yOffset: -20,
xOffset: -40,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Настроение</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linka").easyTooltip({
yOffset: -20,
xOffset: -40,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Это вы!</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#linkp").easyTooltip({
yOffset: -20,
xOffset: -50,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Серебро</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("a#links").easyTooltip({
yOffset: -20,
xOffset: -40,
tooltipId: "easyTooltip5", 
content: '<h4p><b>Золото</b></h4></p>'
});
});
</script>