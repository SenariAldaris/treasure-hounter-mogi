@extends('layout')
@section('content')
<div class="filters">
   <div class="inner">
      <div class="right">
         <span class="case-price-x case-price-0 eas" onclick="setFilters('price',0,0,this);">Все кейсы</span>
         <span class="case-price-x case-price-1 eas " onclick="setFilters('price',10,100,this);">10-90</span>
         <span class="case-price-x case-price-2 eas" onclick="setFilters('price',100,1000,this);">100-900</span>
         <span class="case-price-x case-price-3 eas" onclick="setFilters('price',1000,10000,this);">1,000-9,000</span>
         <span class="case-price-x case-price-4 eas" onclick="setFilters('price',10000,999999,this);">10,000+</span>
      </div>
      <div class="cls"></div>
   </div>
</div>
<main class="content">
   <div class="inner">
      <h3>Билетные кейсы</h3>
      <ul class="ticket-boxes">
         @foreach($tickets as $ticket)
         <li class="ticket-box">
            <span class="ticket-box-inner">
            <span class="new">NEW!</span>
            <span class="left">
            <a href="/ticket/{{$ticket->id}}" class="tit">{{$ticket->name}}</a><br>
            <span class="price">Стоимость: {{$ticket->price}}р</span>
            <a href="/ticket/{{$ticket->id}}" class="btn rounded">Подробнее</a>
            </span>
            <span class="right">
            <span class="jackpot"><span class="small">Джекпот</span>{{$ticket->jackpot}}</span>
            </span>
            <span class="cls"></span>
            </span>
         </li>
         @endforeach
      </ul>
      <div class="cases">
         <div class="cls">
         </div>
         <div class="cases">
            <div class="cls"></div>
            <h3 class="MarginTop-30">Денежные призы</h3>
            <div class="cls"></div>
            <div class="cases-digital">
               @foreach($cases as $c)
               @if($c->price_max < 100)
               @if($c->type == 'money')
               <div class="case-grid"  data-case-pricef="10" data-case-pricet="100" data-case-type="1">
                  <div class="case">
                     <a href="/cases/{{$c->id}}" class="mobile-url">Подробнее</a>
                     <div class="hover eas">
                        <div class="light"><a href="/cases/{{$c->id}}"
                           class="btn orange rounded eas">Подробнее</a>
                        </div>
                     </div>
                     <div class="price">
                        <b>стоимость</b>{{$c->price}} <span class="flaticon-ruble"></span>
                     </div>
                     <div class="img">
                        <div class="prize"><img src="{{$c->img}}" alt="Призовая обложка"></div>
                        <div class="cover"><img src="/uploads/cases/case-cover.png" alt="Призовая обложка"></div>
                     </div>
                     <div class="payed">
                        <div class="center">выдано {{$c->won}}<span class="flaticon-ruble ruble-small"></span>
                        </div>
                     </div>
                     <div class="case-footer"><a href="/cases/{{$c->id}}">Содержит от <b>{{$c->price_min}}<span
                        class="flaticon-ruble ruble-small"></span></b> до <b>{{$c->price_max}}
                        <span class="flaticon-ruble ruble-small"></span></b></a>
                     </div>
                  </div>
               </div>
               @endif
               @endif
               @if($c->price_max < 1000)
               @if($c->price_max >= 100)
               @if($c->type == 'money')
               <div class="case-grid"  data-case-pricef="100" data-case-pricet="1000" data-case-type="1">
                  <div class="case">
                     <a href="/cases/{{$c->id}}" class="mobile-url">Подробнее</a>
                     <div class="hover eas">
                        <div class="light"><a href="/cases/{{$c->id}}"
                           class="btn orange rounded eas">Подробнее</a>
                        </div>
                     </div>
                     <div class="price">
                        <b>стоимость</b>{{$c->price}} <span class="flaticon-ruble"></span>
                     </div>
                     <div class="img">
                        <div class="prize"><img src="{{$c->img}}" alt="Призовая обложка"></div>
                        <div class="cover"><img src="/uploads/cases/case-cover.png" alt="Призовая обложка"></div>
                     </div>
                     <div class="payed">
                        <div class="center">выдано {{$c->won}}<span class="flaticon-ruble ruble-small"></span>
                        </div>
                     </div>
                     <div class="case-footer"><a href="/cases/{{$c->id}}">Содержит от <b>{{$c->price_min}}<span
                        class="flaticon-ruble ruble-small"></span></b> до <b>{{$c->price_max}}
                        <span class="flaticon-ruble ruble-small"></span></b></a>
                     </div>
                  </div>
               </div>
               @endif
               @endif
               @endif
               @if($c->price_max < 10000)
               @if($c->price_max >= 1000)
               @if($c->type == 'money')
               <div class="case-grid"  data-case-pricef="1000" data-case-pricet="10000" data-case-type="1">
                  <div class="case">
                     <a href="/cases/{{$c->id}}" class="mobile-url">Подробнее</a>
                     <div class="hover eas">
                        <div class="light"><a href="/cases/{{$c->id}}"
                           class="btn orange rounded eas">Подробнее</a>
                        </div>
                     </div>
                     <div class="price">
                        <b>стоимость</b>{{$c->price}} <span class="flaticon-ruble"></span>
                     </div>
                     <div class="img">
                        <div class="prize"><img src="{{$c->img}}" alt="Призовая обложка"></div>
                        <div class="cover"><img src="/uploads/cases/case-cover.png" alt="Призовая обложка"></div>
                     </div>
                     <div class="payed">
                        <div class="center">выдано {{$c->won}}<span class="flaticon-ruble ruble-small"></span>
                        </div>
                     </div>
                     <div class="case-footer"><a href="/cases/{{$c->id}}">Содержит от <b>{{$c->price_min}}<span
                        class="flaticon-ruble ruble-small"></span></b> до <b>{{$c->price_max}}
                        <span class="flaticon-ruble ruble-small"></span></b></a>
                     </div>
                  </div>
               </div>
               @endif
               @endif
               @endif
               @if($c->price_max >= 10000)
               @if($c->type == 'money')
               <div class="case-grid"  data-case-pricef="10000" data-case-pricet="999999" data-case-type="1">
                  <div class="case">
                     <a href="/cases/{{$c->id}}" class="mobile-url">Подробнее</a>
                     <div class="hover eas">
                        <div class="light"><a href="/cases/{{$c->id}}"
                           class="btn orange rounded eas">Подробнее</a>
                        </div>
                     </div>
                     <div class="price">
                        <b>стоимость</b>{{$c->price}} <span class="flaticon-ruble"></span>
                     </div>
                     <div class="img">
                        <div class="prize"><img src="{{$c->img}}" alt="Призовая обложка"></div>
                        <div class="cover"><img src="/uploads/cases/case-cover.png" alt="Призовая обложка"></div>
                     </div>
                     <div class="payed">
                        <div class="center">выдано {{$c->won}}<span class="flaticon-ruble ruble-small"></span>
                        </div>
                     </div>
                     <div class="case-footer"><a href="/cases/{{$c->id}}">Содержит от <b>{{$c->price_min}}<span
                        class="flaticon-ruble ruble-small"></span></b> до <b>{{$c->price_max}}
                        <span class="flaticon-ruble ruble-small"></span></b></a>
                     </div>
                  </div>
               </div>
               @endif
               @endif
               @endforeach
            </div>
