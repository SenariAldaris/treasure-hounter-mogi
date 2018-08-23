﻿<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>EDDCASH.RU - Только победа!</title>
    <meta name="description" content="Плейси - Только победа!"/>
    <meta name="keywords" content="Плейси,открытие кейсов,призовые кейсы,дропы,кейсы"/>
    <base href="/"/>
     <meta name="author" content="Scripts-Shop.Su (http://scripts-shop.su)"/>
    <link rel="stylesheet" href="/templates/frontend/default/css/style.min.css?v=18-1475954176"/>
    <meta name="csrf-token" content="{!!  csrf_token()   !!}">
    <script type="text/javascript" src="/templates/frontend/default/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="/templates/frontend/default/js/core.js?v=116-1475954176"></script>
    <script type="text/javascript" src="/templates/frontend/default/js/socket.io-1.4.5.js"></script>
    <script type="text/javascript" src="/templates/frontend/default/js/jquery.corner.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <script src="//ulogin.ru/js/ulogin.js"></script>

</head>
<body>
<div class="wrapper">
    <header class="header">
        <div class="inner">
            <div class="logo"><a href="/"><img src="/uploads/logo.png" alt="epicdrop"></a>
            </div>
            <div class="stat">
                <div class="o" style="
    color: #FFEA05;
    text-shadow: 0 0 30px #e4ae39;
    font-size: 13px;
    font-weight: bold;
    display: block;
    line-height: 1;
    margin-bottom: 8px;
    text-transform: uppercase;
">Онлайн <div id="st-online">-</div></div>
                  <div class="l"></div>
                  <div class="o" style="
     text-shadow: 0 0 30px #e4ae39;
     color: #FFEA05;
    font-size: 13px;
    font-weight: bold;
    display: block;
    line-height: 1;
    margin-bottom: 8px;
    text-transform: uppercase;
">Пользователей <div id="st-users">-</div></div>
                  <div class="l"></div>
                  <div class="o" style="
     text-shadow: 0 0 30px #e4ae39;
     color: #FFEA05;
    font-size: 13px;
    font-weight: bold;
    display: block;
    line-height: 1;
    margin-bottom: 8px;
    text-transform: uppercase;
">Открыто кейсов <div id="st-cases">-</div></div>
                  <div class="cls">
                </div>
            </div>
            <div class="u-menu">
                @if(Auth::guest())
                <ul class="social-login">
                    <a href="/login"><li class="btn sexy gradient-blue icon-r flaticon-vk"><b>Войти через</b> <span class="flaticon-soc-vk"></span></li></a>
                </ul>
                @else
                <div class="userpic"><a href="/account/"><img src="{{$u->avatar}}" alt="{{$u->username}}"></a></div>
                <div class="userinfo">
                    <div class="name"><a href="/account/" class="eas">{{$u->username}}</a></div>
                    <div class="price"><span class="flaticon-money"></span> <b id="user-balance">{{$u->money}}</b><span class="flaticon-ruble ruble-small"></span> <span class="plus eas" onclick="popupOpen('#deposit');">+</span> <span class="minus eas" onclick="popupOpen('#withdrawal');">-</span></div>
                </div>
                @endif
                <div class="cls"></div>
            </div>

            <nav class="nav">
                <div class="nav-button"><span class="flaticon-menu"></span></div>
                <ul>
              @if(Auth::guest())
              <li><a href="/" class="eas active">Кейсы</a></li>
              <li><a href="/faq" class="eas ">FAQ</a></li>
              <li><a href="/reviews/" class="eas ">Отзывы</a></li>
              @else
              <li><a href="/" class="eas active">Кейсы</a></li>
		      
              <li><a href="/faq" class="eas ">FAQ</a></li>
              <li><a href="/reviews/" class="eas ">Отзывы</a></li>
			  
              </b> </li>
              @endif
              </ul>
            </nav>
            <div class="cls"></div>
        </div>
    </header>
    <div class="sub-header">
        <div class="inner">
            <div class="live">
			<div class="name">Live лента</div>
                <div class="prize" id="live-prize-box">
                    <br><br>Загрузка...<br><br><br>
                </div>
                <div class="cls"></div>
            </div>
            <div class="cls"></div>
        </div>
    </div>
    @yield('content')
    <footer class="footer">
        <div class="inner">
            <div class="l">
              <ul>
                  <li><a href="/" class="eas ">Кейсы</a></li>
                  <li><a href="/faq" class="eas">FAQ</a></li>
                  <li><a href="/guarantee" class="eas ">Гарантии</a></li>
                  <li><a href="/reviews" class="eas ">Отзывы</a></li>
              </ul>
                <div class="copy">
                    Copyright &copy; 2016 EDDCASH.RU!. Все права защищены.<br>Авторизуясь на сайте вы принимаете <a
                            href='/terms'>пользовательское соглашение</a><br>
                </div>
            </div>
            <div class="r">
                <h5>Принимаем</h5>
                <div class="cls"></div>
                <div class="img"><img src="templates/frontend/default/images/payment-methods.png?v=2" alt="Принимаем">
                </div>
                <div class="wm-box">
                    <a href="//www.free-kassa.ru/" target="_blank" rel="nofollow"><img
                                src="/templates/frontend/default/images/payment-freekassa.png?v=3"></a>
                </div>
                <div class="cls"></div>
            </div>
            <div class="cls"></div>
        </div>
    </footer>
