<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaCandidato extends Model
{
    protected $fillable = [
        'empresa_id',
        'candidato_id',
        'cargo_buscado',
        'estado_proceso',
        'observacion'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }
}
