<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cpp_Anticipo extends Model
{
    protected $connection = 'Fondos_Fijos';
    protected $table = 'cpp_anticipo';
	protected $fillable = [
		'id',
		'id_cpp',
		'id_anticipo',
		'usuario'		
		
	];
		const CREATED_AT = 'created_at';
		const UPDATED_AT = 'updated_at';
}
