<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Services\AuthorService;
use Exception;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function __construct(private AuthorService $service)
    {
    }

    /**
     * список всех авторов
     */
    public function getAll()
    {
        return response(['success' => true, 'authors' => $this->service->listAuthor()]);
    }

    /**
     * автор детальная (имя, новости с пагинацией)
     */
    public function show($slug)
    {
        try {
            if (!$slug) {
                throw new Exception('slug не указан');
            }

            $author = $this->service->detailsAuthor($slug);

            return response()->json([
                'success' => true,
                'author' => $author,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * обновить данные автора
     */
    public function update()
    {
        return response(['success' => true, 'message' => 'логика не реализована, т.к. по ТЗ не предусмотрено']);
    }

    /**
     * удалить автора
     */
    public function delete()
    {
        return response(['success' => true, 'message' => 'логика не реализована, т.к. по ТЗ не предусмотрено']);
    }

    /**
     * создать автора
     */
    public function create(StoreAuthorRequest $request)
    {
        try {
            if ($validated = $request->validated() /*$request->safe()->only(['name'])*/) {
                return response()->json([
                    'success' => true,
                    'data'    => $this->service->createAuthor($validated['name'])
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode());
        }
    }
}
