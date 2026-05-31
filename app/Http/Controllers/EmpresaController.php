<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class EmpresaController extends Controller
{
    #[OA\Get(
    path: '/empresas',
    summary: 'Listar empresas',
    description: 'Obtiene todas las empresas registradas en la plataforma.',
    tags: ['Empresas'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Lista de empresas obtenida correctamente',
            content: new OA\JsonContent(
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/Empresa')
            )
        ),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function index()
    {
        return response()->json(Empresa::all(), 200);
    }
    #[OA\Post(
    path: '/empresas',
    summary: 'Crear empresa',
    description: 'Registra una nueva empresa en la plataforma.',
    tags: ['Empresas'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: 'Empresa creada correctamente',
            content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
        ),
        new OA\Response(response: 422, description: 'Error de validación'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function store(Request $request)
    {
        $data = $request->validate([
            'rut_empresa' => 'required|string|unique:empresas,rut_empresa',
            'nombre_empresa' => 'required|string',
            'rubro' => 'required|string',
            'email_contacto' => 'required|email',
            'telefono' => 'nullable|string',
            'beneficios' => 'nullable|string',
        ]);

        $empresa = Empresa::create($data);

        return response()->json($empresa, 201);
    }
    #[OA\Get(
    path: '/empresas/{id}',
    summary: 'Obtener empresa por ID',
    description: 'Obtiene una empresa específica mediante su ID.',
    tags: ['Empresas'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID de la empresa',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Empresa encontrada',
            content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
        ),
        new OA\Response(response: 404, description: 'Empresa no encontrada'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function show($id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return response()->json($empresa, 200);
    }
    #[OA\Put(
    path: '/empresas/{id}',
    summary: 'Actualizar empresa',
    description: 'Actualiza los datos de una empresa registrada.',
    tags: ['Empresas'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID de la empresa',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: 'Empresa actualizada correctamente',
            content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
        ),
        new OA\Response(response: 404, description: 'Empresa no encontrada'),
        new OA\Response(response: 422, description: 'Error de validación'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function update(Request $request, $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        $data = $request->validate([
            'rut_empresa' => 'sometimes|string|unique:empresas,rut_empresa,' . $id,
            'nombre_empresa' => 'sometimes|string',
            'rubro' => 'sometimes|string',
            'email_contacto' => 'sometimes|email',
            'telefono' => 'nullable|string',
            'beneficios' => 'nullable|string',
        ]);

        $empresa->update($data);

        return response()->json($empresa, 200);
    }
    #[OA\Patch(
    path: '/empresas/{id}/estado',
    summary: 'Activar o desactivar empresa',
    description: 'Permite encender o apagar el estado de una empresa.',
    tags: ['Empresas'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID de la empresa',
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
            content: new OA\JsonContent(ref: '#/components/schemas/Empresa')
        ),
        new OA\Response(response: 404, description: 'Empresa no encontrada'),
        new OA\Response(response: 422, description: 'Error de validación')
    ]
)]
    public function cambiarEstado(Request $request, $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        $data = $request->validate([
            'estado' => 'required|boolean'
        ]);

        $empresa->estado = $data['estado'];
        $empresa->save();

        return response()->json($empresa, 200);
    }
    #[OA\Delete(
    path: '/empresas/{id}',
    summary: 'Eliminar empresa',
    description: 'Elimina una empresa por ID.',
    tags: ['Empresas'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            description: 'ID de la empresa',
            schema: new OA\Schema(type: 'integer')
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Empresa eliminada correctamente'),
        new OA\Response(response: 404, description: 'Empresa no encontrada'),
        new OA\Response(response: 500, description: 'Error interno del servidor')
    ]
)]
    public function destroy($id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        $empresa->delete();

        return response()->json(['message' => 'Empresa eliminada correctamente'], 200);
    }
}
