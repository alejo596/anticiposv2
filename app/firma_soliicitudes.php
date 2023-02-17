<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class firma_soliicitudes extends Model
{
    protected $connection = 'Fondos_Fijos';
    protected $table = 'firma_solicitudes';
	const CREATED_AT = 'fecha';
	const UPDATED_AT = 'updated_at';

}
