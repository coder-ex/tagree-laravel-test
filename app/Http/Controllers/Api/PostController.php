<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $service)
    {
    }

    /**
     * список всех постов
     */
    public function getAll()
    {
        return response(['success' => true, 'authors' => $this->service->listPosts()]);
    }

    /**
     * новость детальная (имя, новости с пагинацией)
     */
    public function show($slug)
    {
        try {
            if (!$slug) {
                throw new Exception('slug не указан');
            }

            $post = $this->service->detailsPost($slug);

            return response()->json([
                'success' => true,
                'post'    => $post,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * обновить новость
     */
    public function update()
    {
        return response(['success' => true, 'message' => 'логика не реализована, т.к. по ТЗ не предусмотрено']);
    }

    /**
     * удалить новость
     */
    public function delete()
    {
        return response(['success' => true, 'message' => 'логика не реализована, т.к. по ТЗ не предусмотрено']);
    }

    /**
     * создать новость
     */
    public function create(StorePostRequest $request)
    {
        try {
            if ($validated = $request->validated() /*$request->safe()->only(['name'])*/) {
                return response()->json([
                    'success' => true,
                    'data'    => $this->service->createPost($validated['title'], $validated['description'], $validated['name']),
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode());
        }
    }
}
