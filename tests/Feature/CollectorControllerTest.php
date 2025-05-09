<?php

use App\Models\Book;
use App\Models\Collector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class CollectorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_most_recent_book(): void
    {
        $collector = Collector::factory()->create();

        // Create most recent books for each category.
        // Specifically leave ONE type blank, to check for null values.  In this case, 'Self-Help'.
        $fictionBook = Book::factory()->create([
            'collector_id' => $collector->id,
            'type' => 'Fiction',
        ]);
        $nonFictionBook = Book::factory()->create([
            'collector_id' => $collector->id,
            'type' => 'Non-Fiction',
        ]);
        $technicalBook = Book::factory()->create([
            'collector_id' => $collector->id,
            'type' => 'Technical',
        ]);

        // Create older books for each category that should NOT be found.
        Book::factory()->create([
            'collector_id' => $collector->id,
            'type' => 'Fiction',
            'created_at' => '2025-01-01 00:00:00'
        ]);
        Book::factory()->create([
            'collector_id' => $collector->id,
            'type' => 'Non-Fiction',
            'created_at' => '2025-01-01 00:00:00'
        ]);
        Book::factory()->create([
            'collector_id' => $collector->id,
            'type' => 'Technical',
            'created_at' => '2025-01-01 00:00:00'
        ]);

        $route = route(
            'collectors.books.recent',
            [
                $collector,
            ]
        );

        $response = $this->get($route);

        $response->assertStatus(200);

        $summary = $response->json()['summary'];

        $this->assertEquals(
            $fictionBook->title,
            $summary['Fiction']['title']
        );

        $this->assertEquals(
            $nonFictionBook->title,
            $summary['Non-Fiction']['title']
        );

        $this->assertEquals(
            $technicalBook->title,
            $summary['Technical']['title']
        );

        $this->assertNull($summary['Self-Help']);
    }
}
