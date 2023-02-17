<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaAnticipos extends Model
{
    protected $connection = 'Fondos_Fijos';
    protected $table = 'personas_anticipos';

    protected $fillable = [
		'id',
		'nombre',		
		'run',
		'fiador',
		'estado',
		'anticipo'
		
	];
    const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';

}
