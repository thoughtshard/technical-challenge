<?php

use App\Models\Book;
use App\Models\Collector;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Str;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_book_for_collector(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $collector = Collector::factory()->create();

        $route = route(
            'books.create'
        );

        $bookTitle = 'Book Title';

        // Assumption: Multiple collectors might have the same book and the UUID is used to look up the ISBN,
        // Thus, UUID is not created internally...
        $response = $this->post(
            $route,
            [
                'uuid' => Str::uuid()->toString(),
                'title' => $bookTitle,
                'type' => 'Technical',
                'collector_id' => $collector->id,
            ]
        );

        $response->assertStatus(200);

        $book = $response->json()['book'];
        $this->assertEquals($bookTitle, $book['title']);
    }

    public function test_get_book(): void
    {
        $book = Book::factory()->create();

        $route = route(
            'books.show', [
                'uuid' => $book->uuid,
            ]
        );

        $response = $this->get($route);

        $response->assertStatus(200);

        $returnedBook = $response->json()['book'];
        $this->assertEquals($book->title, $returnedBook['title']);
    }
}
