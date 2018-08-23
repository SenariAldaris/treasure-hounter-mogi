@extends('layout')

@section('content')
    <main class="content">
        <div class="inner"><h1 class="title">Техническая поддержка</h1><div class="static"><div class="infobox">
                    <h3>Обратите внимание</h3>&bull; Перед формированием запроса в техническую поддержку, настоятельно рекомендуем ознакомиться с <a href='/pages/faq.html'>часто задаваемыми вопросами и ответами</a>.<br>&bull; А также, вывод средств осуществляется от 1 до 24 часов. Пожалуйста, будьте терпеливы.<br><br></div><div class="cls"></div><div class="support"><form name="form-support">
                        <div class="loader"><img src="templates/frontend/default/images/loader.svg" alt="Загрузка..."></div>
                        <div class="line"><input type="text" class="inp" name="name" placeholder="Как вас зовут?" value="{{$u->username}}" readonly="readonly"></div>
                        <div class="line"><input type="text" class="inp" name="email" placeholder="Email"></div>
                        <div class="line"><input type="text" class="inp" name="subject" placeholder="Что случилось?"></div>
                        <div class="line"><textarea class="textarea" name="message" placeholder="Опишите проблему"></textarea></div>
                        <div class="line button"><input type="button" class="btn rounded yellow" value="Отправить" onclick="CreateTicket();"></div>
                    </form></div><div class="seperator"></div></div></div>
    </main>
@endsection