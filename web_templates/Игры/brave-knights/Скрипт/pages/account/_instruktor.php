<div class="block1
"><div class="h-title1
">Инструкция</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<BR />
<?PHP
$_OPTIMIZATION["title"] = "Инструкция";
$usid = $_SESSION["user_id"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
?>

<script type="text/javascript" src="http://yourjavascript.com/21139232152/bxslider.min.js"></script>
<script type="text/javascript" src="http://yourjavascript.com/11225442391/common.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#slider1').bxSlider({
  auto: true,           // true, false - автоматическая смена слайдов
  speed: 2000,      // целое число - в милисекундах, скорость смены слайдов
 pause: 55000,  // целое число - в милисекундах, период между сменами слайдов
    });
  });
</script><div id="slider_cont">
<div id="slider1">


<div>
<center>

<font color = 'red'><b>Подробнее о постройках:</b></font>
<BR >

Для строительства любого здания требуется определенное кол-во строительных материалов. Их следует купить в торговой лавке. Для чего же нужны нам эти постройки и какой доход они могут принести? После строительства все здания выполняют роль фабрик и заводов. Вы можете сами производить строительные материалы и продукцию для столовой. Все постройки будут служить вам 1 год, после чего нужно их обновить.

<table cellpadding="3" cellspacing="0" align="center" width="90%" border='1' bordercolor='#336633' class="table_info">
    <tbody><tr align="center" class="m-tb">
<td>Постройки</td>
        
        <td>Склад</td>
        <td>Мельница</td>
<td>Кирпичный завод</td>
<td>Пилорама</td>
<td>Литейный завод</td>
    </tr>
            
<tr align="center" class="htt">
<td>Кирпичей</td>
<td>-</td>
<td>2000</td>
<td>2000</td>
<td>2000</td>
<td>2000</td>

</tr>
<tr align="center" class="htt">
<td>Досок</td>
<td>3000</td>
<td>2000</td>
<td>2000</td>
<td>2000</td>
<td>2000</td>

</tr>    
<tr align="center" class="htt">
<td>Стали</td>
<td>-</td>
<td>1000</td>
<td>1000</td>
<td>1000</td>
<td>1000</td>



</tr></tbody>
</table>
<table cellpadding="3" cellspacing="0" align="center" width="90%" border='1' bordercolor='#336633' class="table_info">
    <tbody><tr align="center" class="m-tb">
<td>Постройки</td>
        
        <td>Загоны</td>
        <td>Пекарня</td>
<td>Шашлычная</td>
<td>Колбасный
цех</td>
<td>Пивоварня</td>
    </tr>
            
<tr align="center" class="htt">
<td>Кирпичей</td>
<td>-</td>
<td>3000</td>
<td>3000</td>
<td>3000</td>
<td>3000</td>

</tr>
<tr align="center" class="htt">
<td>Досок</td>
<td>3000</td>
<td>2000</td>
<td>2000</td>
<td>2000</td>
<td>2000</td>

</tr>    
<tr align="center" class="htt">
<td>Стали</td>
<td>-</td>
<td>1000</td>
<td>2000</td>
<td>2000</td>
<td>1000</td>


</tr></tbody>
</table>
</center>
</div>

<div>
<center>



<font color = 'red'><b>Таблица переработки продукции за 24 часа:</b></font>
<table cellpadding="3" cellspacing="0" align="center" width="90%" border='1' bordercolor='#336633' class="table_info">
    <tbody><tr align="center" class="m-tb2">
<td>Заводы
</td>
        
        <td><div colspan="3"><img src="/img/fruit/2.png" width="83" height="83" name="slide_show"></div></td>
        <td><div colspan="3"><img src="/img/fruit/3.png" width="83" height="83" name="slide_show"></div></td>
<td><div colspan="3"><img src="/img/fruit/4.png" width="83" height="83" name="slide_show"></div></td>
<td><div colspan="3"><img src="/img/fruit/5.png" width="83" height="83" name="slide_show"></div></td>
    </tr>
            
<tr align="center" class="htt">
<td>Загружаем</td>
<td>Пшеницу</td>
<td>Глину</td>
<td>Бревна</td>
<td>Руду</td>

</tr>
<tr align="center" class="htt">
<td>Кол-во</td>
<td>100</td>
<td>200</td>
<td>200</td>
<td>200</td>

</tr>    
<tr align="center" class="htt">
<td>Получаем</td>
<td>Муку</td>
<td>Кирпичи</td>
<td>Доски</td>
<td>Сталь</td>

