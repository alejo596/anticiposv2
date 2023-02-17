<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CPP;
use App\Solicitudes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\AdjuntosProductos;

class CPPController extends Controller
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
     $adj=Solicitudes::where('solicitudes.id',$request->solicitud)->join('adjuntos','solicitudes.adjuntos_id','=','adjuntos.id')->first();
     $url=explode(".",$adj->url);
    

     $id=$request->solicitud;
     $timestamp=125346164;
     $randomkey=21415;
     $key=base64_encode($timestamp.$randomkey.$id);
     $url_final=$key.'.'.$url[1];     

     $storagePath  = Storage::disk('local')->get($adj->url);

     
   
   
     $anio = date('Y');
     $mes = date('m');


     $carpeta_sist = 'OT/ADJCPP';
     $ruta  = $carpeta_sist.'/'.$anio.'/'.$mes;

      $fileRemote = $ruta.'/'.$url_final;
        $mode = 'FTP_BINARY';        //Hacemos el upload

        
        $ftp_l=Storage::disk('ftp')->put($fileRemote,$storagePath);

        $cpp_ultimo=CPP::where('cpp_amio',$request->year)->max('cpp_num');       
        $valor_cpp=$cpp_ultimo+1;
        $proveedor=explode("-",$request->fiador);
        $fecha=date("Y-m-d h:m:s");      
        $cpp=new CPP();
        $cpp->cpp_num=$valor_cpp;
        $cpp->cpp_amio=$request->year;
        $cpp->cpp_fecha=$fecha;
        $cpp->cpp_total_neto=$request->monto;
        $cpp->cpp_c_c=$request->cc;
        $cpp->cpp_proveedor=$proveedor[0];
        $cpp->cpp_proveedor_nombre=$request->nombre_fiador;
        $cpp->cpp_estado=$request->estado;
        $cpp->cpp_descuento=$request->descuento;
        $cpp->cpp_total_neto_mas_otros_gastos=$request->monto;
        $cpp->cpp_observacion=$request->observacion;
        $cpp->cpp_usuario_crea=$request->fiador;
        $cpp->cpp_tipo=$request->tipo;
        $cpp->cpp_total_mas_iva=$request->monto;
        $cpp->cpp_total_con_ajuste=$request->precio;
        $cpp->save();

        $ad=new AdjuntosProductos();
        $ad->adj_adjuntado='F';
        $ad->adj_nombre=$url_final;
        $ad->adj_fecha=date('Y-m-d');
        $ad->adj_id_cpp=$cpp->id;
        $ad->adj_nombre_subio=$adj->nombre_archivo;
        $ad->save();


        return $cpp->id;

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
