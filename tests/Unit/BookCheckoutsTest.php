<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCheckoutsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_out_a_book()
    {
        $book = Book::factory(Book::class)->create();
        $user = User::factory(User::class)->create();

        $book->checkout($user);

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(),Reservation::first()->checked_out_at);
    }

    /** @test */
    public function return_a_book()
    {
        $book = Book::factory(Book::class)->create();
        $user = User::factory(User::class)->create();

        $book->checkout($user);

        $book->checkin($user);

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNull(Reservation::first()->checked_in);
        $this->assertEquals(now(),Reservation::first()->checked_in);
    }

    /** @test */
    public function a_user_can_check_out_twice ()
    {
        $book = Book::factory(Book::class)->create();
        $user = User::factory(User::class)->create();

        $book->checkout($user);
        $book->checkin($user);

        $book->checkout($user);

        $this->assertCount(2,Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNull(Reservation::find(2)->checked_in);
        $this->assertEquals(now(),Reservation::find(2)->checked_out_at);

        $book->checkin($user);

        $this->assertCount(2,Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNotNull(Reservation::find(2)->checked_in);
        $this->assertEquals(now(),Reservation::find(2)->checked_in);
    }


    /** @test */
    public function if_not_checked_out_exception() {

        $this->expectException(\Exception::class);

        $book = Book::factory(Book::class)->create();
        $user = User::factory(User::class)->create();

        $book->checkin($user);

    }
}
