<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

         /** @test */

    public function a_book_can_be_added_to_the_library() {

        $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title' => 'Laravel for beginners',
            'author' => 'temitope'
        ]);
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }


     /** @test */

    public function a_title_is_required() {


        $response = $this->post('/books',[
            'title' => '',
            'author' => 'temitope'
        ]);
        $response->assertSessionHasErrors('title');

    }


      /** @test */

      public function an_author_is_required() {


        $response = $this->post('/books',[
            'title' => 'Laravel for beginners',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');

    }



      /** @test */

      public function a_book_can_be_updated() {

        $this->withoutExceptionHandling();

         $this->post('/books',[
            'title' => 'Laravel for beginners',
            'author' => 'temitope'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
            'title' => 'Test Driven Book',
            'author' => 'sodiq'
        ]);

        $this->assertEquals('Test Driven Book', Book::first()->title);
        $this->assertEquals('sodiq', Book::first()->author);

    }
}
