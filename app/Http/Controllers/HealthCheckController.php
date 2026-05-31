<?php

namespace App\Http\Controllers;

use App\Models\HealthCheck;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

class HealthCheckController extends Controller
{
    #[OA\Get(
        path: '/health',
        summary: 'Verificar estado de salud de la API',
        description: 'Retorna el estado de la API y la conexión con la base de datos.',
        tags: ['Health'],
        responses: [
            new OA\Response(response: 200, description: 'API funcionando correctamente'),
            new OA\Response(response: 500, description: 'Error de conexión con la base de datos')
        ]
    )]
    public function index()
    {
        // ... tu código sin cambios
    }
}
