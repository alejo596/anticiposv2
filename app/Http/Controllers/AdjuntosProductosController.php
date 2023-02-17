<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdjuntosProductos;
use App\Adjuntos;
use Illuminate\Support\Facades\Crypt;

class AdjuntosProductosController extends Controller
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
       $fecha2 = date_create();
       $id=$request->id;
       $timestamp=date_timestamp_get($fecha2);
       $randomkey=rand();
       $key=base64_encode($timestamp.$randomkey.$id);
       
       $url=explode(".",$request->url);

       $url_final=$key.'.'.$url[1];
       
       $ad=new AdjuntosProductos();
       $ad->adj_adjuntado='V';
       $ad->adj_nombre=$url_final;
       $ad->adj_fecha=date('Y-m-d');
       $ad->adj_id_cpp=$request->adj_id_cpp;
       $ad->adj_nombre_subio=$request->nombre;
       $ad->save();

       return $url_final;
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $ad=Adjuntos::select('anticipos.rendiciones.id_adjuntos','adjuntos.url','adjuntos.nombre_archivo')
       ->join('anticipos.rendiciones','anticipos.adjuntos.id','=','anticipos.rendiciones.id_adjuntos')
       ->where('anticipos.rendiciones.estados',1)->where('anticipos.rendiciones.anticipo_id','=',$id)
       ->get();
       return $ad;
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
