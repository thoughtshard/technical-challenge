<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Collector;
use App\Services\BookCollectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class GetCollectorSummaryController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Collector $collector): JsonResponse
    {
        $bookCollectionService = new BookCollectionService();

        $bookCollectionService->mostRecent($collector, 'Technical');
        return new JsonResponse(
            [
                'summary' => [
                    'Fiction' => $bookCollectionService->mostRecent($collector, 'Fiction'),
                    'Non-Fiction' => $bookCollectionService->mostRecent($collector, 'Non-Fiction'),
                    'Technical' => $bookCollectionService->mostRecent($collector, 'Technical'),
                    'Self-Help' => $bookCollectionService->mostRecent($collector, 'Self-Help'),
                ]
            ],
        200
        );
    }
}
