<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FondoFijos;
use App\encargado_cc;
use App\Centros;

class FondoFijosController extends Controller
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
        $fondo=FondoFijos::select('solicitudes.id  as compra_numero','numero','amio as compra_amio','fecha_ingresada','rut_ingresa','nombre_ingresa','monto','cr','cc','estado','fiador_id','estados_solicitudes.nombre AS estado_nombre','estado_usuario_firma','ordenes_de_compras.encargados_cc.rut_encargado','presupuesto.centro_de_costo.cc_nombre','fiadores.nombre as fiador_nombre')
        ->join('fiadores','fiadores.id','=','fiador_id')
        ->join('estados_solicitudes','estados_solicitudes.id','=','estado')
        ->join('presupuesto.centro_de_costo','centro_de_costo.cc_id','=','cc')
        ->join('anticipos_por_ff.adjuntos','adjuntos_id','=','anticipos_por_ff.adjuntos.id')
        ->join('ordenes_de_compras.encargados_cc','encargados_cc.id_cc','=','centro_de_costo.cc_id')
        ->join('fondo_fijosrendi','fondo_fijosrendi.id_solicitud','=','solicitudes.id')       
        ->where('ordenes_de_compras.encargados_cc.rut_encargado',$id)
        ->where('estado','=',1)
        ->where('fondo_fijosrendi.estado_usuario_firma','=',1)
        ->get();

        return $fondo;
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
