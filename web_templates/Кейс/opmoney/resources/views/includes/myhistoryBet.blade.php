<div class="history-block-item">
    <div class="user">
        <span class="text-info">Игра #{{ $bet->game_id }}</span>&nbsp;|&nbsp;
        @if($bet->winner_id == $u->id)
            Вы выиграли {{ count(json_decode($bet->won_items)) }} {{ trans_choice('lang.items', count(json_decode($bet->won_items))) }}
        @else
            Вы внесли {{ $bet->itemsCount }} {{ trans_choice('lang.items', $bet->itemsCount) }}
        @endif
        <span class="price">({{ $bet->price }} руб)</span>
        @if($bet->status == \App\Game::STATUS_FINISHED)
            @if($bet->winner_id == $u->id)
                <span class="pull-right winner">Выигрыш</span>
            @else
                <span class="pull-right looser">Проигрыш</span>
            @endif
            @else
            <span class="pull-right text-warning">Идёт игра...</span>
        @endif
    </div>
    <div class="items">

        @if($bet->winner_id == $u->id)
            @foreach(json_decode($bet->won_items) as $i)
                <div class="items-block-item @if(!isset($i->img)){{ $i->rarity }} @else card @endif">
                    <div title="{{ $i->name }}" data-toggle="tooltip" class="item-cont" >
                        <span class="price">{{ $i->price }} руб</span>
                        @if(!isset($i->img))
                            <div class="item-wrap-img"><img src="https://steamcommunity-a.akamaihd.net/economy/image/class/{{ \App\Http\Controllers\GameController::APPID }}/{{ $i->classid }}/200fx200f"></div>
                        @else
                            <div class="item-wrap-img"><img src="{{ $i->img }}"></div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            @foreach($bet->items as $i)
                <div class="items-block-item @if(!isset($i->img)){{ $i->rarity }} @else card @endif">
                    <div title="{{ $i->name }}" data-toggle="tooltip" class="item-cont" >
                        <span class="price">{{ $i->price }} руб</span>
                        @if(!isset($i->img))
                            <div class="item-wrap-img"><img src="https://steamcommunity-a.akamaihd.net/economy/image/class/{{ \App\Http\Controllers\GameController::APPID }}/{{ $i->classid }}/200fx200f"></div>
                        @else
                            <div class="item-wrap-img"><img src="{{ $i->img }}"></div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>