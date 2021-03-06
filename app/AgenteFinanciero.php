<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgenteFinanciero extends Model
{
    use SoftDeletes;
    protected $table = 'agentes_financieros';

    protected $fillable = [
    ];

    protected $dates = ['deleted_at'];

    public function solicitudes()
    {
        return $this->hasMany('App\Solicitud', 'agente_financiero', 'id');
    }
}
