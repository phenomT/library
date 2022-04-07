<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function an_author_can_be_created() {

        $this->withoutExceptionHandling();

        $response = $this->post('api/authors', [
            'name' => 'Ben murray',
            'dob' => '12/12/2001'
        ]);

        $author = Author::all();
        $this->assertCount(1, $author);

        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
    }
}
