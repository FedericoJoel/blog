<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Organismos extends Model
{
    use SoftDeletes;
	
    protected $fillable = [
        'nombre', 'cuit', 'localidad', 'domicilio'
    ];

    protected $dates = ['deleted_at'];

    public function socios()
    {
    	return $this->hasMany('App\Socios', 'id_organismo', 'id');
    }

    public function cuotas()
    {
        return $this->hasMany('App\CategoriaCuotaSocial', 'id_organismo', 'id');
    }
}
