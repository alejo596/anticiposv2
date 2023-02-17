<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adjuntos;
use Illuminate\Support\Facades\Crypt;
use App\Rendiciones;
use Illuminate\Support\Facades\Storage;

class AdjuntosController extends Controller
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

        return $id_a;

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
        $url=Adjuntos::find($id,['url']);

        
       $e= Storage::disk('public')->delete($url->url);
       
       if($e == true){
        $ad=Adjuntos::find($id)->delete();
       }
        

        
    }
}
