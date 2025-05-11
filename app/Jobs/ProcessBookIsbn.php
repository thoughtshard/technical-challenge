<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Client\IsbnClient;
use App\Models\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

final class ProcessBookIsbn implements ShouldQueue
{
    use Queueable;

    private ?Book $book;

    /**
     * Create a new job instance.
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = Auth::getUser();

        // Assumption: In a real use case, a separate password would be stored or a token created.
        $isbnClient = new IsbnClient(
            username: $user->email,
            password: $user->password
        );

        $ramseyUuid = Uuid::fromString($this->book->uuid);

        $isbn = $isbnClient->get($ramseyUuid);

        $this->book->update([
            'isbn' => $isbn
        ]);

        // If this failed, it should inform someone.  A Slack callout, an email, something.
    }
}
