<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('officer.book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BookCategory::all();
        return view('officer.book.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'title' => 'required',
            'book_code' => 'required|unique:books,book_code',
            'year' => 'required',
        ]);

        if($validators->fails()){
            return redirect()->back();
        }

        $image = $request->file('image');
        $image->storeAs('public/books', $image->hashName());

        Book::create([
            'title' => $request->title,
            'year' => $request->year,
            'image' => $image->hashName(),
            'book_category_id' => $request->book_category_id,
            'author' => $request->author,
            'book_code' => $request->book_code,
            'stock' => $request->stock
        ]);

        return redirect()->route('officer.books.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = BookCategory::all();
        return view('officer.book.edit', compact('categories', 'book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validators = Validator::make($request->all(), [
            'title' => 'required',
            'book_code' => 'required|unique:books,book_code',
            'year' => 'required',
        ]);

        if($validators->fails()){
            return redirect()->back();
        }

        $book = Book::findOrFail($id);

        if($request->hasFile('image')){

            $image = $request->file('image');
            $image->storeAs('public/books', $image->hashName());

            Storage::delete('public/books/'.$book->image);

            $book->update([
                'title' => $request->title,
                'year' => $request->year,
                'image' => $image->hashName(),
                'book_category_id' => $request->book_category_id,
                'author' => $request->author,
                'book_code' => $request->book_code,
                'stock' => $request->stock
            ]);
        }else{
            $book->update([
                'title' => $request->title,
                'year' => $request->year,
                'book_category_id' => $request->book_category_id,
                'author' => $request->author,
                'book_code' => $request->book_code,
                'stock' => $request->stock
            ]);
        }

        return redirect()->route('officer.books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        Book::find($id)->delete();
        return redirect()->back();
    }
}
