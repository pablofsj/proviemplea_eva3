<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    public function candidatos()
{
    return $this->hasMany(EmpresaCandidato::class);
}
    protected $fillable = [
        'rut_empresa',
        'nombre_empresa',
        'rubro',
        'email_contacto',
        'telefono',
        'beneficios',
        'estado'
    ];
}
