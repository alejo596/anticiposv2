<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FtpController extends Controller
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
        
        
      
        
         $storagePath=Storage::disk('public')->get($request->url);
       
       
     
       
        $anio = date('Y');
        $mes = date('m');


        $carpeta_sist = 'OT/ADJCPP';
        $ruta  = $carpeta_sist.'/'.$anio.'/'.$mes;
        
        $fileRemote = $ruta.'/'.$request->nombre_original;
        $mode = 'FTP_BINARY';        //Hacemos el upload
          
        
        $ftp_l=Storage::disk('ftp')->put($fileRemote,$storagePath);
       
        if($ftp_l == false){
           return('Operación rechazada');
        }else{
           return('Operación realizada con éxito');
        }
        //Detenemos la funcion con un mensajes
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
