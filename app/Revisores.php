<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revisores extends Model
{
   protected $connection = 'ssalud';
	protected $table = 'persona';
}
