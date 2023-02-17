<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viaticos extends Model 
{   
	protected $connection = 'viaticos';
    protected $table = 'viatico';
	public $timestamps = false;
}
