<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalGastadoCC extends Model
{
    protected $connection = 'mysql2';
	protected $table = 'gasto_presupuestario';
	public $timestamps = false;
}
