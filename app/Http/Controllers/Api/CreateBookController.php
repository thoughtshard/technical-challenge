<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateBookRequest;
use App\Jobs\ProcessBookIsbn;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

final class CreateBookController
{
    /**
     * @param CreateBookRequest $request
     * @return JsonResponse
     */
    public function __invoke(CreateBookRequest $request): JsonResponse
    {
        $params = $request->validated();

        $book = Book::create([
            'uuid' => $params['uuid'],
            'title' => $params['title'],
            'type' => $params['type'],
            'collector_id' => $params['collector_id'],
        ]);

        ProcessBookIsbn::dispatch($book);

        return new JsonResponse(
            [
                'book' => $book,
            ],
            200
        );
    }
}
