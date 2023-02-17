<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\encargado_cc;
use App\Centros;

class Jefaturas_centrosController extends Controller
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
         
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         
        $encargado_cc = encargado_cc::select( 'ordenes_de_compras.encargados_cc.id_cc','presupuesto.centro_de_costo.cc_nombre','presupuesto.centro_de_responsabilidad.cr_nombre','ordenes_de_compras.compra.compra_numero','ordenes_de_compras.compra.compra_amio','ordenes_de_compras.compra.compra_nombre_usuario_rut','ssalud.persona.per_nombre','ordenes_de_compras.compra.compra_telefono','ordenes_de_compras.compra.compra_fecha_guardada','ordenes_de_compras.compra.compra_id','presupuesto.centro_de_costo.cc_cr_id')
        ->join("presupuesto.centro_de_costo","ordenes_de_compras.encargados_cc.id_cc","=","presupuesto.centro_de_costo.cc_id")
        ->join("presupuesto.centro_de_responsabilidad","presupuesto.centro_de_costo.cc_cr_id","=","presupuesto.centro_de_responsabilidad.cr_id") 
        ->join("ordenes_de_compras.compra","ordenes_de_compras.compra.compra_cc","=","ordenes_de_compras.encargados_cc.id_cc") 
        ->join("ssalud.persona","ordenes_de_compras.compra.compra_nombre_usuario_rut",'=','ssalud.persona.per_rut')
        ->where('rut_encargado',$id)
        ->where('compra_amio','=',2021)
        ->where('compra_estado','=',2)
        ->get();
        return $encargado_cc;
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
