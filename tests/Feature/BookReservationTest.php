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


        $response = $this->post('api/books',[
            'title' => 'Laravel for beginners',
            'author' => 'temitope'
        ]);

        $book = Book::first();


        $this->assertCount(1, Book::all());

        $response->assertRedirect('api/books/'.$book->id);
    }


     /** @test */

    public function a_title_is_required() {


        $response = $this->post('api/books',[
            'title' => '',
            'author' => 'temitope'
        ]);
        $response->assertSessionHasErrors('title');

    }


      /** @test */

      public function an_author_is_required() {


        $response = $this->post('api/books',[
            'title' => 'Laravel for beginners',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');

    }



      /** @test */

    public function a_book_can_be_updated() {

        $this->withoutExceptionHandling();

        $this->post('api/books',[
            'title' => 'Laravel for beginners',
            'author' => 'temitope'
        ]);

        $book = Book::first();

        $response = $this->patch('api/books/'.$book->id, [
            'title' => 'Test Driven Book',
            'author' => 'sodiq'
        ]);

        $this->assertEquals('Test Driven Book', Book::first()->title);
        $this->assertEquals('sodiq', Book::first()->author);

        $response->assertRedirect('api/books/'.$book->id);

    }


     /** @test */

    public function a_book_can_be_deleted() {

        $this->withoutExceptionHandling();


        $this->post('api/books',[
            'title' => 'Laravel for beginners',
            'author' => 'temitope'
        ]);

        $book = Book::first();

        $this->assertCount(1,Book::all());

        $response = $this->delete('api/books/'.$book->id);
        $this->assertCount(0,Book::all());
        $response->assertRedirect('api/books');

    }
}
