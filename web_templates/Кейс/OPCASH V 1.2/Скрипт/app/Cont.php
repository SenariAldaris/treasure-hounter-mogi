<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cont extends Model {

	 protected $table = 'contestants';

	 protected $fillable = ['user_id','user_name','login','boxes_opened'];

    public $timestamps = false;

}
