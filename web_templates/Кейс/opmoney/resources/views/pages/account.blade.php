@extends('users')

@section('content')
    <main class="content">
        <div class="inner">
            <div class="account">
                <div class="userbox">
                    <div class="l">
                        <a href="/logout" class="logout">Выйти</a>
                        <img src="{{$u->avatar}}" alt="{{$u->username}}">
                        <h1>{{$u->username}} <a href="https://vk.com/{{$u->login}}" target="_blank"><span
                                        class="flaticon-soc-vk"></span></a></h1>
                        <div class="u-cases"><span class="flaticon-case"></span> Кейсы: <span class="n">{{$case}}</span></div>
                        <div class="u-money"><span class="flaticon-money"></span> Выигрыш: <span class="n">{{$win}}р</span>
                        </div>
                        <div class="u-balance"><span class="flaticon-ruble"></span> Баланс: <span class="n"><b
                                        id="u-balance-field">{{$u->money}}</b>р</span></div>
                    </div>
                    <div class="r">
                        <a href="/account/?group=admin&amp;act=balance_test"
                           style="text-decoration: none;color: #1f2331">aaaaaaaaaaaaaaaaaaaaaaaaa</a>
                        <a href="#deposit" onclick="popupOpen('#deposit');return false;" class="btn yellow">Пополнить
                            баланс</a>
                            <a href="#withdrawal" class="btn darkblue"
                                          onclick="popupOpen('#withdrawal');return false;">Вывод средств</a>
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="referral">
                    <div class="b1">
                        <h3><span class="flaticon-users"></span> Пригласи друзей и заработай больше!</h3>
                        <div class="desc">Отправь свой уникальный код друзьям<br> и <span>получи 5%</span> от каждого
                            пополнения баланса другом!
                        </div>
                        <div class="field"><input type="text" class="inp" value="{{$u->ref_code}}" readonly="readonly"
                                                  onclick="select();"></div>
                        <div class="short">По вашему коду зарегистрировались: {{$count_ref}}</div>
                    </div>
                    <div class="b2">
                        <div class="loader" id="redeem-loader"><img src="templates/frontend/default/images/loader.svg"
                                                                    alt=""></div>
                        @if($u->ref_use == NULL)
                            <h3><span class="flaticon-money"></span> Введи код и получи 10р!</h3>
                            <div class="desc">У вас есть партнерский код?<br> Введите его в поле и
                                <span>получите 10 рублей</span> прямо сейчас!
                            </div>
                            <div class="field">
                                <input type="text" class="inp redeem-input">
                                <input type="button" class="btn" value="OK"
                                       onclick="RedeemCode($('.redeem-input'), this, '#redeem-loader');">
                            </div>
                            <div class="short">Введите код и нажмите enter</div>
                        @else
                            <h3><span class="flaticon-money"></span> Введи код и получи 10р!</h3>
                            <div class="desc">У вас есть партнерский код?<br> Введите его в поле и
                                <span>получите 10 рублей</span> прямо сейчас!
                            </div>
                            <div class="field">
                                <input type="text" class="inp redeem-input" value="{{$u->ref_use}}">
                            </div>
                            <div class="short"><span class="flaticon-check"></span>Код успешно активирован!</div>
                        @endif
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="tab-container tab-container-1 active">
                    <div class="cls"></div>
                    @if($items == [])
                    <div class="infobox text-center"><br>
                        <h3>
                            <center>Вы не открывали кейсов :(</center>
                        </h3>
                        <a href="/" class="btn rounded blue">Открыть и выиграть</a><br><br>
                    </div>
                    @else
                        <div class="history-cases">
                            <div class="cls"></div>
                            @foreach($items as $i)
                            <div class="history-case">
                                <a href="/cases/{{$i->cases_id}}" class="eas case-url">Кейс №{{$i->cases_id}}</a>
                                <div class="status"><span class="flaticon-check"></span></div>
                                <div class="coin silver">
                                    <img src="{{$i->img}}" alt="{{$i->price}} рублей">
                                </div>
                            </div>
                            @endforeach
                            <div class="cls"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="seperator"></div>
        </div>
    </main>
@endsection
