<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PersonaAnticipos;

class PersonaAnticiposController extends Controller
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
        $p_anticipo=new PersonaAnticipos();
        $p_anticipo->run=$request->run;
        $p_anticipo->nombre=$request->nombre;
        $p_anticipo->fiador=$request->fiador;
        $p_anticipo->estado=$request->estado;
        $p_anticipo->anticipo=$request->anticipo;
        $p_anticipo->save();

        return $p_anticipo->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $p_anticipo=PersonaAnticipos::where('run',$id)->orWhere('fiador','=',$id)->orWhere('anticipo','=',$id)->where('estado','=',0)->get();
        return $p_anticipo;
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
        $p_anticipo=PersonaAnticipos::find($id)->update($request->all());


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
