<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjuntos extends Model
{
    protected $connection = 'Fondos_Fijos';
	protected $table = 'adjuntos';	
	protected $fillable = [
		'url',
		'nombre_archivo',
		

	];
	
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
 
}
