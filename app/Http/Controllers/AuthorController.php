<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="BookTrack API",
 *     version="1.0.0",
 *     description="Documentação da API",
 *     @OA\Contact(
 *         email="elessandrodev@gmail.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/autores",
     *     summary="Listar todos os autores",
     *     tags={"Autores"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de autores"
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'data' => AuthorResource::collection(Author::paginate(10)),
            'message' => 'Autores recuperados com sucesso'
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/autores",
     *     summary="Cadastrar novo autor",
     *     tags={"Autores"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="James Howlett")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Autor criado com sucesso"
     *     )
     * )
     */
    public function store(StoreAuthorRequest $request): JsonResponse
    {
        $author = Author::create($request->validated());

        return response()->json([
            'data' => new AuthorResource($author),
            'message' => 'Autor criado com sucesso'
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/autores/{id}",
     *     summary="Exibir autor específico",
     *     tags={"Autores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do autor"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Autor não encontrado"
     *     )
     * )
     */
    public function show(Author $author): JsonResponse
    {
        return response()->json([
            'data' => new AuthorResource($author),
            'message' => 'Autor recuperado com sucesso'
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/autores/{id}",
     *     summary="Atualizar autor",
     *     tags={"Autores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="J. K. Rowling")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Autor atualizado com sucesso"
     *     )
     * )
     */
    public function update(UpdateAuthorRequest $request, Author $author): JsonResponse
    {
        $author->update($request->validated());
        
        return response()->json([
            'data' => new AuthorResource($author),
            'message' => 'Autor atualizado com sucesso'
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/autores/{id}",
     *     summary="Excluir autor",
     *     tags={"Autores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Autor excluído com sucesso"
     *     )
     * )
     */
    public function destroy(Author $author): JsonResponse
    {
        $author->delete();
        
        return response()->json(null, 204);
    }
}
