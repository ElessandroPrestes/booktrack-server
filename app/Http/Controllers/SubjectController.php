<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Assuntos",
 *     description="Gerenciamento de assuntos"
 * )
 */

class SubjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/assuntos",
     *     summary="Listar todos os assuntos",
     *     tags={"Assuntos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de assuntos"
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'data' => SubjectResource::collection(Subject::paginate(10)),
            'message' => 'Assuntos recuperados com sucesso'
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/assuntos",
     *     summary="Cadastrar novo assunto",
     *     tags={"Assuntos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="Literatura"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Assunto criado com sucesso"
     *     )
     * )
     */
    public function store(StoreSubjectRequest $request): JsonResponse
    {
        $subject = Subject::create($request->validated());
        return response()->json([
            'data' => new SubjectResource($subject),
            'message' => 'Assunto criado com sucesso'
        ], 201);
        
    }

    /**
     * @OA\Get(
     *     path="/api/assuntos/{id}",
     *     summary="Exibir assunto específico",
     *     tags={"Assuntos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do assunto"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Assunto não encontrado"
     *     )
     * )
     */
    public function show(Subject $subject): JsonResponse
    {

        return response()->json([
            'data' => new SubjectResource($subject),
            'message' => 'Assunto recuperado com sucesso'
        ], 200);
    }
    
    /**
     * @OA\Put(
     *     path="/api/assuntos/{id}",
     *     summary="Atualizar assunto",
     *     tags={"Assuntos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="Literatura")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assunto atualizado com sucesso"
     *     )
     * )
     */
    public function update(UpdateSubjectRequest $request, Subject $subject): JsonResponse
    {
        $subject->update($request->validated());

        return response()->json([
            'data' => new SubjectResource($subject),
            'message' => 'Assunto atualizado com sucesso'
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/assuntos/{id}",
     *     summary="Excluir assunto",
     *     tags={"Assuntos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Assunto excluído com sucesso"
     *     )
     * )
     */
    public function destroy(Subject $subject): JsonResponse
    {
        $subject->delete();
        return response()->json(null, 204);
    }
}
