<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Log_Errores;
use Mail;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
   public function report(Throwable $exception)
    {

        if ($exception instanceof \Exception) {
        // Fetch the error information we would like to 
        // send to the view for emailing
            $error=array(
                'file'  => $exception->getFile(),
                'code'  => $exception->getCode(),
                'line'  => $exception->getLine(),
                'message' => $exception->getMessage(),
                'sistema' => 'fondo fijo',
                
            );
         

            $err=new Log_Errores();
            $err->file=$exception->getFile();
            $err->code=$exception->getCode();
            $err->line=$exception->getLine();
            $err->message=$exception->getMessage();  
            $err->sistema='fondo fijo';             
            $err->save();
           
        // Only send email reports on production server
            // if(ENV('APP_ENV') == "local"){
            #1. Queue email for sending on "exceptions_emails" queue
            #2. Use the emails.exception_notif view shown below
            #3. Pass the error array to the view as variable $e
            //     Mail::send('exception_notif',['e'=>$error], function ($m) {

            //         $m->subject("Laravel Error");
            //         $m->from('informatica@saludarica.cl','Errores');
            //         $m->to("antoniovp18@gmail.com", "Webmaster");
            //     });

            // }
        }

    // Pass the error on to continue processing
        return parent::report($exception);
    


    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
         if ($exception instanceof ModelNotFoundException) 
         {
           abort(404);
         }

        return parent::render($request, $exception);
    }
}