</tr>
<tr align="center" class="htt">
<td>Кол-во</td>
<td>100</td>
<td>200</td>
<td>200</td>
<td>200</td>

</tr></tbody>
</table>


<table cellpadding="3" cellspacing="0" align="center" width="90%" border='1' bordercolor='#336633' class="table_info">
    <tbody><tr align="center" class="m-tb2">
<td>Фабрики
</td>
       
        <td><div colspan="3"><img src="/img/fruit/8.png" width="83" height="83" name="slide_show"></div></td>
        <td><div colspan="3"><img src="/img/fruit/10.png" width="83" height="83" name="slide_show"></div></td>
<td><div colspan="3"><img src="/img/fruit/6.png" width="83" height="83" name="slide_show"></div></td>
<td><div colspan="3"><img src="/img/fruit/9.png" width="83" height="83" name="slide_show"></div></td>
    </tr>
            
<tr align="center" class="htt">
<td>Загружаем</td>
<td>Муку</td>
<td>Баранину</td>
<td>Конину</td>
<td>Пшеницу</td>

</tr>
<tr align="center" class="htt">
<td>Кол-во</td>
<td>100</td>
<td>100</td>
<td>100</td>
<td>100</td>

</tr>    
<tr align="center" class="htt">
<td>Получаем</td>
<td>Хлеб</td>
<td>Шашлык</td>
<td>Колбасу</td>
<td>Пиво</td>

</tr>
<tr align="center" class="htt">
<td>Кол-во</td>
<td>100</td>
<td>100</td>
<td>100</td>
<td>100</td>

</tr></tbody>
</table>
</center>
</div>


<div>
<center>
<font color = 'red'><b>Загоны:</b></font>

<BR >
После строительства загона вам будет доступна покупка двух животных: овца и лошадь. Они принесут вам мясную продукцию. Мясо можно продавать за золото в торговой лавке или приготовить шашлык и колбасу. Переработанную продукцию можно поставлять под реализацию в главную столовую. Продукция на складе не портится. Животные живут вечно и не умирают. 
<BR >
<BR >
<font color = 'red'><b>Таблица доходности животных:</b></font>
<table cellpadding="3" cellspacing="0" align="center" width="90%" border='1' bordercolor='#336633' class="table_info">
    <tbody><tr align="center" class="m-tb2">
<td>Постройка</td>
        
        <td><div colspan="3"><img src="/img/fruit/ovca.png" width="85" height="100" name="slide_show"></div></td>
        <td><div colspan="3"><img src="/img/fruit/loshadi.png" width="85" height="100" name="slide_show"></div></td>

    </tr>
            
<tr align="center" class="htt">
<td>Цена: сер.</td>
<td>10000</td>
<td>20000</td>


</tr>
<tr align="center" class="htt">
<td>Мяса/ч.</td>
<td>1</td>
<td>2</td>


</tr>    
<tr align="center" class="htt">
<td>Доход %/мес.</td>
<td>28,8%</td>
<td>28,8%</td>


</tr></tbody>
</table>

</center>
</div>
<div>

<center>
<font color = 'red'><b>Общие положения и правила:</b></font><BR >
Игровые валюты проекта: серебро (счет для покупок) и золото (счет для вывода). Курс серебра: 100 серебра = 1 рублю. Курс золота 100 золота = 1 рублю. После пополнения вы получаете серебро на счет для покупок. Вся прибыль на проекте выдается золотом на счет для вывода. Бонусы выдаются серебром. На первое пополнение вы получаете +50% от вашего вложения.
<BR >

<font color = 'red'><b>Уровни:</b></font><BR >
Проект имеет бесконечное колличество уровней, каждый из которых состоит из 100 баллов. Баллы вы набираете, выполняя определенные действия в игре ( собрать, продать, купить). По достижению нескольких уровней, вам ставятся доступными новые возможности, что позволяет зарабатывать еще больше. 
<BR >
 
<font color = 'red'><b>Энергия и настроение:</b></font><BR >
В отличае от уровней, энергия и настроение, наоборот отнимаются у вас за определенные действия в игре. Если шкала показывает 0/100 единиц, то вы не сможете работать (собирать, продавать, покупать). Ваши силы иссякли. Энергию можно пополнить в главной столовой. Для этого нужно купить готовую продукцию и покушать ее в этой же столовой. Настроение можно поднять выпив пива в баре "Охотник!" 
<BR >
Все заработанное вами золото выводится в автоматическом режиме. Желаем вам успехов и хорошего заработка!
</center>
 </div>




