<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_Errores extends Model
{
    protected $connection = 'log_errores';
    protected $table = 'errores';
    protected $fillable = [
     'id',
     'file',
     'code',
     'line',
     'message',
     'trace',
     'sistema'

     ];
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
}
