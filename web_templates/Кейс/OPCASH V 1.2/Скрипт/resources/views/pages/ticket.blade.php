@extends('case')
@section('content')
<main class="content">
   <div class="inner">
      <div class="inner">
         <h1 class="tickets-h1">{{$ticket->name}}</h1>
         <div class="tickets-info">
            <div class="t1"><span>Стоимость:</span><br><b>{{$ticket->price}}p.</b></div>
            <div class="t2"><span>Джекпот:</span><br><b>{{$ticket->jackpot}}p.</b></div>
            <div class="t3" style="float: right;width: 50%;">Выберите свободное место, которые хотите занять. Вы можете занять неограниченное количество мест. После выдачи всех билетов один из участников выиграет джекпот. Удачи!</div>
            <div class="cls"></div>
         </div>
         <script>
            var ticket_price = {{$ticket->price}};
         </script>
         <div class="tickets-loader">
            <div class="text">{{$playing}}/{{$ticket->places}}</div>
            <div class="complete" style="width:{{($playing / $ticket->places) * 100}}%"></div>
         </div>
         <div class="cls"></div>
         <div class="tickets-places">
           @foreach($places as $place)
           @if($place->user == null)
           <div class="one-place eas-fast" id="game-place-{{$place->place}}" onclick="setplace({{$place->ticket}},1, {{$place->place}}, {{$u->id}});">
              <span>{{$place->place}}<span>
              </span></span>
           </div>
           @else
           <div class="one-place" id="game-place-{{$place->place}}">
               <a href="/profile/{{$place->user}}" target="_blank"><img src="{{$place->user_avatar}}"></a>
            </div>
           @endif

           @endforeach
            <div class="cls"></div>
            <h3>Последний победитель</h3>
            <div class="daily-winner">
               <div class="daily-winner-in">
                  <div class="b1">
                     <a href="/profile/{{$winner->id}}"><img src="{{$winner->avatar}}" alt="{{$winner->username}}"></a>
                  </div>
                  <div class="b2">
                     <a href="/profile/{{$winner->id}}">{{$winner->username}}</a><br>
                     <div class="tickets-round"><span>Победный билет: {{$v2->winning_ticket}}</span></div>
                  </div>
                  <div class="cls"></div>
               </div>
               <div class="daily-winner-animation"></div>
            </div>
         </div>
         <h3 class="tickets-h3">Недавние участники</h3>
         <table class="table table-daily">
            <tbody>
         @foreach($taken as $place)
         @if($place->user == null)

         @else
         <tr>
            <td width="50" class="id">занял место <span class="ticket">#{{$place->place}}</span></td>
            <td width="60"><a href="/profile/{{$place->user}}"><img src="{{$place->user_avatar}}" alt="{{$place->username}}" class="userpic"></a></td>
            <td><a href="/profile/{{$place->user}}">{{$place->username}}</a></td>
            <td width="160" class="text-right date">{{$place->updated_at}}</td>
         </tr>
         @endif

         @endforeach
       </tbody>
    </table>
      </div>
   </div>
   <script>
   function setplace(id,round,place,user){
     $.ajax({
       url: '/api/setplace',
       type: 'post',
       data: {id: id, round: round,place: place,user: user},
       dataType: 'json',
       success: function(rdata){
         if (rdata.status == 'success') {
           setTimeout(location.reload(), 2000);
         }else{
           smoke.alert(rdata.message);
         }
       }
     });
   }
   </script>
</main>
@endsection
