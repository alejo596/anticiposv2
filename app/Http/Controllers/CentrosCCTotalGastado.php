<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TotalGastadoCC;
use Illuminate\Support\Facades\DB;

class CentrosCCTotalGastado extends Controller
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
        $year=date("Y");

        $gastado=DB::connection('mysql2')
          ->select('SELECT
                    Sum(gasto_presupuestario.gasto_pre_monto) AS total
                    FROM
                    gasto_presupuestario
                    WHERE
                    gasto_presupuestario.gasto_pre_id_cc ='.$id.' AND      
                    LEFT(gasto_presupuestario.gasto_pre_sub_sigfe, 2) = 22 AND                      
                    gasto_presupuestario.gasto_pre_amio = '.$year.' AND
                    gasto_presupuestario.gasto_pre_estado = 2 AND
                    gasto_presupuestario.gasto_pre_convenio IS NULL');
             $g=json_encode($gastado);

        return $g;

       
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
