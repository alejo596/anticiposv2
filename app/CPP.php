<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CPP extends Model
{
	protected $connection = 'mysql';
	protected $table = 'CPP';
	protected $fillable = [
		'cpp_id',
		'cpp_num',
		'cpp_amio',
		'cpp_fecha',
		'cpp_id_proceso_de_compra',
		'cpp_cantidad_producto',
		'cpp_total_neto',
		'cpp_c_c',
		'cpp_proveedor',
		'cpp_estado_refrendacion',
		'cpp_proveedor_nombre',
		'cpp_id_oc_portal',
		'cpp_id_oc_portal_fecha_creacion',
		'cpp_id_oc_portal_num_interno_portal',
		'cpp_id_oc_portal_estado_num',
		'cpp_id_oc_portal_estado_nombre',
		'cpp_total_mas_iva',
		'cpp_iva',
		'cpp_estado',
		'cpp_estado_anterior',
		'cpp_envio_a_refrendar',
		'cpp_costo_despacho',
		'cpp_con_iva',
		'cpp_descuento',
		'cpp_total_neto_mas_otros_gastos',
		'cpp_fecha_refrendacion',
		'cpp_persona_aprueba_refrendacion',
		'cpp_observacion',
		'cpp_usuario_crea',
		'cpp_depto_crea',
		'detalle_fecha_licitacion',
		'detalle_licitacion_numero',
		'cpp_observacion_anulacion',
		'cpp_fecha_anulacion',
		'cpp_rut_anula',
		'cpp_complementaria_num',
		'cpp_complementaria_amio',
		'cpp_complementaria_id',
		'gasto_pre_refrendada_por_usuario',
		'gasto_pre_refrendada_fecha_por_usuario',
		'gasto_pre_refrendada_por_jefatura',
		'gasto_pre_refrendada_fecha_por_jefatura',
		'cpp_rut_servicio',
		'cpp_fecha_servicio',
		'cpp_ip_servicio',
		'cpp_numero_factura',
		'cpp_amio_factura',
		'cpp_observacion_refrendacion',
		'cpp_nomina_refendacion_id',
		'cpp_nomina_refendacion_num',
		'cpp_nomina_refendacion_amio',
		'cpp_impuesto',
		'cpp_convenio_nuevo',
		'cpp_convenio_nombre',
		'cpp_convenio_id',
		'cpp_convenio_fecha_inicio',
		'cpp_convenio_fecha_termino',
		'cpp_ajuste',
		'cpp_total_con_ajuste',
		'cpp_tipo',
		'cpp_gasto_basico',
		'cpp_bpm',
		'cpp_pre_fact',
		'cpp_prerecep',
		'cpp_costo_despacho_con_iva',
		'cpp_fecha_servicio_realizado',
		'cpp_requiere_participantes',
		'cpp_solicitante_conformidad',
		'cpp_fecha_solicitada_conformidad',
		'cpp_conformidad_unica',
		'cpp_anticipo',
		'cpp_sigfe'

	];

	public $timestamps = false;
}



