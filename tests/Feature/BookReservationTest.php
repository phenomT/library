<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

         /** @test */

    public function a_book_can_be_added_to_the_library() {


        $response = $this->post('api/books',$this->data());

        $book = Book::first();


        $this->assertCount(1, Book::all());

        $response->assertRedirect('api/books/'.$book->id);
    }


     /** @test */

    public function a_title_is_required() {


        $response = $this->post('api/books',[
            'title' => '',
            'author_id' => 'temitope'
        ]);
        $response->assertSessionHasErrors('title');

    }


      /** @test */

      public function an_author_is_required() {


        $response = $this->post('api/books', array_merge($this->data(), ['author_id' => '']));
        $response->assertSessionHasErrors('author_id');

    }



      /** @test */

    public function a_book_can_be_updated() {

        $this->withoutExceptionHandling();

        $this->post('api/books', $this->data());

        $book = Book::first();

        $response = $this->patch('api/books/'.$book->id, [
            'title' => 'Test Driven Book',
            'author_id' => 'sodiq'
        ]);

        $this->assertEquals('Test Driven Book', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);

        $response->assertRedirect('api/books/'.$book->id);

    }


     /** @test */

    public function a_book_can_be_deleted() {

        $this->withoutExceptionHandling();


        $this->post('api/books',$this->data());

        $book = Book::first();

        $this->assertCount(1,Book::all());

        $response = $this->delete('api/books/'.$book->id);
        $this->assertCount(0,Book::all());
        $response->assertRedirect('api/books');

    }


    /** @test */

    public function an_author_can_be_automatically_updated() {

        $this->withoutExceptionHandling();

        $this->post('api/books',[
            'title' => 'Laravel for beginners',
            'author_id' => '1'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id,$book->author_id);
        $this->assertCount(1,Author::all());
    }


    private function data() {
        return [
            'title' => 'Laravel for beginners',
            'author_id' => 'temitope'
        ];
    }
}
