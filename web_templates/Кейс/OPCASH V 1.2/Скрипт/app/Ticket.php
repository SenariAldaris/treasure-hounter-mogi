<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticket';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['price', 'places', 'jackpot'];

}
