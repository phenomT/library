<?php

namespace App\Http\Controllers;
use App\Models\Book;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store() {

        $data = $this->validateRequest();

        $book = Book::create($data);

        return redirect($book->path());

    }

    public function update(Book $book) {
        $data = $this->validateRequest();
        $book->update($data);

        return redirect($book->path());
    }

    public function destroy(Book $book) {
        $book->delete();

        return redirect('api/books');
    }

    protected function validateRequest() {
        return request()->validate([
            'title' => 'required',
            'author_id' => 'required',
        ]);
    }
}
