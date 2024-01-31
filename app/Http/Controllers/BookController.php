<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //
    public function welcome(){
        return view('welcome');
    }

    public function index(Request $request){

        if($request->has('search')){

            $books = Book::where('title','like','%'.$request->search.'%')
            ->orWhere('author','like','%'.$request->search.'%')
            ->paginate(10);

        }

        else{
            //fetch books data from book table 
            $books = Book::paginate(10);
        }

       
    
        //pass books data to view
        return view('books.index')
        ->with('books',$books)
        ->with('name','israil');
    }

    public function show ($book_id){
        $book = Book::find($book_id);
        return view('books.show')
        ->with('book',$book)
        ->with('name','israil');
    }

    public function create(){
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required|max:255',
            'isbn'   => 'required|max:12',
            'author' => 'required|max:255',
            'price'  => 'required|numeric',
            'stock'  => 'required|numeric|integer',
        ]);

        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->isbn = $request->isbn;
        $book->price = $request->price; 
        $book->stock = $request->stock;
        $book->save();
        
        return redirect()->route('book.show',$book->id);
    }

    public function edit($bookId)
    {
        $book = Book::find($bookId);

        return view('books.edit')
        ->with('book',$book);
    }

    public function update(Request $request)
    {

        $request->validate([
            'title'  => 'required|max:255',
            'isbn'   => 'required|max:12',
            'author' => 'required|max:255',
            'price'  => 'required|numeric',
            'stock'  => 'required|numeric|integer',
        ]);

        $book = Book::find($request->id);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->isbn = $request->isbn;
        $book->price = $request->price; 
        $book->stock = $request->stock;
        $book->save();
        

         return redirect()->route('book.show',$book->id);
    }


    public function destroy(Request $request)
    {

       
        $book = Book::find($request->id);
        
        $book->delete();

        return redirect()->route('books.index');
    }



}
