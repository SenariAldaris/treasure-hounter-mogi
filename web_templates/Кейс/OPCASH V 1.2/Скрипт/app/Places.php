<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticket_places';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ticket', 'place', 'user' , 'user_avatar', 'username'];

}
