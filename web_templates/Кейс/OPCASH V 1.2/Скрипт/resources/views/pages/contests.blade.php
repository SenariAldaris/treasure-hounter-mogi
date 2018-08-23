@extends('case')
@section('content')
<div class="inner">
   <div class="contest">
      <h1>Розыгрыш MacBook Pro - Мега розыгрыш !</h1>
      <div class="cls"></div>
      <div class="contest-header">
         <div class="in">
            <div class="left">
               <img src="http://WebCash.top//uploads/macbookpro.png" alt="Розыгрыш MacBook Pro - Мега розыгрыш !">
            </div>
            <div class="right">
               <h3>Для участия в конкурсе необходимо:</h3>
               <div class="rule"><span class="num">1</span> Пополнить баланс на 300р
                 @if($mo >= 300 || $mo2 >= 300)
                    <span class="num">✔</span>
                @else
                    <span class="num">✖</span>
                 @endif
               </div>
               <div class="rule"><span class="num">2</span> Открыть 10 или более кейсов
                 @if($ce >= 15)
                  <span class="num">✔</span>
                 @else
                  <span class="num">✖</span>
                 @endif
               </div>
               <div class="rule"><span class="num">3</span> Вступить в нашу <a href="https://vk.com/vk.webcash" target="_blank" rel="nofollow">Группу вконтакте</a>
                 @if($mo >= 300 || $mo2 >= 300)
                  @if($ce >= 15)
                    <span class="num">✔</span>
                  @endif
                  @else
                 @endif
               </div>
               <div class="cls"></div>
               <div class="contest-countdown-title">Розыгрыш через</div>
               <div class="contest-countdown" id="contest-countdown">14 <span>дн.</span> 06:18:20</div>
            </div>
            <div class="cls"></div>
         </div>
         <div class="animation"></div>
      </div>
      <div class="more-placec">
         <div class="place" style="width: 33.333333333333%">
            <div class="in">
               <div class="title">Умные часы Apple Watch</div>
               <div class="img"><img src="http://unioncash.ru/uploads/contest/applewatch.png" alt="Умные часы Apple Watch"></div>
               <div class="p">2 место</div>
            </div>
         </div>
         <div class="place" style="width: 33.333333333333%">
            <div class="in">
               <div class="title">Наушники Air Pods</div>
               <div class="img"><img src="http://unioncash.ru/uploads/contest/air-pods.png" alt="Наушники Air Pods"></div>
               <div class="p">3 место</div>
            </div>
         </div>
         <div class="place" style="width: 33.333333333333%">
            <div class="in">
               <div class="title">Карта iTunes 5000р</div>
               <div class="img"><img src="http://unioncash.ru/uploads/contest/itunes-5000.png" alt="Карта iTunes 5000р"></div>
               <div class="p">4 место</div>
            </div>
         </div>
         <div class="cls"></div>
      </div>
      <div class="contest-desc">
         <b>WebCash </b> разыгрывает  <strong>
           <span style="color: #ffffff;">MacBook Pro </span>
           , <span style="color: #ffffff;">Apple Watch </span>
         </strong>
         <span style="color: #ffffff;">(Sport Edition</span>
         <span style="color: #ffffff;">)</span>
         <strong>,
           <span style="color: #ffffff;">Air Pods</span> и <span style="color: #ffffff;">iTunes Gift Card 5000р</span>
         </strong> &nbsp;для самых активных участников проекта. Чтобы принять участие в розыгрыше, нужно выполнить несколько простых условий, которые перечислены выше, на странице акции. Условия необходимо выполнить во время проведения розыгрыша. В расчете учитываются открытия кейсов и пополнение баланса только на время проведения акции. Победитель будет определен случайным образом, через систему random.org, в последний день розыгрыша.<br><br>
         PS: Пожалуйста, не забывайте про пункт с подпиской в группу вконтакте. В прошлом розыгрыше более 30 участников, которые могли бы стать счастливыми обладателями приза не стали им, из-за не выполнения третьего и самого простого пункта. Желаем всем удачи!
      </div>
      <div class="part-important text-center infobox">
        <b>Обратите внимание!</b> Данные в таблице участников обновляются раз в час.
      </div>
      <div class="contest-users">
        <h3>В конкурсе участвуют</h3>
        <div class="cls"></div>
        <div class="participate">
          <div class="part part-header">
            <div class="p-n">№</div>
            <div class="p-id">ID</div>
            <div class="p-name">ФИО</div>
            <div class="p-vk"></div>
            <div class="p-games">Открыл кейсов</div>
            <div class="p-deposit">Пополнил</div>
            <div class="cls"></div>
          </div>
          @foreach($contestants as $co)
          <div class="part">
          <div class="p-n">{{$co->id}}</div>
          <div class="p-id">{{$co->user_id}}</div>
          <div class="p-name">
            <a href="/profile/{{$co->user_id}}">{{$co->user_name}}</a>
          </div>
          <div class="p-vk">
            <a href="https://vk.com/{{$co->login}}" rel="nofollow" target="_blank">
              <span class="flaticon-soc-vk"></span>
            </a>
          </div>
          <div class="p-games">{{$co->boxes_opened}}</div>
          <div class="p-deposit">
            <span class="flaticon-check"></span>
          </div>
          <div class="cls"></div>
          </div>
          @endforeach
        </div>
      </div>
   </div>
   <script type="text/javascript" src="http://unioncash.ru/templates/frontend/default/js/jquery.countdown.min.js"></script>
   <script type="text/javascript">
      $("#contest-countdown").countdown("2017/2/20", function(event) {
      $(this).html(
      event.strftime('%D <span>дн.</span> %H:%M:%S')
      );
      });
   </script>
</div>
@endsection
