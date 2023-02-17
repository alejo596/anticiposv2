<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firmas extends Model
{
   protected $connection = 'Fondos_Fijos';
	protected $table = 'firma_solicitudes';

protected $fillable =['id',
'firma',
'unidad_negocio',
'estado',
'id_solicitud'
];
	
	const CREATED_AT = 'fecha';
	const UPDATED_AT = 'updated_at';
}
