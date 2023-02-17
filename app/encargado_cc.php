<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class encargado_cc extends Model
{
	protected $connection = 'mysql';
	protected $table = 'encargados_cc';
	public $timestamps = false;
    protected $fillable = [
		
		'id_cc', 'rut_encargado'
	];

}
