<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\JsonResponse;

final class GetBookController
{
    /**
     * @param string $uuid
     * @return JsonResponse
     */
    public function __invoke(string $uuid): JsonResponse
    {
        $book = Book::where('uuid', $uuid)->first();

        return new JsonResponse(
            [
                'book' => $book,
            ],
            200
        );
    }
}