<div>

<center>

<font color = 'red'><b>Как начать играть?</b></font>
<BR >
Итак. Вы прошли регистрацию и перешли на игровое поле. Это ваше маленькое государство.
Чтобы спастись от разбойников, вам необходимо создать свое войско - нанять рыцарей. Каждый воин несет определенную службу и приносит золото в вашу казну. Чтобы собирать ресурсы, нужно купить стройматериалы в лавке и построить склад. Ресурсы находятся за пределами ваших ворот, поэтому подвергаются нападению разбойников. Чтобы сохранить все добытые ресурсы, следует собирать их на склад не менее 2-х раз в сутки. То есть, чтобы начать играть и получать доход, <BR >нужно нанять рыцарей и построить склад. Срок службы воинов - 3 мес. 

<BR >


<font color = 'red'><b>Таблица доходности рыцарей:</b></font>

<table cellpadding="3" cellspacing="0" align="center" width="92%" border='1' bordercolor='#336633' class="table_info">
    <tbody><tr align="center" class="m-tb2">
<td>Воин</td>
        <td><div colspan="3"><img src="/img/fruit/r1.png" width="60" height="85" name="slide_show"></div></td>
        <td><div colspan="3"><img src="/img/fruit/r2.png" width="60" height="85" name="slide_show"></div></td>
        <td><div colspan="3"><img src="/img/fruit/r3.png" width="60" height="85" name="slide_show"></div></td>
<td><div colspan="3"><img src="/img/fruit/r4.png" width="60" height="85" name="slide_show"></div></td>
<td><div colspan="3"><img src="/img/fruit/r5.png" width="60" height="85" name="slide_show"></div></td>
<td><div colspan="3"><img src="/img/fruit/r6.png" width="60" height="85"  name="slide_show"></div></td>
    </tr>
            
<tr align="center" class="htt">
<td>Цена: сер.</td>
<td>5500</td>
<td>11000</td>
<td>20000</td>
<td>50000</td>
<td>100000</td>
<td>200000</td>
</tr>
<tr align="center" class="htt">
<td>Ресурсы/ч.</td>
<td>1</td>
<td>2</td>
<td>4</td>
<td>11</td>
<td>70</td>
<td>-</td>
</tr>    
<tr align="center" class="htt">
<td>%/мес.</td>
<td>39,2%</td>
<td>41,1%</td>
<td>43,2%</td>
<td>47,5%</td>
<td>50,4%</td>
<td>Все*2</td>
</tr></tbody>
</table>
</center>
</div>





</div></div>






<style>
/* оформление и размер блока */
#slider_cont {
    border: 0px solid #006699;
    margin: 0px;
    width: 555px!important;
    padding: 0px;
}

/* кнопка следующее изображение */
.bx-prev {
position:absolute;
top:-2%;
left:0px;
width:31px;z-index: 15;
    
height:31px;
text-indent:-999999px;
background:url(/img/prev.png) no-repeat  0 -30px;
}

/* кнопка предыдущее изображение */
.bx-next {
position:absolute;
top:-2%;
right:-6px;z-index: 11;
    
width:31px;
height:31px;
text-indent:-999999px;z-index: 11;
    
background:url(/img/next.png) no-repeat 0 -30px;
}

/* для кнопок при наведении курсора */
.bx-next:hover {
background:url(/img/next1.png) no-repeat 0 -30px;
border:0;
}
/* для кнопок при наведении курсора */
.bx-prev:hover {
background:url(/img/prev1.png) no-repeat  0 -30px;
border:0;
    
}
.block2 {
background: url('/img/block2.png') repeat-y;
    position: relative;
    z-index: 10;
    left: 50%;
    margin-left: -160px;
    padding: -3px 50px 0px 50px;
    float: center;
    height: 480px;
    overflow: auto;
    color: #000000;
    font-family: 'Comic Sans MS', cursive;
    font-size: 11pt;
    width: 560px;}
</style>




 



<div class="clr"></div>
</div></div></div>
<div class="block3"></div>
<div class="clr"></div>	



<div id="link1" style="
    width: 270px;
    height: 455px;
    position: absolute;
    top: 320px;
    left: 50%;
    margin-left: -510px;
    background: url('../img/fruit/girl.png') 0 0 no-repeat;
    z-index: 10;
    

"></div>
