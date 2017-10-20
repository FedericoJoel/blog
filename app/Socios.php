<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Socios extends Model
{
 	use SoftDeletes;
 	protected $table = 'socios';
	
    protected $fillable = [
        'nombre', 'apellido', 'fecha_nacimiento', 'cuit', 'dni', 'domicilio', 'localidad', 'codigo_postal', 'telefono', 'id_organismo', 'legajo', 'fecha_ingreso', 'sexo', 'id_cuota'];

    protected $dates = ['deleted_at'];

    public function organismo()
    {
    	return $this->belongsTo('App\Organismos', 'id_organismo', 'id')->withTrashed();
    }

    public function ventas()
    {
    	return $this->hasMany('App\Ventas', 'id_asociado', 'id');
    }

    public function cuotasSociales()
    {
        return $this->morphMany(Cuotas::class, 'cuotable');
    }

    public function cuotaSocial()
    {
        return $this->belongsTo('App\CategoriaCuotaSocial', 'id_cuota', 'id');
    }
}
