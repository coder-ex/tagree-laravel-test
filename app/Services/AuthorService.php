<?php

namespace App\Services;

use App\Models\Author;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthorService
{
    /**
     * список всех авторов
     */
    public function listAuthor()
    {
        return Author::all()->map(function($item) {
            return (object) [
                'name'  => $item->name,
                'posts' => $item->posts
            ];
        });
    }

    /**
     * создать автора
     */
    public function createAuthor(string $name): mixed
    {
        $slug = \Str::slug($name, '-');

        if ($candidate = Author::where('slug', '=', $slug)->first()) {
            return ['message' => 'автор уже существует', 'author' => $candidate];
        }

        $author = null;
        DB::beginTransaction();
        try {
            $author = Author::create(['name' => $name, 'slug' => $slug]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return ['message' => 'автор создан', 'author' => $author];
    }

    /**
     * автор детально (имя автора, его новости с пагинацией)
     */
    public function detailsAuthor(string $slug)
    {
        if ($author = Author::where('slug', '=', $slug)->first()) {
            return (object)[
                'name'  => $author->name,
                'posts' => $author->posts()->paginate(10)
            ];
        } else {
            throw new Exception('Автор не найден', 404);
        }
    }
}
