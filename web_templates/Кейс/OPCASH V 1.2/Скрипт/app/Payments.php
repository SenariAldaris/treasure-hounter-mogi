<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model{

	 protected $table = 'last_vvod';

	 protected $fillable = ['price','user'];

    public $timestamps = false;

}
