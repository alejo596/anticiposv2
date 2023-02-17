<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitudes;
use App\Adjuntos;
use App\firma_soliicitudes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     $solicitud=DB::connection('Fondos_Fijos')->select('SELECT
        anticipos.solicitudes.id,
        anticipos.solicitudes.numero,
        anticipos.solicitudes.amio,
        anticipos.solicitudes.fecha_ingresada,
        anticipos.solicitudes.rut_ingresa,
        anticipos.solicitudes.nombre_ingresa,
        anticipos.solicitudes.monto,
        anticipos.solicitudes.cc,
        anticipos.solicitudes.cr,
        anticipos.solicitudes.estado,
        anticipos.solicitudes.fiador_id,
        anticipos.solicitudes.motivo_rechazo,
        anticipos.solicitudes.mes,
        anticipos.solicitudes.adjuntos_id,
        anticipos.solicitudes.flag_firma,
        anticipos.solicitudes.cc_extra_pre,
        anticipos.solicitudes.updated_at,
        presupuesto.centro_de_costo.cc_nombre AS centro_costo,
        anticipos.fiadores.nombre AS fiador_nombre,
        anticipos.fiadores.run,
        anticipos.estados_solicitudes.nombre AS estado_nombre,
        anticipos.adjuntos.url,
        anticipos.adjuntos.id AS id_url
        FROM
        anticipos.solicitudes
        INNER JOIN presupuesto.centro_de_costo ON anticipos.solicitudes.cc = presupuesto.centro_de_costo.cc_id
        INNER JOIN anticipos.fiadores ON anticipos.solicitudes.fiador_id = anticipos.fiadores.id
        INNER JOIN anticipos.estados_solicitudes ON anticipos.solicitudes.estado = anticipos.estados_solicitudes.id
        INNER JOIN anticipos.adjuntos ON anticipos.solicitudes.adjuntos_id = anticipos.adjuntos.id
        ');

     return $solicitud;
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
        $nombre = $request->archivo->getClientOriginalName();
        \Storage::put('/public/'.$request->mes.'/'.$request->year.'/'.$nombre,\File::get($request->archivo));
        $ad=new Adjuntos();
        $ad->url="public/".$request->mes.'/'.$request->year.'/'.$nombre;
        $ad->nombre_archivo=$nombre;
        $ad->save();

        
        $soli=new Solicitudes();
        $soli->monto=$request->monto;
        $soli->estado=1;
        $soli->amio=$request->year;
        $soli->mes=$request->mes;
        $soli->cc=$request->cc;
        $soli->cr=$request->cr;
        $soli->fiador_id=$request->id_fiador;
        $soli->rut_ingresa=$request->usuario;
        $soli->cc_extra_pre=$request->cc_extra;
        $soli->flag_firma=$request->flag;
        $soli->adjuntos_id=$ad->id;
        $soli->save();

        if($request->run_firma != ''){
            $r=new firma_soliicitudes();
            $r->firma=$request->run_firma;
            $r->unidad_negocio=3;
            $r->estado=0;
            $r->id_solicitud=$soli->id;
            $r->save();

        }else{            
            $r=new firma_soliicitudes();
            $r->firma=null;
            $r->unidad_negocio=1;
            $r->estado=0;
            $r->id_solicitud=$soli->id;
            $r->save();

        }


        return $soli->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $solicitud1=DB::connection('Fondos_Fijos')->select('SELECT
            anticipos.solicitudes.id,
            anticipos.solicitudes.numero,
            anticipos.solicitudes.amio,
            anticipos.solicitudes.fecha_ingresada,
            anticipos.solicitudes.rut_ingresa,
            anticipos.solicitudes.nombre_ingresa,
            anticipos.solicitudes.monto,
            anticipos.solicitudes.cc,
            anticipos.solicitudes.cr,
            anticipos.solicitudes.estado,
            anticipos.solicitudes.fiador_id,
            anticipos.solicitudes.motivo_rechazo,
            anticipos.solicitudes.mes,
            anticipos.solicitudes.adjuntos_id,
            anticipos.solicitudes.flag_firma,
            anticipos.solicitudes.cc_extra_pre,
            anticipos.solicitudes.updated_at,
            presupuesto.centro_de_costo.cc_nombre AS centro_costo,
            anticipos.fiadores.nombre AS fiador_nombre,
            anticipos.fiadores.run,
            anticipos.estados_solicitudes.nombre AS estado_nombre,
            anticipos.adjuntos.url,
            anticipos.adjuntos.id AS id_url,
            anticipos.firma_solicitudes.estado AS estado_firma,
            anticipos.firma_solicitudes.id_solicitud,
            anticipos.firma_solicitudes.fecha,
            anticipos.firma_solicitudes.unidad_negocio,
            anticipos.firma_solicitudes.firma
            FROM
            anticipos.solicitudes
            INNER JOIN presupuesto.centro_de_costo ON anticipos.solicitudes.cc = presupuesto.centro_de_costo.cc_id
            INNER JOIN anticipos.fiadores ON anticipos.solicitudes.fiador_id = anticipos.fiadores.id
            INNER JOIN anticipos.estados_solicitudes ON anticipos.solicitudes.estado = anticipos.estados_solicitudes.id
            INNER JOIN anticipos.adjuntos ON anticipos.solicitudes.adjuntos_id = anticipos.adjuntos.id
            inner JOIN anticipos.firma_solicitudes ON anticipos.solicitudes.id = anticipos.firma_solicitudes.id_solicitud
            WHERE    anticipos.firma_solicitudes.estado=0 and anticipos.solicitudes.rut_ingresa="'.$id.'" or anticipos.firma_solicitudes.firma="'.$id.'"');
        if(count($solicitud1 )== 0){
            $solicitud2=DB::connection('Fondos_Fijos')->select('SELECT
                anticipos.solicitudes.id,
                anticipos.solicitudes.numero,
                anticipos.solicitudes.amio,
                anticipos.solicitudes.fecha_ingresada,
                anticipos.solicitudes.rut_ingresa,
                anticipos.solicitudes.nombre_ingresa,
                anticipos.solicitudes.monto,
                anticipos.solicitudes.cc,
                anticipos.solicitudes.cr,
                anticipos.solicitudes.estado,
                anticipos.solicitudes.fiador_id,
                anticipos.solicitudes.motivo_rechazo,
                anticipos.solicitudes.mes,
                anticipos.solicitudes.adjuntos_id,
                anticipos.solicitudes.flag_firma,
                anticipos.solicitudes.cc_extra_pre,
                anticipos.solicitudes.updated_at,
                presupuesto.centro_de_costo.cc_nombre AS centro_costo,
                anticipos.fiadores.nombre AS fiador_nombre,
                anticipos.fiadores.run,
                anticipos.estados_solicitudes.nombre AS estado_nombre,
                anticipos.adjuntos.url,
                anticipos.adjuntos.id AS id_url,
                anticipos.firma_solicitudes.estado AS estado_firma,
                anticipos.firma_solicitudes.id_solicitud,
                anticipos.firma_solicitudes.fecha,
                anticipos.firma_solicitudes.unidad_negocio,
                anticipos.firma_solicitudes.firma
                FROM
                anticipos.solicitudes
                INNER JOIN presupuesto.centro_de_costo ON anticipos.solicitudes.cc = presupuesto.centro_de_costo.cc_id
                INNER JOIN anticipos.fiadores ON anticipos.solicitudes.fiador_id = anticipos.fiadores.id
                INNER JOIN anticipos.estados_solicitudes ON anticipos.solicitudes.estado = anticipos.estados_solicitudes.id
                INNER JOIN anticipos.adjuntos ON anticipos.solicitudes.adjuntos_id = anticipos.adjuntos.id
                inner JOIN anticipos.firma_solicitudes ON anticipos.solicitudes.id = anticipos.firma_solicitudes.id_solicitud
                WHERE    anticipos.firma_solicitudes.estado=0 and anticipos.fiadores.run="'.$id.'" or anticipos.firma_solicitudes.firma="'.$id.'"');

            if(count($solicitud2)== 0){
              $solicitud3=DB::connection('Fondos_Fijos')->select('SELECT
                anticipos.solicitudes.id,
                anticipos.solicitudes.numero,
                anticipos.solicitudes.amio,
                anticipos.solicitudes.fecha_ingresada,
                anticipos.solicitudes.rut_ingresa,
                anticipos.solicitudes.nombre_ingresa,
                anticipos.solicitudes.monto,
                anticipos.solicitudes.cc,
                anticipos.solicitudes.cr,
                anticipos.solicitudes.estado,
                anticipos.solicitudes.fiador_id,
                anticipos.solicitudes.motivo_rechazo,
                anticipos.solicitudes.mes,
                anticipos.solicitudes.adjuntos_id,
                anticipos.solicitudes.flag_firma,
                anticipos.solicitudes.cc_extra_pre,
                anticipos.solicitudes.updated_at,
                presupuesto.centro_de_costo.cc_nombre AS centro_costo,
                anticipos.fiadores.nombre AS fiador_nombre,
                anticipos.fiadores.run,
                anticipos.estados_solicitudes.nombre AS estado_nombre,
                anticipos.adjuntos.url,
                anticipos.adjuntos.id AS id_url,
                anticipos.firma_solicitudes.estado AS estado_firma,
                anticipos.firma_solicitudes.id_solicitud,
                anticipos.firma_solicitudes.fecha,
                anticipos.firma_solicitudes.unidad_negocio,
                anticipos.firma_solicitudes.firma
                FROM
                anticipos.solicitudes
                INNER JOIN presupuesto.centro_de_costo ON anticipos.solicitudes.cc = presupuesto.centro_de_costo.cc_id
                INNER JOIN anticipos.fiadores ON anticipos.solicitudes.fiador_id = anticipos.fiadores.id
                INNER JOIN anticipos.estados_solicitudes ON anticipos.solicitudes.estado = anticipos.estados_solicitudes.id
                INNER JOIN anticipos.adjuntos ON anticipos.solicitudes.adjuntos_id = anticipos.adjuntos.id
                inner JOIN anticipos.firma_solicitudes ON anticipos.solicitudes.id = anticipos.firma_solicitudes.id_solicitud
                WHERE    anticipos.firma_solicitudes.estado=0 and anticipos.firma_solicitudes.firma ="'.$id.'"');

               if(count($solicitud3)== 0){
                $solicitud=$solicitud3;

               }else{
                 $solicitud=$solicitud3;

               }

          }else{
            $solicitud=$solicitud2;
        }

    }else{

     $solicitud=$solicitud1; 

 }


 return $solicitud;

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
        $Solicitudes=Solicitudes::find($id)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $solicitudes=Solicitudes::find($id)->delete();
    }
}
