<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{

    protected $table = 'hour';

    protected $fillable = ['user_id','login','username','avatar'];

}
