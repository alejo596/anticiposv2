<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\encargado_cc;
use App\Centros;
use App\Viaticos;

class ViaticosController extends Controller
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
        $viaticos=Viaticos::select('v_num as compra_numero','v_year as compra_amio','presupuesto.centro_de_costo.cc_nombre')
         ->join("ordenes_de_compras.encargados_cc","encargados_cc.id_cc","=","v_cc") 
        ->join("presupuesto.centro_de_costo","centro_de_costo.cc_id","=","ordenes_de_compras.encargados_cc.id_cc")        
        ->where('rut_encargado',$id)        
        ->where('v_estado','=',1)
        ->whereNull('v_firma_cc_run')
        ->whereNull('v_firma_cc')
        ->whereNull('v_firma_cr_run')
        ->whereNull('v_firma_cr')
        ->get();
        return $viaticos;
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
