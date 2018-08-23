<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class TicketWinner extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticket_winner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user', 'ticket', 'winning_ticket'];
    public $timestamps = false;
}
