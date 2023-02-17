<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjuntosProductos extends Model
{
	protected $connection = 'mysql';
	protected $table = 'adjuntos_cpp';
	protected $fillable = [
		'adj_id',
		'adj_adjuntado',
		'adj_nombre',
		'adj_fecha',
		'adj_id_cpp',
		'adj_nombre_subio'

	];
	public $timestamps = false;

}
