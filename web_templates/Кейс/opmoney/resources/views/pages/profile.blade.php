@extends('users')

@section('content')
    <main class="content">
        <div class="inner"><div class="account"><div class="userbox">
                    <div class="l">
                        <img src="{{$user->avatar}}" alt="{{$user->username}}">
                        <h1>{{$user->username}} <a href="https://vk.com/{{$user->login}}" target="_blank"><span class="flaticon-soc-vk"></span></a></h1>
                        <div class="u-cases"><span class="flaticon-case"></span> Кейсы: <span class="n">{{$user->open_box}}</span></div>
                        <div class="u-money"><span class="flaticon-money"></span> Выигрыш: <span class="n">{{$user->win}}р</span></div>
                    </div>
                    <div class="r">
                        <a href="/" class="btn darkblue"><span class="flaticon-arrow-left"></span> назад к кейсам</a>
                    </div>
                    <div class="cls"></div>
                </div><div class="seperator"></div><h3>Последние 30 призов</h3><div class="cls"></div><div class="history-cases"><div class="cls"></div>
                    @foreach($items as $i)
                    <div class="history-case">
                        <a href="/cases/{{$i->cases_id}}" class="eas case-url">Кейс №{{$i->cases_id}}</a>
                        <div class="status"><span class="flaticon-check"></span></div>
                        <div class="coin silver">
                            <img src="{{$i->img}}" alt="{{$i->price}} рублей">
                        </div>
                    </div>
                    @endforeach
                    <div class="cls"></div></div></div><div class="seperator"></div></div>
    </main>
@endsection
