<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Models\Book;
use App\Models\Bookshelf;
use App\Models\Categorie;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function index(){
        $data['books'] = Book::with('bookshelf')->get();
        $data['books'] = Book::with('categorie')->get();
        return view('books.index', $data);
    }

    public function create(){
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        $data['categories'] = Categorie::pluck('category', 'id');
        return view('books.create', $data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:150',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')),
            'publisher' => 'required|max:100',
            'city' => 'required|max:75',
            'quantity' => 'required|numeric',
            'categorie_id' => 'required',
            'bookshelf_id' => 'required',
            'cover' => 'nullable|image',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->storeAs('public/cover_buku',
            'cover_buku_'.time() . '.' . $request->file('cover')->extension()
        );
        $validated['cover'] = basename($path);
        }

        Book::create($validated);

        $notification = array(
            'message' => 'Data Buku berhasil ditambahkan',
            'alerty-type' => 'succes'
        );

        if ($request->save == true) {
            return redirect()->route('book')->with($notification);
        }
        else{
            return redirect()->route('book.create')->with($notification);
        }
    }

    public function edit(string $id){
        $data['book'] = Book::findOrFail($id);
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        $data['categories'] = Categorie::pluck('category', 'id');
        return view('books.edit')->with($data);
    }

    public function update(Request $request, string $id){
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:150',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')),
            'publisher' => 'required|max:100',
            'city' => 'required|max:75',
            'quantity' => 'required|numeric',
            'categorie_id' => 'required',
            'bookshelf_id' => 'required',
            'cover' => 'nullable|image',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover != null) {
                Storage::delete('public/cover)buku'.$request->old_cover);
            }
            $path = $request->file('cover')->storeAs('public/cover_buku',
            'cover_buku_'.time() . '.' . $request->file('cover')->extension()
        );
        $validated['cover'] = basename($path);
        }

        Book::where('id', $id)->update($validated);

        $notification = array(
            'message' => 'Data Buku berhasil diperbaharui',
            'alerty-type' => 'succes'
        );

        return redirect()->route('book')->with($notification);
    }

    public function destroy(string $id){
        $book = Book::findOrFail($id);

        Storage::delete('public/cover_buku/'.$book->cover);

        $book->delete();

        $notification = array(
            'message' => 'Data Buku berhasil dihapus',
            'alerty-type' => 'succes'
        );

        return redirect()->route('book')->with($notification);
    }

    public function print(){
        $book = Book::with('categorie')->get();

        $pdf = Pdf::loadview('books.print', ['books' => $book]);
        return $pdf->download('data_buku.pdf');
    }

    public function export(){
        return Excel::download(new BooksExport, 'books.xlsx');
    }

    public function import(Request $req){
        $req->validate([
            'file' => 'required|max:10000|mimes:xlsx, xls',
        ]);
        Excel::import(new BooksImport, $req->file('file'));

        $notification = array(
            'message' => 'import data berhasil dilakukan',
            'alert-type' => 'succes'
        );

        return redirect()->route('book')->with($notification);
    }
}
