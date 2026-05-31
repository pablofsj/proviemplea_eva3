<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    public function empresas()
{
    return $this->hasMany(EmpresaCandidato::class);
}
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'edad',
        'genero',
        'comuna_residencia',
        'nivel_educacional',
        'experiencia_laboral',
        'habilidades',
        'certificaciones',
        'referencias',
        'estado'
    ];

    protected $hidden = [
        'nombre',
        'email',
        'telefono',
        'edad',
        'genero',
        'comuna_residencia'
    ];
}
