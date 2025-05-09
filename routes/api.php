<?php

use App\Http\Controllers\Api\CreateBookController;
use App\Http\Controllers\Api\GetBookController;
use App\Http\Controllers\Api\GetCollectorSummaryController;
use Illuminate\Support\Facades\Route;

Route::post('books', CreateBookController::class)
    ->name('books.create');
Route::get('books/{uuid}', GetBookController::class)
    ->name('books.show');
Route::get('collectors/{collector}/recently-added', GetCollectorSummaryController::class)
    ->name('collectors.books.recent');
