<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encargados extends Model
{
    protected $table = 'encargados_cc';
	public $timestamps = false;
    protected $fillable = [
		
		'id_cc', 'rut_encargado'
	];

}
