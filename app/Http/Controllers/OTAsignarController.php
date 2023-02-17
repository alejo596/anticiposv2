<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OTAsignari;

class OTAsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ot_asignar2=OTAsignari::select('ordenes_de_compras.compra.compra_id',
            'ordenes_de_compras.compra.compra_numero',
            'ordenes_de_compras.compra.compra_amio',
            'ordenes_de_compras.compra.compra_nombre_usuario_rut',
            'ordenes_de_compras.compra.compra_cc',
            'ordenes_de_compras.compra.compra_sub_direccion',
            'ordenes_de_compras.compra.compra_jefatura_sub_rut',
            'ordenes_de_compras.compra.compra_jefatura_sub_aprueba_fecha',
            'ordenes_de_compras.compra.compra_encargado_cc_rut',
            'ordenes_de_compras.compra.compra_encargado_cc_aprueba_fecha',
            'ordenes_de_compras.compra.compra_fecha_guardada',
            'ordenes_de_compras.compra.compra_rut_guardada',
            'ordenes_de_compras.compra.compra_fecha_enviar',
            'ordenes_de_compras.compra.compra_rut_enviar',
            'ordenes_de_compras.compra.compra_asignada',
            'ordenes_de_compras.compra.compra_estado',
            'ordenes_de_compras.compra.compra_correo',
            'ordenes_de_compras.compra.compra_proyecto',
            'ordenes_de_compras.compra.compra_telefono',
            'ordenes_de_compras.compra.compra_convenio',
            'ordenes_de_compras.compra.compra_anulada_por',
            'ordenes_de_compras.compra.compra_motivo_anulacion',
            'ordenes_de_compras.compra.compra_fecha_anulacion',
            'presupuesto.centro_de_costo.cc_nombre',
            'ssalud.persona.per_nombre',
            'ordenes_de_compras.estados_ot.estado_nombre',
            'presupuesto.centro_de_costo.cc_cr_id',
            'presupuesto.centro_de_responsabilidad.cr_nombre',
             'presupuesto.centro_de_costo.cc_id')
        ->join('presupuesto.centro_de_costo','ordenes_de_compras.compra.compra_cc','=','presupuesto.centro_de_costo.cc_id')
        ->join('ordenes_de_compras.estados_ot','ordenes_de_compras.compra.compra_estado','=','ordenes_de_compras.estados_ot.estado_id')
        ->join("ssalud.persona","ordenes_de_compras.compra.compra_nombre_usuario_rut",'=','ssalud.persona.per_rut')
         ->join("presupuesto.centro_de_responsabilidad","presupuesto.centro_de_costo.cc_cr_id","=","presupuesto.centro_de_responsabilidad.cr_id") 
        ->where('compra_sub_direccion',$request->id_sub)
        ->whereIn('compra_cc',array($request->id_cc_sub,$request->id_cc_sub2))
        ->where('compra_estado','=',2)
        ->whereNull('compra_asignada')
        ->orderBy('compra_numero', 'DESC');
        $ot_asignar=OTAsignari::select('ordenes_de_compras.compra.compra_id',
            'ordenes_de_compras.compra.compra_numero',
            'ordenes_de_compras.compra.compra_amio',
            'ordenes_de_compras.compra.compra_nombre_usuario_rut',
            'ordenes_de_compras.compra.compra_cc',
            'ordenes_de_compras.compra.compra_sub_direccion',
            'ordenes_de_compras.compra.compra_jefatura_sub_rut',
            'ordenes_de_compras.compra.compra_jefatura_sub_aprueba_fecha',
            'ordenes_de_compras.compra.compra_encargado_cc_rut',
            'ordenes_de_compras.compra.compra_encargado_cc_aprueba_fecha',
            'ordenes_de_compras.compra.compra_fecha_guardada',
            'ordenes_de_compras.compra.compra_rut_guardada',
            'ordenes_de_compras.compra.compra_fecha_enviar',
            'ordenes_de_compras.compra.compra_rut_enviar',
            'ordenes_de_compras.compra.compra_asignada',
            'ordenes_de_compras.compra.compra_estado',
            'ordenes_de_compras.compra.compra_correo',
            'ordenes_de_compras.compra.compra_proyecto',
            'ordenes_de_compras.compra.compra_telefono',
            'ordenes_de_compras.compra.compra_convenio',
            'ordenes_de_compras.compra.compra_anulada_por',
            'ordenes_de_compras.compra.compra_motivo_anulacion',
            'ordenes_de_compras.compra.compra_fecha_anulacion',
            'presupuesto.centro_de_costo.cc_nombre',
            'ssalud.persona.per_nombre',
            'ordenes_de_compras.estados_ot.estado_nombre',
            'presupuesto.centro_de_costo.cc_cr_id',
            'presupuesto.centro_de_responsabilidad.cr_nombre',
             'presupuesto.centro_de_costo.cc_id')
        ->join('presupuesto.centro_de_costo','ordenes_de_compras.compra.compra_cc','=','presupuesto.centro_de_costo.cc_id')
        ->join('ordenes_de_compras.estados_ot','ordenes_de_compras.compra.compra_estado','=','ordenes_de_compras.estados_ot.estado_id')
        ->join("ssalud.persona","ordenes_de_compras.compra.compra_nombre_usuario_rut",'=','ssalud.persona.per_rut')
         ->join("presupuesto.centro_de_responsabilidad","presupuesto.centro_de_costo.cc_cr_id","=","presupuesto.centro_de_responsabilidad.cr_id") 
        ->where('compra_sub_direccion',$request->id_sub)
        ->where('compra_estado','=',3)
        ->whereNull('compra_asignada')
        ->orderBy('compra_numero', 'DESC')
        ->union($ot_asignar2)
        ->get();

        return  $ot_asignar;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
