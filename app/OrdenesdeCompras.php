<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenesdeCompras extends Model
{
    protected $connection = 'mysql';
	protected $table = 'compra';
	public $timestamps = false;
}
