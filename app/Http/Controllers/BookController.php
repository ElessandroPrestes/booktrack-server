<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Books",
 *     description="Gerenciamento de livros"
 * )
 */

class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/books",
     *     summary="Listar todos os livros",
     *     tags={"Books"},
     *     @OA\Response(response=200, description="Lista de livros")
     * )
     */
    public function index()
    {
        return response()->json([
            'data' => BookResource::collection(Book::query()->with(['authors', 'subjects'])->paginate(10)),
            'message' => 'Livros recuperados com sucesso'
        ], 200);
    }

     /**
     * @OA\Post(
     *     path="/api/books",
     *     summary="Cadastrar novo livro",
     *     tags={"Books"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "publication_year", "author_ids", "subject_ids"},
     *             @OA\Property(property="title", type="string", example="Clean Architecture"),
     *             @OA\Property(property="publisher", type="string", example="Addison-Wesley"),
     *             @OA\Property(property="edition", type="string", example="2ª"),
     *             @OA\Property(property="publication_year", type="integer", example=2022),
     *             @OA\Property(property="author_ids", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="subject_ids", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(response=201, description="Livro criado com sucesso")
     * )
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());
        $book->authors()->sync($request->author_ids);
        $book->subjects()->sync($request->subject_ids);

        return response()->json([
            'data' => new BookResource($book->load(['authors', 'subjects'])),
            'message' => 'Livro criado com sucesso'
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     summary="Exibir livro específico",
     *     tags={"Books"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Livro encontrado"),
     *     @OA\Response(response=404, description="Livro não encontrado")
     * )
     */
    public function show(Book $book): JsonResponse
    {
        return response()->json([
            'data' => new BookResource($book->load(['authors', 'subjects'])),
            'message' => 'Livro recuperado com sucesso'
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     summary="Atualizar livro",
     *     tags={"Books"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreBookRequest")
     *     ),
     *     @OA\Response(response=200, description="Livro atualizado com sucesso")
     * )
     */
    public function update(StoreBookRequest $request, Book $book): JsonResponse
    {
       
        $book->update($request->validated());
        $book->authors()->sync($request->author_ids);
        $book->subjects()->sync($request->subject_ids);

        return response()->json([
            'data' => new BookResource($book->load(['authors', 'subjects'])),
            'message' => 'Livro atualizado com sucesso'
        ], 200);
    }

   /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     summary="Excluir livro",
     *     tags={"Books"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Livro excluído com sucesso")
     * )
     */
    public function destroy(Book $book): JsonResponse
    {      
        $book->delete();
        return response()->json(null, 204);
    }
}
