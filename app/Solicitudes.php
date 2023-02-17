<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Solicitudes extends Model
{
    protected $connection = 'Fondos_Fijos';
    protected $table = 'solicitudes';
   protected $fillable = [
 'id',
'numero',
'amio',
'fecha_ingresada',
'rut_ingresa',
'nombre_ingresa',
'monto',
'cc',
'cr',
'estado',
'fiador_id',
'motivo_rechazo',
'mes',
'adjuntos_id',
'flag_firma',
'cc_extra_pre',
'updated_at'];
	const CREATED_AT = 'fecha_ingresada';
	const UPDATED_AT = 'updated_at';
		protected function serializeDate(DateTimeInterface $date){
    return $date->format('Y-m-d H:i:s');
}

}
