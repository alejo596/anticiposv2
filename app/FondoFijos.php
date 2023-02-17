<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FondoFijos extends Model
{
    protected $connection = 'Fondos_Fijos';
    protected $table = 'solicitudes';
	public $timestamps = false;
}
