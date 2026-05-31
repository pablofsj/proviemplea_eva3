<?php

namespace App\Http\Controllers;

use App\Models\EmpresaCandidato;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class EmpresaCandidatoController extends Controller
{
    #[OA\Get(
    path: '/empresa-candidatos',
    summary: 'Listar relaciones empresa-candidato',
    description: 'Obtiene todas las relaciones entre empresas y candidatos.',
    tags: ['Empresa-Candidatos'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Lista de relaciones obtenida correctamente',
            content: new OA\JsonContent(
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/EmpresaCandidato')
            )
        ),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function index()
    {
        return response()->json(EmpresaCandidato::with(['empresa', 'candidato'])->get(), 200);
    }
    #[OA\Post(
    path: '/empresa-candidatos',
    summary: 'Crear relación empresa-candidato',
    description: 'Registra que una empresa está interesada en un candidato para un cargo específico.',
    tags: ['Empresa-Candidatos'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/EmpresaCandidato')
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: 'Relación creada correctamente',
            content: new OA\JsonContent(ref: '#/components/schemas/EmpresaCandidato')
        ),
        new OA\Response(response: 422, description: 'Error de validación'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'candidato_id' => 'required|exists:candidatos,id',
            'cargo_buscado' => 'required|string',
            'estado_proceso' => 'nullable|string',
            'observacion' => 'nullable|string',
        ]);

        $relacion = EmpresaCandidato::create($data);

        return response()->json($relacion, 201);
    }
    #[OA\Get(
    path: '/empresa-candidatos/{id}',
    summary: 'Obtener relación por ID',
    description: 'Obtiene una relación específica entre empresa y candidato.',
    tags: ['Empresa-Candidatos'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID de la relación',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Relación encontrada',
            content: new OA\JsonContent(ref: '#/components/schemas/EmpresaCandidato')
        ),
        new OA\Response(response: 404, description: 'Relación no encontrada'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function show($id)
    {
        $relacion = EmpresaCandidato::with(['empresa', 'candidato'])->find($id);

        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }

        return response()->json($relacion, 200);
    }
    #[OA\Put(
    path: '/empresa-candidatos/{id}',
    summary: 'Actualizar relación empresa-candidato',
    description: 'Actualiza el cargo buscado, estado del proceso u observación de la relación.',
    tags: ['Empresa-Candidatos'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID de la relación',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/EmpresaCandidato')
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: 'Relación actualizada correctamente',
            content: new OA\JsonContent(ref: '#/components/schemas/EmpresaCandidato')
        ),
        new OA\Response(response: 404, description: 'Relación no encontrada'),
        new OA\Response(response: 422, description: 'Error de validación'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function update(Request $request, $id)
    {
        $relacion = EmpresaCandidato::find($id);

        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }

        $data = $request->validate([
            'empresa_id' => 'sometimes|exists:empresas,id',
            'candidato_id' => 'sometimes|exists:candidatos,id',
            'cargo_buscado' => 'sometimes|string',
            'estado_proceso' => 'nullable|string',
            'observacion' => 'nullable|string',
        ]);

        $relacion->update($data);

        return response()->json($relacion, 200);
    }
    #[OA\Delete(
    path: '/empresa-candidatos/{id}',
    summary: 'Eliminar relación empresa-candidato',
    description: 'Elimina una relación entre empresa y candidato.',
    tags: ['Empresa-Candidatos'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID de la relación',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Relación eliminada correctamente'),
        new OA\Response(response: 404, description: 'Relación no encontrada'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function destroy($id)
    {
        $relacion = EmpresaCandidato::find($id);

        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }

        $relacion->delete();

        return response()->json(['message' => 'Relación eliminada correctamente'], 200);
    }
}
