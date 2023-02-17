<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosABA extends Model
{
    protected $connection = 'aba';
    protected $table = 'producto';
	public $timestamps = false;
}
