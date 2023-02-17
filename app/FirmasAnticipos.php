<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FirmasAnticipos extends Model
{
    protected $connection = 'Fondos_Fijos';
    protected $table = 'firma_anticipos';
	const CREATED_AT = 'fecha';
	const UPDATED_AT = 'updated_at';
}
