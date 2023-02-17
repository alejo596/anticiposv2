<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedores_FF;

class Proveedores_FFController extends Controller
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

        $pro=new Proveedores_FF();
        if($request->tipo == 1){
        $pro->nombre=$request->nombre_proveedor;
        }else{
         $pro->razon_social=$request->nombre_proveedor;  
         }        
        $pro->rut=$request->run;
        $pro->apellido_paterno=$request->apellido_p;
        $pro->apellido_materno=$request->apellido_m;
        $pro->tipo_de_empresa=$request->tipo;
        $pro->save();

        return $pro->id;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pro=Proveedores_FF::where('rut','like','%'.$id.'%')
        ->orWhere('nombre','like','%'.$id.'%')
        ->orWhere('razon_social','like','%'.$id.'%')
        ->get();
        return $pro;
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
