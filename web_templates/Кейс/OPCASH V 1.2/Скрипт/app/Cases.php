<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model{

	 protected $table = 'case';

	 protected $fillable = ['price_min','price_max', 'x10', 'x20', 'x30', 'img', 'price'];

    public $timestamps = false;

}
