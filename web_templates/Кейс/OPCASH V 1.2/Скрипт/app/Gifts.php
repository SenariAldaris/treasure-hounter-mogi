<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Gifts extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'last_gifts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['case_id', 'user', 'username', 'login', 'status', 'name', 'price'];

}