<div class="cls"></div>
@foreach($cases as $c)
            @if($c->type == 'gift')
            <div class="case-grid"  data-case-pricef="100" data-case-pricet="1000" data-case-type="1">
               <div class="case" style="background: #f5b51b;">
                  <a href="/cases/{{$c->id}}" class="mobile-url">Подробнее</a>
                  <div class="hover eas">
                     <div class="light"><a href="/cases/{{$c->id}}"
                        class="btn orange rounded eas">Подробнее</a>
                     </div>
                  </div>
                  <div class="price">
                     <b>стоимость</b>{{$c->price}} <span class="flaticon-ruble"></span>
                  </div>
                  <div class="img">
                     <div class="prize"><img src="{{$c->img}}" alt="Призовая обложка"></div>
                     <div class="cover"><img src="/uploads/cases/case-cover.png" alt="Призовая обложка"></div>
                  </div>
                  <div class="payed">
                    <div class="left">{{$c->name}}</div>
                    <div class="right">выдано {{$c->won}}<span class="flaticon-ruble ruble-small"></span></div>
                  </div>
                  <div class="case-footer" style="background: #de7504;"><a href="/cases/{{$c->id}}">Содержит от <b>{{$c->price_min}}<span
                     class="flaticon-ruble ruble-small"></span></b> до <b>{{$c->price_max}}
                     <span class="flaticon-ruble ruble-small"></span></b></a>
                  </div>
               </div>
            </div>
            @endif
            @endforeach
            <div class="cls"></div>
         </div>
         <div class="cls"></div>
      </div>
   </div>
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
<script>
   var case_filers = [0,0,0];
   function setFilters(name, f, t, btn) {

   	if (name == 'type') {
   		$(".case-type-x").removeClass("active");
   		$(btn).addClass("active");
   		case_filers[0] = f;
   	}
   	else if (name == 'price') {
   		$(".case-price-x").removeClass("active");
   		$(btn).addClass("active");
   		case_filers[1] = f;
   		case_filers[2] = t;
   	}

   	$(".case-grid").fadeOut(0);
   	$(".case-grid").addClass('hidden');

   	if (case_filers[0] == 0 && case_filers[1] == 0) {
   		$(".case-grid").fadeIn(0);
   		$(".case-grid").removeClass('hidden');
   	}
   	else if (case_filers[0] == 0 && case_filers[1] != 0) {
   		$("[data-case-pricef='"+case_filers[1]+"'][data-case-pricet='"+case_filers[2]+"']").fadeIn(0);
   		$("[data-case-pricef='"+case_filers[1]+"'][data-case-pricet='"+case_filers[2]+"']").removeClass('hidden');
   	}
   	else if (case_filers[0] != 0 && case_filers[1] == 0) {
   		$("[data-case-type='"+case_filers[0]+"']").fadeIn(0);
   		$("[data-case-type='"+case_filers[0]+"']").removeClass('hidden');
   	}
   	else {
   		$("[data-case-type='"+case_filers[0]+"'][data-case-pricef='"+case_filers[1]+"'][data-case-pricet='"+case_filers[2]+"']").fadeIn(0);
   		$("[data-case-type='"+case_filers[0]+"'][data-case-pricef='"+case_filers[1]+"'][data-case-pricet='"+case_filers[2]+"']").removeClass('hidden');
   	}

   	if ($(".case-grid:not(.hidden)").length < 1) {
   		$(".case-empty").fadeIn(0);
   	}
   	else {
   		$(".case-empty").fadeOut(0);
   	}


   }


</script>
@endsection
