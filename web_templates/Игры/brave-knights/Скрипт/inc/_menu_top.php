
<?php
		if(isset($_SESSION["user"])){


		} else {
		?>

<style>
.example3 {
    
    width: 100%;
    height:60px;
    background:url("/img/a1.png") repeat-x;
   
    left: 0px;
top: -60;  z-index:500;

     position:  fixed;
    /*оформление текста*/
    color:#FFF;
    font-family:'Comic Sans MS', cursive;
    font-size:20px; 
    padding-top:50px;

}


.example3:hover {
    width: 100%;
    height:60px;
    background:url("/img/a1.png") repeat-x;
   
    left: 0px;
top: -60;  z-index:500;

     position:  fixed;
    /*оформление текста*/
    color:#FFF;
    font-family:'Comic Sans MS', cursive;
    font-size:20px; 
    padding-top:50px;

}

.top {
    background:url("/img/top1.png") no-repeat;
    width: 108px;
    height: 31px;
    margin: 0px 0px 0px 20px;
    
    
    
    
    border-radius: 10px;
    
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 14px;
    padding-top: 6px;

}


.top:hover {
    background:url("/img/top2.png")  no-repeat;
    width: 108px;
    height: 31px;
    cursor: pointer;
   
    
    
    
    border-radius: 10px;
    
    color: #FFF;
    font-family: 'Comic Sans MS', cursive;
    font-size: 14px;
    padding-top: 6px;

}
</style>


<center>
<div class="example3">


<div class="top" style=" width: 108px;
    height: 31px;        position: fixed;  margin-left: -450px; top: 6px; left: 50%; z-index: 50;
"onclick="location.href='/';
 "/>Главная</div>

<div class="top" style=" width: 108px;
    height: 31px;        position: fixed;  margin-left: -290px; top: 6px; left: 50%; z-index: 50;
"onclick="location.href='/about';
 "/>О проекте</div>

<div class="top" style=" width: 108px;
    height: 31px;        position: fixed;  margin-left:  -135px; top: 6px; left: 50%; z-index: 50;
"onclick="location.href='/news';
 "/>Новости</div>

<div class="top" style=" width: 108px;
    height: 31px;        position: fixed;  margin-left:  20px; top: 6px; left: 50%; z-index: 50;
"onclick="location.href='http://mmgp.ru/showthread.php?t=419866';
 "/>Форум</div>
 
<div class="top" style=" width: 108px;
    height: 31px;        position: fixed;  margin-left:  180px; top: 6px; left: 50%; z-index: 50;
"onclick="location.href='/contacts';
 "/>Контакты</div>
 
 <div class="top" style=" width: 108px;
    height: 31px;        position: fixed;  margin-left:  340px; top: 6px; left: 50%; z-index: 50;
"onclick="location.href='/youtube';
 "/>Видео</div>

</center>
<div class="clr-line4"></div>


<?php } ?>