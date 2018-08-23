@extends('case')

@section('content')
    <main class="content">
        <div class="inner">
            <audio class="audio" id="audio-spin" controls="" preload="auto">
                <source src="/templates/frontend/default/audio/bg.mp3" type="audio/mpeg">
            </audio>
            <audio class="audio" id="audio-win-0" controls="" preload="auto">
                <source src="/templates/frontend/default/audio/win-0.wav?v=2" type="audio/wav">
            </audio>
            <audio class="audio" id="audio-win-1" controls="" preload="auto">
                <source src="/templates/frontend/default/audio/win-1.wav?v=2" type="audio/wav">
            </audio>
            <div class="case-page"><a href="/" class="btn darkblue backtocases"><span
                            class="flaticon-arrow-left"></span> Другие кейсы</a>
                <div class="spin-won">
                    <h3>Поздравляем!</h3>
                    <h5>Вы выиграли <span id="spin-win-name">1000р</span></h5>
                    <h4><a href="/account/">Перейдите в аккаунт</a>, чтобы получить приз</h4>
                    <div class="icon"><img src="" alt="1000" id="spin-win-icon"></div>
                    <div class="button">
                        <input type="button" class="btn rounded blue" value="Выиграть еще"
                               onclick="cleanWinAnimation();">
                    </div>
                    <div class="c"><a href="/" class="eas">Другие кейсы</a></div>
                    <div class="a-1"></div>
                    <div class="a-2"></div>
                    <div class="a-3"></div>
                    <div class="a-4"></div>
                </div>
                <div class="spin">
                    <div class="name">
                      @if($case->price == 0)
                        <h1>Бесплатный кейс</h1>
                        <div class="desc">
                          Пополни баланс от 20 руб</br>
                          и получи <b>1</b> бесплатный кейс
                        </div>
                      @else
                      @if($case->type == 'gift')
                          <h1>{{$case->name}}</h1>
                      @else
                          <h1>Кейс {{$case->id}}-го уровня</h1>
                      @endif
                      @endif
                        <div class="desc">Содержит от <b>{{$case->price_min}}р</b> до <b>{{$case->price_max}}р</b></div>
                        <div class="payed">выдано {{$won}}р</div>
                    </div>
                    <div class="spin-line"></div>
                    <div class="spin-inner">
                        <div class="roulette">
                        @foreach($items as $i)
                            <img src="{{$i->img}}" alt="{{$i->price}} рублей" id="gift-id-{{$i->id}}">
                        @endforeach
                        </div>
                    </div>
                    <div class="chance">
                        @if($case->price == 0)
                          @if(Auth::guest())

                          @else
                          <h3>Часов до открытия: {{$av}}</h3>
                          <div class="c">
                            <h3>Осталось кейсов: {{$left}}</h3>
                          </div>
                          @endif
                        @else
                        <h3>Увеличитель шанса</h3>
                        <div class="c">
                            <p><input type="checkbox" name="chance" value="{{$case->x10}}" class="lcs_check" data-lcs="1" /> +10% к шансу за <b>{{$case->x10}}р</b></p>
                            <p><input type="checkbox" name="chance" value="{{$case->x20}}" class="lcs_check" data-lcs="2" /> +20% к шансу за <b>{{$case->x20}}р</b></p>
                            <p><input type="checkbox" name="chance" value="{{$case->x30}}" class="lcs_check" data-lcs="3" /> +30% к шансу за <b>{{$case->x30}}р</b></p>
                        </div>
                        @endif
                    </div>
                    <div class="button">
                        <script>
                            window.spin_chance = 0;
                            window.spin_amount = {{$case->price}};
                        </script>
                        @if(Auth::guest())
                        <button class="btn blue rounded" onclick="/login">Login</button>
                        @else
                        @if($u->money < $case->price)
                        <button class="btn blue rounded" style="bottom: 0px;" disabled="disabled" onclick="popupOpen('#deposit');">Недостаточно средств</button>
                        <center style="position: absolute;bottom: -20px;text-align: center;width: 100%;">
                          <a href="#" onclick="popupOpen('#deposit');return false;">Пополнить баланс</a></center>
                        @else
                        <button class="btn blue rounded" onclick="spinbox({{$case->id}}, this, window.spin_count);">Открыть кейс за
                            <span>
                              <b id="spin-amount">{{$case->price}} </b>
                              <span class="flaticon-ruble"></span></span></button>

                        @endif
                        @endif

                    </div>
                    <div class="cls"></div>
                </div>
                <div class="cls"></div>
                <h3 class="title case-page-title">Предметы, которые могут вам выпасть из этого кейса</h3>
                <div class="cls"></div>
                <div class="history-cases MarginTop-40">
                    @foreach($itemsDemo as $im)
                    <div class="history-case">
                        <div class="coin gold">
                            <img src="{{$im->img}}" alt="{{$im->price}} рубль">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="cls"></div>
            </div>
        </div>
    </main>
@endsection
