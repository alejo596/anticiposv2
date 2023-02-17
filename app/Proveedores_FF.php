<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedores_FF extends Model
{
	protected $connection = 'Fondos_Fijos';
	protected $table = 'proveedores';

	protected $fillable = [
		'id',
		'nombre',
		'rut',
		'apellido_paterno',
		'apellido_materno',
		'tipo_de_empresa',
		'razon_social'
	];
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
}



