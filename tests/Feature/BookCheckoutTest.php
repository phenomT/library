<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory as factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Traits\ReflectsClosures;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_book_can_be_checked_out()
    {
        factory(Book::class)->create();

    }
}
