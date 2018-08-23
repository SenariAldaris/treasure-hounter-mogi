<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model{

	 protected $table = 'winner';

	 protected $fillable = ['user_id','amount'];

    public $timestamps = false;

}
