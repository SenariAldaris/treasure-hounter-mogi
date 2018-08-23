<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <title>STOREGAMER.RU - ТОЛЬКО ПОБЕДА!</title>
    <meta name="description" content="STOREGAMER.RU  - Только победа!"/>
    <meta name="keywords" content="STOREGAMER.RU ,открытие кейсов,призовые кейсы,дропы,кейсы"/>
    <base href="/"/>
    <meta name="author" content="Perfecto Web (http://perfecto-web.pro)"/>
    <link rel="stylesheet" href="/templates/frontend/default/css/style.min.css?v=18-1475954176"/>
    <meta name="csrf-token" content="{!!  csrf_token()   !!}">
    <script type="text/javascript" src="/templates/frontend/default/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="/templates/frontend/default/js/core.js?v=116-1475954176"></script>
    <script type="text/javascript" src="/templates/frontend/default/js/socket.io-1.4.5.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <meta name="interkassa-verification" content="2e052ba950bf9b22c10d019466f21f65" />
    <script src="//ulogin.ru/js/ulogin.js"></script>
</head>
<body>
<!--[if lt IE 6]>
<div class="ie6"><![endif]-->
<!--[if IE 7]>
<div class="ie7"><![endif]-->
<!--[if IE 8]>
<div class="ie8"><![endif]-->
<!--[if gt IE 8]>
<div class="ie9"><![endif]-->
<div class="wrapper">
    <header class="header">
        <div class="inner">
            <div class="logo"><a href="/"><img src="/uploads/logo.png" alt="epicdrop"></a>
            </div>
            <div class="stat">
                <div class="o">Онлайн <div id="st-online">-</div></div>
                  <div class="l"></div>
                  <div class="o">Пользователей <div id="st-users">-</div></div>
                  <div class="l"></div>
                  <div class="o">Открыто кейсов <div id="st-cases">-</div></div>
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
                  <li><a href="/support" class="eas active">Кейсы</a></li>
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
                <div class="prize" id="live-prize-box">
                    <br><br>Загрузка...<br><br><br>
                </div>
                <div class="cls"></div>
            </div>
            <div class="cls"></div>
        </div>
    </div>
    @yield('content')

</div><!-- .wrapper -->
@if(!Auth::guest())
    <div id="deposit" class="popup">
        <div class="popup-container">
            <div class="eas close" onclick="popupClose('#deposit');"><span class="flaticon-close"></span></div>
            <h3>Пополнить баланс</h3>
            <div class="info">Вы можете пополнить баланс напрямую через WebMoney и Яндекс Деньги.<br> Если вы хотите пополнить баланс через QIWI, Банковские карты, мобильного оператора, терминал и так далее, пожалуйста, выберите Interkassa или Free-Kassa</div><h4>Сумма</h4>
            <div class="cls"></div>
            <div class="amount-l">
                <form name="form-deposit" id="form-deposit" method="post" action="https://sci.interkassa.com/" enctype="utf-8">
                  <input type="hidden" name="ik_co_id" value="5824a8c33b1eaf475a8b456d" />
                  <input type="hidden" name="ik_pm_no" value="ID_4233" />
                  <input type="hidden" name="ik_cur" value="RUB" />
                  <input type="hidden" name="ik_desc" value="Пополнение на сайте epicdrop" />
                  <input type="hidden" name="ik_x_user_id" value="{{$u->id}}" />
                  <input type="text" name="ik_am" class="inp" maxlength="5" value="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' onchange='if (this.value < 10) this.value=10; if (this.value > 15000) this.value=15000'>
                </form>
            </div>
            <div class="cls"></div>
            <div class="cls"></div><div class="cls"></div></form><div class="foo"><input type="button" class="btn orange rounded" value="Пополнить баланс" onclick="depositNow();"></div>
        </div>
        <div class="popup-overlay" onclick="popupClose('#deposit');"></div>
    </div><div id="withdrawal" class="popup">
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
<!--[if IE]></div><![endif]--><a class="vk-button" href="http://storegamer.ru" rel="nofollow" target="_blank"><span
            class="flaticon-soc-vk"></span> Мы в STOREGAMER.RU !</a>
</body>
</html>
