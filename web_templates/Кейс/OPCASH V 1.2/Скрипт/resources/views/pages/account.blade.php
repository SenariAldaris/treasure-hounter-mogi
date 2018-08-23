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
                <div class="tabs">
                  <div class="tab tab-1 eas active" data-tab-id="1">Призы</div>
                  <div class="tab tab-2 eas" data-tab-id="2">История</div>
                  <div class="tab tab-3 eas" data-tab-id="3">Финансы</div>
                  <div class="tab tab-4 eas" data-tab-id="4">Доставка</div>
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
                            @foreach($gifts as $gift)
                            <div class="history-case">
                                <a href="/cases/{{$gift->case_id}}" class="eas case-url">Кейс №{{$gift->case_id}}</a>
                                @if($gift->status == 0)
                                <div class="status3" id="send" title="Send item" data-id="{{$gift->id}}">
                                  ⥯
                                </div>
                                <div class="status2" id="sell" title="Sell gift for 50%"   data-id="{{$gift->id}}">
                                  $
                                </div>
                                @endif
                                @if($gift->status == 1)
                                <div class="status">
                                  $
                                </div>
                                @endif
                                @if($gift->status == 2)
                                <div class="status">
                                  ♺
                                </div>
                                @endif
                                @if($gift->status == 3)
                                <div class="status">
                                  <span class="flaticon-check"></span>
                                </div>
                                @endif
                                <div class="coin silver">
                                    <img src="{{$gift->img}}" alt="{{$gift->price}} рублей">
                                </div>
                            </div>
                            @endforeach
                            @foreach($items as $i)
                            @if($i->price == 12345)

                            @else
                            <div class="history-case">
                                <a href="/cases/{{$i->cases_id}}" class="eas case-url">Кейс №{{$i->cases_id}}</a>
                                <div class="status">
                                  <span class="flaticon-check"></span>
                                </div>
                                <div class="coin silver">
                                    <img src="{{$i->img}}" alt="{{$i->price}} рублей">
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <div class="cls"></div>
                        </div>
                    @endif
                </div>
                <div class="tab-container tab-container-2">
                  <div class="part part-header">
                    <div class="p-n">Кейс</div>
                    <div class="p-id">Потратил</div>
                    <div class="p-name">Получил</div>
                    <div class="cls"></div>
                  </div>
                  @if($cases == null)
                  <div class="infobox">
                  <div class='text-center'>Скоро тут будут ваши миллиарды ;)
                  </div>
                  </div>
                  @else
                  @foreach($cases as $case)
                  <div class="part">
                  <div class="p-n"><a href="/cases/{{$case->case_id}}">#{{$case->case_id}}</a></div>
                  <div class="p-id">{{$case->case_price}}</div>
                  <div class="p-name">
                    @if($case->price == 12345)
                      {{$case->name}}
                    @else
                      {{$case->price}}
                    @endif</div>
                  <div class="cls"></div>
                  </div>
                  @endforeach
                  @endif
              </div>
              <div class="tab-container tab-container-3">
                <div class="part part-header">
                  <div class="p-n">№</div>
                  <div class="p-id">Сумма</div>
                  <div class="p-name">Система</div>
                  <div class="p-games">Действие</div>
                  <div class="cls"></div>
                </div>
                @if($mo == null && $mo2 == null && $vivod == null)
                <div class="infobox">
                  <div class='text-center'>Скоро тут будут ваши миллиарды ;)</div>
                </div>
                @else
                @foreach($vivod as $o)
                <div class="part">
                <div class="p-n">#{{$o->id}}</div>
                <div class="p-id">{{$o->price}}</div>
                <div class="p-name">{{$o->koshel}}</div>
                <div class="p-games">
                    @if($o->status == 0)
                      Вывод (Ожидает)
                    @else
                      Вывод (Переведен)
                    @endif
                </div>
                <div class="cls"></div>
                </div>
                @endforeach
                @foreach($mo as $co)
                <div class="part">
                <div class="p-n">#{{$co->id}}</div>
                <div class="p-id">{{$co->amount}}</div>
                <div class="p-name">Free-kassa</div>
                <div class="p-games">Пополнение</div>
                <div class="cls"></div>
                </div>
                @endforeach
                @foreach($mo2 as $co2)
                <div class="part">
                <div class="p-n">#{{$co2->id}}</div>
                <div class="p-id">{{$co2->price}}</div>
                <div class="p-name">Interkassa</div>
                <div class="p-games">Пополнение</div>
                <div class="cls"></div>
                </div>
                @endforeach
                @endif

              </div>
              <div class="tab-container tab-container-4"><div class="loader" id="delivery-loader"><img src="templates/frontend/default/images/loader.svg" alt=""></div>
              <table class="table history-money" id="shipping-table-head">
                  <thead>
                  <tr>
                  <th width="50">№</th>
                  <th width="200">Подарок</th>
                  <th width="150" class="text-center">Дата</th>
                  <th width="80" class="text-center">Статус</th>
                  </tr>
                  </thead>
                  @foreach($gifts as $gift)
                      <tr>
                  <td width="50">{{$gift->id}}</td>
                  <td width="200">{{$gift->name}}</td>
                  <td width="150" class="text-center">{{$gift->updated_at}}</td>
                  <td width="80" class="text-center">
                      @if($gift->status == 0)
                        Ожидание
                      @endif

                      @if($gift->status == 1)
                        Продан
                      @endif
                      @if($gift->status == 2)
                        Обработка
                      @endif
                      @if($gift->status == 3)
                        Получон
                      @endif
                  </td>
                </tr>
                  @endforeach
                  </table>
                  <div id="history-shipping">
                  </div>
          </div>
            </div>
        </div>
        <div class="seperator"></div>
        </div>
    </main>
    <script>
            $(document).ready(function () {
              $('#send').click(function() {
                  var id = $('#send').attr("data-id");
                  var user2 = '{{$u->id}}';
                $.ajax({
                  url: '/api/send',
                  type: 'post',
                  data: {item: id, user: user2},
                  dataType: 'json',
                  success: function(rdata){
                    if(rdata.success == true){
                      setTimeout(location.reload(), 2000);
                    }else{
                      smoke.alert(rdata.error);
                    }
                  }
                });
              });
              $('#sell').click(function() {
                  var id = $('#sell').attr("data-id");
                  var user2 = '{{$u->id}}';
                $.ajax({
                  url: '/api/sell',
                  type: 'post',
                  data: {item: id, user: user2},
                  dataType: 'json',
                  success: function(rdata){
                    if(rdata.success == true){
                      setTimeout(location.reload(), 2000);
                    }else{
                      smoke.alert(rdata.error);
                    }
                  }
                });
              });
    });

    </script>
@endsection
