@extends('layout')

@section('content')
    <div class="filters">
        <div class="inner">
            <div class="cls"></div>
        </div>
    </div>
    <main class="content">
      <div class="inner"><div class="cases">
      <div class="cls">
      </div>
      <div class="cases">
        <h1>Bonus призы</h1>
      <div class="cls"></div>
      <div class="cases-default">
        @foreach($cases2 as $c)
            <div class="case-grid" style="float: right;position: relative;left: -37%;text-align: left;">
                <div class="case">
                    <a href="/cases/{{$c->id}}" class="mobile-url">Подробнее</a>
                    <div class="hover eas">
                        <div class="light"><a href="/cases/{{$c->id}}"
                                              class="btn orange rounded eas">Подробнее</a>
                        </div>
                    </div>
                    <div class="price">
                        <b>стоимость</b>{{$c->price}} <span class="flaticon-ruble"></span></div>
                    <div class="img">
                        <div class="prize"><img src="{{$c->img}}" alt="Призовая обложка"></div>
                    </div>
                    <div class="payed">
                        <div class="center">выдано {{$c->won}}<span class="flaticon-ruble ruble-small"></span>
                        </div>
                    </div>
                    <div class="case-footer"><a href="/cases/1.html">Содержит от <b>{{$c->price_min}}<span
                                        class="flaticon-ruble ruble-small"></span></b> до <b>{{$c->price_max}}
                                <span class="flaticon-ruble ruble-small"></span></b></a></div>
                </div>
            </div>
        @endforeach
      </div>
<div class="cls"></div>
      <h3 class="MarginTop-30">Денежные призы</h3>
      <div class="cls"></div>
      <div class="cases-digital">
        @foreach($cases as $c)
        @if($c->price > 0)
        <div class="case-grid">
            <div class="case">
                <a href="/cases/{{$c->id}}" class="mobile-url">Подробнее</a>
                <div class="hover eas">
                    <div class="light"><a href="/cases/{{$c->id}}"
                                          class="btn orange rounded eas">Подробнее</a>
                    </div>
                </div>
                <div class="price">
                    <b>стоимость</b>{{$c->price}} <span class="flaticon-ruble"></span></div>
                <div class="img">
                    <div class="prize"><img src="{{$c->img}}" alt="Призовая обложка"></div>
                </div>
                <div class="payed">
                    <div class="center">выдано {{$c->won}}<span class="flaticon-ruble ruble-small"></span>
                    </div>
                </div>
                <div class="case-footer"><a href="/cases/1.html">Содержит от <b>{{$c->price_min}}<span
                                    class="flaticon-ruble ruble-small"></span></b> до <b>{{$c->price_max}}
                            <span class="flaticon-ruble ruble-small"></span></b></a></div>
            </div>
        </div>

        @endif

        @endforeach
      </div>
      <div class="cls"></div></div><div class="cls"></div>
      </div></div>
        </div>
    </main>
    <div class="top-users">
        <div class="inner">
            <h3>Самые везучие</h3>
            <div class="cls"></div>
            <div class="top-10">
                @foreach(App\User::top() as $i)
                    @if($i->place >= 1)
                    <span class="user">
<a href="/profile/{{$i->id}}" class="eas"><img src="{{$i->avatar}}"
                                             alt="{{$i->username}}"></a>
<span class="s-cases"><span class="flaticon-case"></span> {{$i->open_box}}</span>
<span class="s-money"><span class="flaticon-money"></span> {{$i->win}}<span class="flaticon-ruble small-icon"></span></span>
</span>
                    @endif
                    @endforeach
            </div>
            <div class="cls"></div>
        </div>
    </div>
@endsection
