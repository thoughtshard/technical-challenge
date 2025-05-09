<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Client\IsbnClient;
use App\Http\Requests\CreateBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

final class CreateBookController
{
    /**
     * @param CreateBookRequest $request
     * @return JsonResponse
     */
    public function __invoke(CreateBookRequest $request): JsonResponse
    {
        $user = Auth::getUser();

        $params = $request->validated();

        $uuidString = $params['uuid'] ?? null;

        // Assumption: In a real use case, a separate password would be stored or a token created.
        $isbnClient = new IsbnClient(
            username: $user->email,
            password: $user->password
        );

        $uuid = Uuid::fromString($uuidString);

        $isbn = $isbnClient->get($uuid);

        $book = Book::create([
            'uuid' => $uuidString,
            'title' => $params['title'],
            'type' => $params['type'],
            'isbn' => $isbn,
            'collector_id' => $params['collector_id'],
        ]);

        return new JsonResponse(
            [
                'book' => $book,
            ],
            200
        );
    }
}
