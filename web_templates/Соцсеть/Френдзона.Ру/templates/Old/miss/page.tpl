<link rel="stylesheet" type="text/css" href="http://st0.vk.me/css/al/wkview.css" />



<div class="ava_miss_page">
<span id="ava" class="ava_miss_page"><img src="{ava}" />
<div class="rate_miss_page">
<div><b>{rate-ava}</b></div>
</div>
<button class="fs-profile-show" title="Отправить сообщение" onclick="messages.new_({user-id}); return false" href="/">
Отправить сообщение
<br>
</button>
<button class="fs-profile-show" title="Отправить подарок" onclick="gifts.box('{user-id}'); return false" href="/">
Отправить подарок
<br>
</button>
<button class="fs-profile-show" title="Смотреть профиль" onclick="Page.Go('/u{user-id}'); return false;">
Профиль на сайте
<br>
</button>

</span>
</div>
<div class="profiewr_page_miss">
<div class="titleu_page_miss">{name}</div>
<div class="load_photo_quoteuu">Данная страница пренадлежит участнице <a href="/u{user-id}" onclick="Page.Go(this.href); return false;">{name}</a>. <br>Здесь Вы можете перейти на полную версию странички участницы, либо проголосовать за её, с помощью кнопок расположенных справа.</div>
</div>


<div class="box_right_owne" style=" margin-top: -28px;">
<div class="news_a_owne"><a onclick="miss.vote({user-id},1); return false;"><div><span class="like_miss"> </span>Нравится </div></a></div>
<div class="news_a_owne"><a onclick="miss.vote({user-id},2); return false;"><div><span class="like_miss_no"> </span>Не нравится </div></a></div>
<div class="news_a_owne"><a onclick="Page.Go('/miss'); return false;"><div>Вернуться назад </div></a></div>
[group=1]
<div class="admin_miss">Админ-панель</div>
<input id="newrate" class="videos_input" type="text" style="margin-top: 5px; color: #000; width: 191px; border: medium none; border-radius: 5px;">
<div class="news_a_owne"><a onclick="amiss.newrate({user-id}); return false;"><div>Повысить рейтинг</div></a></div>
<div class="news_a_owne"><a onclick="amiss.delet({user-id}); return false;"><div>Оннулировать рейтинг</div></a></div>

[/group]

</div>
<style type="text/css" media="all">

.box_sdsss {
    background: url("{theme}/images/miss.jpg") repeat-y scroll 0 0 / 52em auto #FFFFFF;
    height: 100%;
    margin: auto auto auto 222px;
    position: fixed;
    top: 0;
    width: 577px;
    z-index: 0;
}</style>