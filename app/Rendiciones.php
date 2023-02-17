<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Rendiciones extends Model
{
	protected $connection = 'Fondos_Fijos';
	protected $table = 'rendiciones';
	protected $fillable = [
		'id',
		'monto',		
		'anticipo_id',
		'estados',
		'tipo_compra',
		'tipo_doc',
		'fecha_doc',
		'numero_doc',
		'socios_accionistas',
		'objeto_contratacion',
		'fecha_inicio',
		'fecha_termino',
		'tipo_unidad',
		'observacion',
		'url_texto',
		'url_text_admin',
		'url_text_admin_modificacion',
		'actividad_doc',
		'proveedores_id',
		'id_adjuntos',
		'id_usuario',
		'producto_id',
		'motivo_rechazo',
		'id_seccion',
		'cantidad_producto',
		'id_cc_flag',
		'id_cc',
		'estado_rendicion',
		'id_cpp',
		'id_productos_compra',
		'id_max_saldo',
		'codigo_devoluciones',
		'mes',
		'revisar',
		'envio',
		'nombre_sigfe',
		'cuenta_sigfe',
		'sub_item_sigfe',
		'sigfe_item'
	];
		const CREATED_AT = 'created_at';
		const UPDATED_AT = 'updated_at';
		protected function serializeDate(DateTimeInterface $date){
    return $date->format('Y-m-d H:i:s');
}
	}









