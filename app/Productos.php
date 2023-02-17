<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $connection = 'mysql';
    protected $table = 'producto_compra';
	public $timestamps = false;
}
