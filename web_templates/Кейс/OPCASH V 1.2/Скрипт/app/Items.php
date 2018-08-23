<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{

    protected $table = 'items';

    protected $fillable = ['img', 'price', 'cases_id'];
    public $timestamps = false;
}
