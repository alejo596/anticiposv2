<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Anticipos extends Model
{
	protected $connection = 'facturacion';
	protected $table = 'fondos_fijos';	
	protected $fillable = [
		'id',
		'numero',
		'`year`',
		'fiador',
		'monto',
		'estado',
		'created_at',
		'memo_pdf',
		'fecha_pago',
		'fecha_pago_sistema',
		'comprobante',
		'sigfe_devengo',
		'sigfe_compensatorio',
		'id_cpp',
		'pagado_por',
		'sigfe_pago',
		'sigfe_compromiso',
		'motivo_rechazo',
		'cpp_pagado_anterior',
		'cc_id',
		'revision',
		'ultima_rendicion'
	];

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
		protected function serializeDate(DateTimeInterface $date){
    return $date->format('Y-m-d H:i:s');
   }
}


