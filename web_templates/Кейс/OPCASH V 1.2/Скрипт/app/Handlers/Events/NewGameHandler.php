<?php

namespace App\Handlers\Events;

use App\Events;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LRedis;

class NewGameHandler
{

    const EVENT = 'new.game';
    const CHANNEL = 'new.game';

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($data)
    {
        $redis = LRedis::connection();
        $redis->publish(self::CHANNEL, $data);
    }
}
