<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function __construct(private AuthorService $authorService)
    {
    }

    /**
     * список новостей
     */
    public function listPosts()
    {
        return Post::all()->map(function ($item) {
            return (object) [
                'title'       => $item->title,
                'description' => $item->description,
                'author'      => $item->author,
                'published'   => $item->created_at,
            ];
        });
    }


    /**
     * создать новость
     */
    public function createPost(string $title, string $description, string $author_name): mixed
    {
        $slug = \Str::slug($title, '-');

        if ($candidate = Post::where('slug', '=', $slug)->first()) {
            return ['message' => 'пост уже существует', 'post' => $candidate];
        }

        $author = Author::where('name', '=', $author_name)->first();

        //--- если автор не существует, то создадим
        if (!$author) {
            $author = $this->authorService->createAuthor($author_name)['author'];
        }

        $post = new Post([
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
        ]);

        DB::beginTransaction();
        try {
            $author->posts()->save($post);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        //---
        return ['message' => 'пост создан', 'post' => $post];
    }

    /**
     * новость детально
     */
    public function detailsPost(string $slug)
    {
        if ($post = Post::where('slug', '=', $slug)->first()) {
            return (object)[
                'title'       => $post->title,
                'description' => $post->description,
                'author'      => $post->author,
                'published'   => $post->created_at,
            ];
        } else {
            throw new Exception('Новость не найдена', 404);
        }
    }
}
