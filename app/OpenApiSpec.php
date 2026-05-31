<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API ProviEmplea EVA3',
    description: 'API para gestión de candidatos con CV ciego, empresas, relación empresa-candidato y salud de la API.

**Rate Limiting:** 60 requests/minuto por IP.
**Caché:** Endpoints GET cacheados por 5 minutos.
**Tiempo de respuesta objetivo:** < 200ms.'
)]
#[OA\Server(
    url: 'http://localhost:8000/api',
    description: 'Servidor local Docker'
)]
#[OA\Tag(name: 'Health', description: 'Salud de la API')]
#[OA\Tag(name: 'Candidatos', description: 'CRUD de candidatos con CV ciego')]
#[OA\Tag(name: 'Empresas', description: 'CRUD de empresas')]
#[OA\Tag(name: 'Empresa-Candidatos', description: 'Relación entre empresas y candidatos')]
class OpenApiSpec
{
}
