<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rendiciones;
use App\Adjuntos;
use Illuminate\Support\Facades\DB;


class RendicionesController extends Controller
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


        $nombre = $request->file->getClientOriginalName();

        $ext=$request->file->getClientOriginalExtension();
        $ultima=$request->numero.'.'.$ext;

        $verificar=\Storage::put("public/".$request->year.'/'.$request->mes.'/'.$request->anticipo.'/'.$request->id_proveedor.'/'.  $ultima ,\File::get($request->file));

        $ad=new Adjuntos();
        $ad->url="public/".$request->year.'/'.$request->mes.'/'.$request->anticipo.'/'.$request->id_proveedor.'/'.$ultima;
        $ad->nombre_archivo=$ultima;
        $ad->save();


        if($verificar == true )
        {
            $ad_s=Adjuntos::select('id')->where('nombre_archivo',$ultima)->first();
            $id_a=$ad_s->id;

        }else{

          $id_a=$ad->id;
      }

      

      $rend=new Rendiciones();
      $rend->monto=$request->monto;
      $rend->anticipo_id=$request->anticipo;
      $rend->estados=1;
      $rend->tipo_compra="Compras menores a 3 UTM";
      $rend->tipo_doc=$request->tipo;
      $rend->fecha_doc=$request->fecha;
      $rend->numero_doc=$request->numero;
      $rend->socios_accionistas='No aplica';
      $rend->fecha_inicio=$request->fecha;
      $rend->fecha_termino=$request->fecha;
      $rend->tipo_unidad=1;
      $rend->proveedores_id=$request->id_proveedor;
      $rend->id_adjuntos=$id_a;
      $rend->id_usuario=$request->usuario;
      $rend->producto_id=$request->id_producto;
      $rend->cantidad_producto=$request->cantidad;
      $rend->id_cc=$request->cc;
      $rend->mes=$request->mes;
      $rend->objeto_contratacion=$request->descripcion;
      $rend->revisar=0;
      $rend->acto="Solicitud de Compra";
      $rend->nombre_sigfe=$request->nombre_sigfe;
      $rend->cuenta_sigfe=$request->cuenta_sigfe;
      $rend->sub_item_sigfe=$request->sub_item_sigfe;
      $rend->sigfe_item=$request->sigfe_item;
      $rend->save();

      return $rend->id;



  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show2($id)
    {

     $rendi=Rendiciones::select( 'anticipos.rendiciones.id',
       'anticipos.rendiciones.monto',
       'anticipos.rendiciones.fecha_rendicion',
       'anticipos.rendiciones.estados',
       'anticipos.rendiciones.anticipo_id',
       'anticipos.rendiciones.tipo_compra',
       'anticipos.rendiciones.tipo_doc',
       'anticipos.rendiciones.fecha_doc',
       'anticipos.rendiciones.numero_doc',
       'anticipos.rendiciones.socios_accionistas',
       'anticipos.rendiciones.objeto_contratacion',
       'anticipos.rendiciones.fecha_inicio',
       'anticipos.rendiciones.fecha_termino',
       'anticipos.rendiciones.tipo_unidad',
       'anticipos.rendiciones.observacion',
       'anticipos.rendiciones.url_texto',
       'anticipos.rendiciones.url_text_admin',
       'anticipos.rendiciones.url_text_admin_modificacion',
       'anticipos.rendiciones.actividad_doc',
       'anticipos.rendiciones.proveedores_id',
       'anticipos.rendiciones.id_adjuntos',
       'anticipos.rendiciones.id_usuario',
       'anticipos.rendiciones.producto_id',
       'anticipos.rendiciones.motivo_rechazo',
       'anticipos.rendiciones.id_seccion',
       'anticipos.rendiciones.cantidad_producto',
       'anticipos.rendiciones.id_cc_flag',
       'anticipos.rendiciones.estado_rendicion',
       'anticipos.rendiciones.id_cpp',
       'anticipos.rendiciones.id_productos_compra',
       'anticipos.rendiciones.id_max_saldo',
       'anticipos.rendiciones.codigo_devoluciones',
       'anticipos.rendiciones.mes',
       'anticipos.rendiciones.revisar',
       'anticipos.rendiciones.created_at',
       'anticipos.rendiciones.updated_at',
       'presupuesto.centro_de_costo.cc_nombre',
       'presupuesto.centro_de_costo.cc_id',
       'ordenes_de_compras.cpp.cpp_num',
       'anticipos.estados_rendiciones.nombre as nombre_estado',
       'anticipos.tipo_doc.nombre',
       'anticipos.adjuntos.url',
       'anticipos.adjuntos.nombre_archivo',             
       'aba.producto.produNombre')
     ->join('presupuesto.centro_de_costo','anticipos.rendiciones.id_cc','=','presupuesto.centro_de_costo.cc_id')
     ->leftJoin('ordenes_de_compras.cpp','anticipos.rendiciones.id_cpp','=','ordenes_de_compras.cpp.cpp_id')
     ->join('anticipos.estados_rendiciones','anticipos.rendiciones.estados','=','anticipos.estados_rendiciones.id')
     ->join('anticipos.tipo_doc','anticipos.rendiciones.tipo_doc','=','anticipos.tipo_doc.id')
     ->join('anticipos.adjuntos','anticipos.rendiciones.id_adjuntos','=','anticipos.adjuntos.id')
     ->join('aba.producto','anticipos.rendiciones.producto_id','=',DB::raw('aba.producto.produCodInt COLLATE utf8_general_ci'))
     ->where('anticipo_id',$id)
     ->whereIn('estados',[1,3,5])
     ->get();

     return $rendi;

 } 
 public function show($id)
 {
    $rendi=Rendiciones::select( 'anticipos.rendiciones.id',
       'anticipos.rendiciones.monto',
       'anticipos.rendiciones.fecha_rendicion',
       'anticipos.rendiciones.estados',
       'anticipos.rendiciones.anticipo_id',
       'anticipos.rendiciones.tipo_compra',
       'anticipos.rendiciones.tipo_doc',
       'anticipos.rendiciones.fecha_doc',
       'anticipos.rendiciones.numero_doc',
       'anticipos.rendiciones.socios_accionistas',
       'anticipos.rendiciones.objeto_contratacion',
       'anticipos.rendiciones.fecha_inicio',
       'anticipos.rendiciones.fecha_termino',
       'anticipos.rendiciones.tipo_unidad',
       'anticipos.rendiciones.observacion',
       'anticipos.rendiciones.url_texto',
       'anticipos.rendiciones.url_text_admin',
       'anticipos.rendiciones.url_text_admin_modificacion',
       'anticipos.rendiciones.actividad_doc',
       'anticipos.rendiciones.proveedores_id',
       'anticipos.rendiciones.id_adjuntos',
       'anticipos.rendiciones.id_usuario',
       'anticipos.rendiciones.producto_id',
       'anticipos.rendiciones.motivo_rechazo',
       'anticipos.rendiciones.id_seccion',
       'anticipos.rendiciones.cantidad_producto',
       'anticipos.rendiciones.id_cc_flag',
       'anticipos.rendiciones.estado_rendicion',
       'anticipos.rendiciones.id_cpp',
       'anticipos.rendiciones.id_productos_compra',
       'anticipos.rendiciones.id_max_saldo',
       'anticipos.rendiciones.codigo_devoluciones',
       'anticipos.rendiciones.mes',
       'anticipos.rendiciones.revisar',
       'anticipos.rendiciones.created_at',
       'anticipos.rendiciones.updated_at',
       'anticipos.rendiciones.nombre_sigfe',
       'anticipos.rendiciones.cuenta_sigfe',
       'anticipos.rendiciones.sub_item_sigfe',
       'anticipos.rendiciones.sigfe_item',
       'presupuesto.centro_de_costo.cc_nombre',
       'presupuesto.centro_de_costo.cc_id',
       'ordenes_de_compras.cpp.cpp_num',
       'anticipos.estados_rendiciones.nombre as nombre_estado',
       'anticipos.tipo_doc.nombre',
       'anticipos.adjuntos.url',
       'anticipos.adjuntos.nombre_archivo',             
       'aba.producto.produNombre')
    ->join('presupuesto.centro_de_costo','anticipos.rendiciones.id_cc','=','presupuesto.centro_de_costo.cc_id')
    ->leftJoin('ordenes_de_compras.cpp','anticipos.rendiciones.id_cpp','=','ordenes_de_compras.cpp.cpp_id')
    ->join('anticipos.estados_rendiciones','anticipos.rendiciones.estados','=','anticipos.estados_rendiciones.id')
    ->join('anticipos.tipo_doc','anticipos.rendiciones.tipo_doc','=','anticipos.tipo_doc.id')
    ->leftJoin('anticipos.adjuntos','anticipos.rendiciones.id_adjuntos','=','anticipos.adjuntos.id')
    ->join('aba.producto','anticipos.rendiciones.producto_id','=',DB::raw('aba.producto.produCodInt COLLATE utf8_general_ci'))
    ->where('anticipo_id',$id)
    ->where('estados','=',1)
    ->get();

    return $rendi;
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
        $rendiciones=Rendiciones::find($id)->update($request->all());
    }

    public function updatefondo(Request $request)
    {

        $rendiciones=Rendiciones::where('anticipo_id',$request->anticipo_id)->update(['envio'=>$request->envio,'estados'=>$request->estados]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rendiciones::find($id)->delete();
    }
}
