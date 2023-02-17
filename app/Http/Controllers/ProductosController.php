<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Productos;
use App\Rendiciones;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
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
        if($request->pro_cc ==30){
            $presupuesto_id_codigo_sigfe=114050601;
            $presupuesto_sub_item_sigfe=114050601;
            $presupuesto_nombre_sigfe='Anticipo de Fdos Ley de Alcoholes';
            $gasto_pre_sub_sigfe_familia=11;



        }elseif($request->pro_cc ==31){
            $presupuesto_id_codigo_sigfe=1140504;
            $presupuesto_sub_item_sigfe=1140504;
            $presupuesto_nombre_sigfe='CONACE';
            $gasto_pre_sub_sigfe_familia=11;

        }elseif($request->pro_cc ==147){
            $presupuesto_id_codigo_sigfe=114050602;
            $presupuesto_sub_item_sigfe=114050602;
            $presupuesto_nombre_sigfe='Otros Fondos en Administracion';
            $gasto_pre_sub_sigfe_familia=11;

        }elseif ($request->pro_cc==104) {
            $presupuesto_id_codigo_sigfe=114050602;
            $presupuesto_sub_item_sigfe=114050602;
            $presupuesto_nombre_sigfe='Otros Fondos en Administracion';
            $gasto_pre_sub_sigfe_familia=11;


        }else{ 

            $productos=DB::connection('Fondos_Fijos')->select('SELECT
            presupuesto.gasto_presupuestario.gasto_pre_sigfe AS presupuesto_id_codigo_sigfe,
            presupuesto.gasto_presupuestario.gasto_pre_sub_sigfe AS presupuesto_sub_item_sigfe,
            presupuesto.cuentas_sigfe.sigfe_nombre AS presupuesto_nombre_sigfe,
            presupuesto.gasto_presupuestario.gasto_pre_sub_sigfe_familia AS item
            FROM
            ordenes_de_compras.producto_compra,
            presupuesto.gasto_presupuestario
            INNER JOIN presupuesto.cuentas_sigfe ON presupuesto.cuentas_sigfe.sigfe_id = presupuesto.gasto_presupuestario.gasto_pre_sigfe
            WHERE
            ordenes_de_compras.producto_compra.pro_id_aba ="'.$request->id_aba.'"
            AND ordenes_de_compras.producto_compra.pro_estado_producto = 6
            AND ordenes_de_compras.producto_compra.pro_id = presupuesto.gasto_presupuestario.gasto_pre_id_producto
            ORDER BY
            ordenes_de_compras.producto_compra.pro_id_oc DESC
            LIMIT 1');
           if(!empty($productos)){
            foreach ($productos as $key ) {
                $presupuesto_id_codigo_sigfe=$key->presupuesto_id_codigo_sigfe;
                $presupuesto_sub_item_sigfe=$key->presupuesto_sub_item_sigfe;
                $presupuesto_nombre_sigfe=$key->presupuesto_nombre_sigfe;
            }
            

           }else{
            $presupuesto_id_codigo_sigfe=NULL;
            $presupuesto_sub_item_sigfe=NULL;
            $presupuesto_nombre_sigfe=NULL;
            $gasto_pre_sub_sigfe_familia=NULL;

           }   

        }
     $valorpromedio=$request->precio/$request->cantidad;

        $pro=new Productos();
        $pro->pro_cc=$request->pro_cc;
        $pro->pro_nombre=$request->id_aba.'-'.$request->nombre;
        $pro->pro_cantidad=1;
        $pro->pro_precio=$request->precio;
        $pro->pro_id_aba=$request->id_aba;
        $pro->pro_id_cpp=$request->cpp;
        $pro->pro_total=$request->pro_total;
        $pro->pro_estado_producto=$request->estado_pro;
        $pro->pro_amio=$request->pro_amio;
        $pro->pro_precio_unitario=$valorpromedio;
        $pro->pro_cantidad_unitario=$request->cantidad;
        $pro->pro_uindad_medida='UD';
        $pro->pro_cuenta_sigfe=$presupuesto_id_codigo_sigfe;
        $pro->pro_nombre_sigfe=$presupuesto_nombre_sigfe;
        $pro->pro_sub_item_sigfe=$presupuesto_sub_item_sigfe;
        $pro->pro_costo_unitario_incluye_todo=$request->pro_total;
        $pro->save();

        Rendiciones::where('id',$request->id_rendiciones)->update(['id_productos_compra'=>$pro->id]);

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
       $productos=Productos::where('pro_id_oc',$id)->where('pro_estado_producto','!=',9)->get();
       return $productos;
   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update2($id)
    {
       Productos::where('pro_id',$request->pro_id)->update(['pro_estado'=>$request->pro_descripcion]);

   }
   public function update(Request $request, $id)
   {
     Productos::where('pro_id',$request->pro_id)->update(['pro_descripcion'=>$request->pro_descripcion,'pro_justificacion'=>$request->pro_justificacion]);
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // Productos::where('pro_id',$id)->delete();
    }
}
