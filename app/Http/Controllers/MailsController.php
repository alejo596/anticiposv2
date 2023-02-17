<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use File;

class MailsController extends Controller
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
    public function create($pdf)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function convertirPDF($pdf)
    {
        $pdf=base64_encode($pdf);
        return $pdf;
    }
    public function store(Request $request)
    {

            set_time_limit(0);
            $url=$request->url;
            if($request->tipo =='pdf'){
                $titulo='deposito.pdf';

            }else{
                 $titulo='deposito.'.$request->tipo;
            }
            $subject=$request->subject;

            $storagePath  = \Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
            $file =\File::get($storagePath.$url);
            $url1=$storagePath.$url;           
            $subject = "Deposito";
            $for =$request->correo;
            $mail=Mail::send('findelasession',$request->all(), function($msj) use($subject,$for,$file,$titulo){
            $msj->from("informatica@saludarica.cl","Fondos Fijos");
            $msj->attachData($file,$titulo);
            $msj->subject($subject);
            $msj->to($for);
             });

            dd('Email has been sent successfully');
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
