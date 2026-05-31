<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CandidatoPublico',
    title: 'Candidato público',
    description: 'Respuesta pública del candidato usando CV ciego. No incluye nombre, email, teléfono, edad, género ni comuna.',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'nivel_educacional', type: 'string', example: 'Técnico Nivel Superior'),
        new OA\Property(property: 'experiencia_laboral', type: 'string', example: '3 años en soporte técnico'),
        new OA\Property(property: 'habilidades', type: 'string', example: 'PHP, Laravel, MySQL'),
        new OA\Property(property: 'certificaciones', type: 'string', example: 'Certificación Desarrollo Backend'),
        new OA\Property(property: 'referencias', type: 'string', example: 'Referencia laboral disponible'),
        new OA\Property(property: 'estado', type: 'boolean', example: true),
    ]
)]
#[OA\Schema(
    schema: 'CandidatoRequest',
    title: 'Crear candidato',
    required: ['nombre', 'email', 'nivel_educacional', 'experiencia_laboral', 'habilidades'],
    properties: [
        new OA\Property(property: 'nombre', type: 'string', example: 'Juan Pérez'),
        new OA\Property(property: 'email', type: 'string', example: 'juan@test.cl'),
        new OA\Property(property: 'telefono', type: 'string', example: '+56911111111'),
        new OA\Property(property: 'edad', type: 'integer', example: 28),
        new OA\Property(property: 'genero', type: 'string', example: 'Masculino'),
        new OA\Property(property: 'comuna_residencia', type: 'string', example: 'Providencia'),
        new OA\Property(property: 'nivel_educacional', type: 'string', example: 'Universitario completo'),
        new OA\Property(property: 'experiencia_laboral', type: 'string', example: '3 años como desarrollador backend'),
        new OA\Property(property: 'habilidades', type: 'string', example: 'PHP, Laravel, MySQL'),
        new OA\Property(property: 'certificaciones', type: 'string', example: 'AWS Practitioner'),
        new OA\Property(property: 'referencias', type: 'string', example: 'Empresa ABC'),
    ]
)]
#[OA\Schema(
    schema: 'Empresa',
    title: 'Empresa',
    required: ['rut_empresa', 'nombre_empresa', 'rubro', 'email_contacto'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'rut_empresa', type: 'string', example: '76.123.456-7'),
        new OA\Property(property: 'nombre_empresa', type: 'string', example: 'Tech Solutions'),
        new OA\Property(property: 'rubro', type: 'string', example: 'Tecnología'),
        new OA\Property(property: 'email_contacto', type: 'string', example: 'rrhh@techsolutions.cl'),
        new OA\Property(property: 'telefono', type: 'string', example: '+56222222222'),
        new OA\Property(property: 'beneficios', type: 'string', example: 'Seguro complementario, trabajo remoto'),
        new OA\Property(property: 'estado', type: 'boolean', example: true),
    ]
)]
#[OA\Schema(
    schema: 'EmpresaCandidato',
    title: 'Empresa Candidato',
    required: ['empresa_id', 'candidato_id', 'cargo_buscado'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'empresa_id', type: 'integer', example: 1),
        new OA\Property(property: 'candidato_id', type: 'integer', example: 1),
        new OA\Property(property: 'cargo_buscado', type: 'string', example: 'Backend Developer'),
        new OA\Property(property: 'estado_proceso', type: 'string', example: 'Pendiente'),
        new OA\Property(property: 'observacion', type: 'string', example: 'Perfil interesante para entrevista'),
    ]
)]
class OpenApiSchemas
{
}
