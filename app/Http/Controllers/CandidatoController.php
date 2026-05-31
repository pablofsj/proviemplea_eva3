<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CandidatoController extends Controller
{
    #[OA\Get(
    path: '/candidatos',
    summary: 'Listar candidatos',
    description: 'Obtiene todos los candidatos usando CV ciego. No retorna nombre, email, teléfono, edad, género ni comuna.',
    tags: ['Candidatos'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Lista de candidatos obtenida correctamente',
            content: new OA\JsonContent(
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/CandidatoPublico')
            )
        ),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function index()
    {
        return response()->json(Candidato::all(), 200);
    }
    #[OA\Post(
    path: '/candidatos',
    summary: 'Crear candidato',
    description: 'Crea un candidato guardando datos privados, pero las respuestas mantienen el formato de CV ciego.',
    tags: ['Candidatos'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/CandidatoRequest')
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: 'Candidato creado correctamente',
            content: new OA\JsonContent(ref: '#/components/schemas/CandidatoPublico')
        ),
        new OA\Response(response: 422, description: 'Error de validación'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email|unique:candidatos,email',
            'telefono' => 'nullable|string',
            'edad' => 'nullable|integer',
            'genero' => 'nullable|string',
            'comuna_residencia' => 'nullable|string',
            'nivel_educacional' => 'required|string',
            'experiencia_laboral' => 'required|string',
            'habilidades' => 'required|string',
            'certificaciones' => 'nullable|string',
            'referencias' => 'nullable|string',
        ]);

        $candidato = Candidato::create($data);

        return response()->json($candidato, 201);
    }

    #[OA\Get(
    path: '/candidatos/{id}',
    summary: 'Obtener candidato por ID',
    description: 'Obtiene un candidato específico mediante CV ciego.',
    tags: ['Candidatos'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID del candidato',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Candidato encontrado',
            content: new OA\JsonContent(ref: '#/components/schemas/CandidatoPublico')
        ),
        new OA\Response(response: 404, description: 'Candidato no encontrado'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function show($id)
    {
        $candidato = Candidato::find($id);

        if (!$candidato) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        return response()->json($candidato, 200);
    }
    #[OA\Put(
    path: '/candidatos/{id}',
    summary: 'Actualizar candidato',
    description: 'Actualiza los datos de un candidato. La respuesta mantiene el CV ciego.',
    tags: ['Candidatos'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID del candidato',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/CandidatoRequest')
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: 'Candidato actualizado correctamente',
            content: new OA\JsonContent(ref: '#/components/schemas/CandidatoPublico')
        ),
        new OA\Response(response: 404, description: 'Candidato no encontrado'),
        new OA\Response(response: 422, description: 'Error de validación'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function update(Request $request, $id)
    {
        $candidato = Candidato::find($id);

        if (!$candidato) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        $data = $request->validate([
            'nombre' => 'sometimes|string',
            'email' => 'sometimes|email|unique:candidatos,email,' . $id,
            'telefono' => 'nullable|string',
            'edad' => 'nullable|integer',
            'genero' => 'nullable|string',
            'comuna_residencia' => 'nullable|string',
            'nivel_educacional' => 'sometimes|string',
            'experiencia_laboral' => 'sometimes|string',
            'habilidades' => 'sometimes|string',
            'certificaciones' => 'nullable|string',
            'referencias' => 'nullable|string',
        ]);

        $candidato->update($data);

        return response()->json($candidato, 200);
    }
    #[OA\Patch(
    path: '/candidatos/{id}/estado',
    summary: 'Activar o desactivar candidato',
    description: 'Permite encender o apagar el estado del candidato.',
    tags: ['Candidatos'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID del candidato',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['estado'],
            properties: [
                new OA\Property(property: 'estado', type: 'boolean', example: true)
            ]
        )
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: 'Estado actualizado correctamente',
            content: new OA\JsonContent(ref: '#/components/schemas/CandidatoPublico')
        ),
        new OA\Response(response: 404, description: 'Candidato no encontrado'),
        new OA\Response(response: 422, description: 'Error de validación')
    ]
)]
    public function cambiarEstado(Request $request, $id)
    {
        $candidato = Candidato::find($id);

        if (!$candidato) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        $data = $request->validate([
            'estado' => 'required|boolean'
        ]);

        $candidato->estado = $data['estado'];
        $candidato->save();

        return response()->json($candidato, 200);
    }
    #[OA\Delete(
    path: '/candidatos/{id}',
    summary: 'Eliminar candidato',
    description: 'Elimina un candidato por ID.',
    tags: ['Candidatos'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID del candidato',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Candidato eliminado correctamente'),
        new OA\Response(response: 404, description: 'Candidato no encontrado'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function destroy($id)
    {
        $candidato = Candidato::find($id);

        if (!$candidato) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        $candidato->delete();

        return response()->json(['message' => 'Candidato eliminado correctamente'], 200);
    }
}
