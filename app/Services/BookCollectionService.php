<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use App\Models\Collector;

final class BookCollectionService
{
    /**
     * @param Collector $collector
     * @param string $type
     * @return Book|null
     */
    public function mostRecent(Collector $collector, string $type): ?Book
    {
        $latestBook = $collector
            ->books()
            ->where('type', $type)
            ->orderBy('created_at', 'desc')
            ->first();

        return $latestBook;
    }
}