</div><!-- .wrapper -->
@if(!Auth::guest())
    <div id="deposit" class="popup">
        <div class="popup-container">
            <div class="eas close" onclick="popupClose('#deposit');"><span class="flaticon-close"></span></div>
            <h3>Пополнить баланс</h3>

            <div class="info">Баланс начисляется моментально, но иногда процесс может занять 1-2 минуты Для других платежных систем выберите Interkassa или FreeKassa
              <br> </div><h4>Сумма</h4>
            <div class="cls"></div>
            <div class="amount-l">
                <form name="form-deposit" id="form-deposit" method="post" action="/pay" enctype="utf-8">
                  <input type="hidden" name="ik_co_id" value="sdesjtvoikod" />
                  <input type="hidden" name="ik_pm_no" value="ID_4233" />
                  <input type="hidden" name="ik_cur" value="RUB" />
                  <input type="hidden" name="ik_desc" value="Пополнение на сайте playcraftpe" />
                  <input type="hidden" name="ik_x_user_id" value="{{$u->id}}" />
                  <input type="hidden" name="pm" id="pm" value="qiwi" />
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                  <input type="text" name="ik_am" class="inp" maxlength="5" value="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onchange='if (this.value < 10) this.value=1; if (this.value > 15000) this.value=15000'>
                </form>
            </div>
            <div class="amount-r">
                Максимальная сумма за раз: <b>15000р</b><br>Минимальная сумма: <b>10р</b>
            </div>
            <div class="cls"></div>
            <h4>Выберите платежную систему</h4>
            <div class="cls"></div>
            <span class="payment-method eas pm-qiwi active" onclick="changePaymentMethod('qiwi');"><img src="/uploads/payment-qiwi.svg" alt="WebMoney"><span class="flaticon-check"></span></span>
            <span class="payment-method eas pm-card" onclick="changePaymentMethod('card');"><img src="/uploads/payment-card.svg" alt="WebMoney"><span class="flaticon-check"></span></span>
            <span class="payment-method eas pm-mts" onclick="changePaymentMethod('mts');"><img src="/uploads/payment-mts.svg" alt="WebMoney"><span class="flaticon-check"></span></span>
            <span class="payment-method eas pm-biline" onclick="changePaymentMethod('biline');"><img src="/uploads/payment-biline.svg" alt="WebMoney"><span class="flaticon-check"></span></span>
            <span class="payment-method eas pm-mega" onclick="changePaymentMethod('mega');"><img src="/uploads/payment-mega.svg" alt="WebMoney"><span class="flaticon-check"></span></span>
            <span class="payment-method eas pm-tele2" onclick="changePaymentMethod('tele2');"><img src="/uploads/payment-tele2.svg" alt="WebMoney"><span class="flaticon-check"></span></span>



            <span class="payment-method eas pm-pay_inter" onclick="changePaymentMethod('pay_inter');"><img src="/uploads/payment-interkassa.svg" alt="WebMoney"><span class="flaticon-check"></span></span>

            <div class="cls"></div></form><div class="foo">
              <input type="button" class="btn orange rounded" value="Пополнить баланс" onclick="depositNow();"></div>
        </div>
        <div class="popup-overlay" onclick="popupClose('#deposit');"></div>
    </div>
    <div id="withdrawal" class="popup">
        <div class="popup-container">
            <form name="form-withdrawal" id="form-withdrawal" method="get">
                <div class="loader"><img src="templates/frontend/default/images/loader.svg" alt=""></div>
                <div class="eas close" onclick="popupClose('#withdrawal');"><span class="flaticon-close"></span></div>
                <h3>Вывод средств</h3>
                <div class="info">Обработка вывода обычно осуществляется в течении часа.<br>В некоторых случаях платеж может быть обработан до 24 часов.<br>Минимальная сумма к выводу <b>100р</b></div><div class="cls"></div>
                <div class="amount-l">
                    <h4>Сумма</h4>
                    <input type="text" name="amount" id="amountVivod" class="inp" maxlength="5" value="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onchange='if (this.value < 100) this.value=100'>
                    <input type="hidden" name="type" id="withdrawal-type-field" value="webmoney">
                </div>
                <div class="amount-r amount-r2">
                    <h4>Номер кошелька</h4>
                    <input type="text" name="koshelek" id="koshelekVivod" class="inp PurseHolder" maxlength="16" placeholder="Пример: 7900123456">
                </div>
                <div class="cls"></div><h4>Куда хотите вывести?</h4>
                <div class="cls"></div><span class="payment-method eas pm-qiwi" onclick="changePaymentMethod('qiwi','Пример: 7900123456');"><img src="/uploads/images/payment-qiwi.svg" alt="QIWI"><span class="flaticon-check"></span></span><div class="cls"></div><div class="foo foo-2"><input type="button" class="btn blue rounded" value="Вывести средства" onclick="withdrawalNow();"></div>
            </form>
        </div>
        <div class="popup-overlay" onclick="popupClose('#withdrawal');"></div>
    </div>
@else

@endif
<div class="ie-update"><h3>Ваш браузер устарел :(</h3>Пожалуйста, <a
            href='http://windows.microsoft.com/en-us/internet-explorer/download-ie' rel='nofollow' target='_blank'>скачайте
        новую версию</a> Internet Explorer<br>
    <small>Однако мы рекомендуем Google Chrome, Firefox и Safari.</small>
</div>
<!--[if IE]></div><![endif]--><a class="vk-button" href="https://vk.com/warface2107" rel="nofollow" target="_blank"><span
            class="flaticon-soc-vk"></span> Мы вконтакте!</a>
</body>
</html>
