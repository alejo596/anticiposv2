<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fiadores extends Model
{
    protected $connection = 'Fondos_Fijos';
    protected $table = 'fiadores';
	protected $fillable = [
		'id',
		'run',		
		'nombre',
		'centro_costo',
		'cc_extra_pre',
		'acto_admin',
		'id_proveedor'
		
	];
		const CREATED_AT = 'created_at';
		const UPDATED_AT = 'updated_at';
}
