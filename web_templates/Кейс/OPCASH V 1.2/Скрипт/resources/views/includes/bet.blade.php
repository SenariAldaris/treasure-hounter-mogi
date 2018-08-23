<div id="bet_{{ $bet->id }}" class="history-block-item">
  <div class="user"><img src="{{ $bet->user->avatar }}">
      <a class="username" data-profile="{{ $bet->user->steamid64 }}" href="#">{{ $bet->user->username }}</a> внес {{ $bet->itemsCount }} {{ trans_choice('lang.items', $bet->itemsCount) }}
      <span class="price">({{ $bet->price }} руб)</span>
      <span class="chance_{{ $bet->user->steamid64 }}" style="color: #ccc">({{ \App\Http\Controllers\GameController::_getUserChanceOfGame($bet->user, $bet->game) }} %)</span>
      <span class="deposit-tickets pull-right">
          Билет: от <span class="from price">#{{ $bet->from }}</span> до <span class="to price">#{{ $bet->to }}</span>
      </span>
  </div>
  <div class="items">
     @foreach(json_decode($bet->items) as $i)
     <div class="items-block-item @if(!isset($i->img)){{ $i->rarity }} @else card @endif">
        <div title="{{ $i->name }}" data-toggle="tooltip" class="item-cont" >
           <span class="price">{{ $i->price }} руб</span>
            @if(!isset($i->img))
                <div class="item-wrap-img"><img src="https://steamcommunity-a.akamaihd.net/economy/image/class/{{ \App\Http\Controllers\GameController::APPID }}/{{ $i->classid }}/200fx200f"></div>
            @else
                <div class="item-wrap-img"><img src="{{ asset($i->img) }}"></div>
            @endif
        </div>
     </div>
     @endforeach
  </div>
</div>