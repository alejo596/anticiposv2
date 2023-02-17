<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FirmasAnticipos;

class FirmasAnticiposController extends Controller
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
        $f_a=new FirmasAnticipos();
        $f_a->firma=$request->usuario;
        $f_a->unidad_negocio=$request->unidad;
        $f_a->estado=$request->estado;
        $f_a->id_anticipo=$request->id_anticipo;
        $f_a->save();

        return $f_a->id;

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
         $Solicitudes=FirmasAnticipos::where('id_anticipo',$request->id_anticipo)->where('unidad_negocio','=',$request->unidad_negocio)->update(['firma'=>$request->firma,'estado'=>$request->estado]);
       
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
