<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anticipos;
use Illuminate\Support\Facades\Storage;

class AnticiposController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        ini_set('memory_limit', '1024M');
        $anticipo=Anticipos::select('facturacionv2.fondos_fijos.id',
            'facturacionv2.fondos_fijos.numero',
            'facturacionv2.fondos_fijos.year',
            'facturacionv2.fondos_fijos.monto',
            'facturacionv2.fondos_fijos.estado',
            'facturacionv2.fondos_fijos.created_at',
            'facturacionv2.fondos_fijos.fecha_pago',
            'facturacionv2.fondos_fijos.fecha_pago_sistema',
            'facturacionv2.fondos_fijos.comprobante',
            'facturacionv2.fondos_fijos.sigfe_devengo',
            'facturacionv2.fondos_fijos.sigfe_compensatorio',
            'facturacionv2.fondos_fijos.id_cpp',
            'facturacionv2.fondos_fijos.pagado_por',
            'facturacionv2.fondos_fijos.sigfe_pago',
            'facturacionv2.fondos_fijos.sigfe_compromiso',
            'facturacionv2.fondos_fijos.motivo_rechazo',
            'facturacionv2.fondos_fijos.cpp_pagado_anterior',
            'facturacionv2.fondos_fijos.revision',
            'facturacionv2.fondos_fijos.ultima_rendicion',
            'anticipos.fiadores.nombre',
            'presupuesto.centro_de_costo.cc_nombre',
            'presupuesto.centro_de_costo.cc_id',
            'anticipos.anticipo_solicitud.id_anticipo',
            'anticipos.solicitudes.rut_ingresa',
            'anticipos.fiadores.run',
            'anticipos.fiadores.cc_extra_pre',
            'anticipos.fiadores.id AS fiador_id',          
             'anticipos.fiadores.id_proveedor AS fiador_proveedor',  
            'facturacionv2.documento_estado.estado AS estado_anticipo',
            'anticipos.anticipo_solicitud.id_solicitud')
        ->join('anticipos.fiadores','facturacionv2.fondos_fijos.fiador','=','anticipos.fiadores.id')

        ->join('presupuesto.centro_de_costo','facturacionv2.fondos_fijos.cc_id','=','presupuesto.centro_de_costo.cc_id')

        ->join('anticipos.anticipo_solicitud','facturacionv2.fondos_fijos.id','=','anticipos.anticipo_solicitud.id_anticipo')

        ->join('anticipos.solicitudes','anticipos.anticipo_solicitud.id_solicitud','=','anticipos.solicitudes.id')
        ->join('facturacionv2.documento_estado','facturacionv2.fondos_fijos.estado','=','facturacionv2.documento_estado.id')
        
        ->leftJoin('anticipos.personas_anticipos','facturacionv2.fondos_fijos.id','=','anticipos.personas_anticipos.anticipo')

        
        ->where(function($query) use ($id) {
          
        $query->orWhere('anticipos.personas_anticipos.run','=',$id)
        ->orWhere('anticipos.personas_anticipos.run','=',$id)
        ->orWhere('anticipos.fiadores.run','=',$id);      
          

      })
        ->where('facturacionv2.fondos_fijos.estado','<>',14)
        ->get();
        

        return $anticipo;
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
     $Solicitudes=Anticipos::find($id)->update($request->all());
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
