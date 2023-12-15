<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;
    public function Bookshelf(): BelongsTo{
        return $this->belongsTo(Bookshelf::class);
    }
    public function Categorie(): BelongsTo{
        return $this->belongsTo(Categorie::class);
    }

    public static function getDataBooks(){
        $books = Book::all();

        $books_filter = [];

        $no = 1;
        for ($i=0; $i < $books->count(); $i++) { 
            $books_filter[$i][$no] = $no++;
            $books_filter[$i]['title'] = $books[$i]->title;
            $books_filter[$i]['author'] = $books[$i]->author;
            $books_filter[$i]['year'] = $books[$i]->year;
            $books_filter[$i]['publisher'] = $books[$i]->publisher;
            $books_filter[$i]['city'] = $books[$i]->city;
            $books_filter[$i]['cover'] = $books[$i]->cover;
            $books_filter[$i]['quantity'] = $books[$i]->quantity;
            $books_filter[$i]['categorie_id'] = $books[$i]->categorie_id;
            $books_filter[$i]['bookshelf_id'] = $books[$i]->bookshelf_id;
        }

        return $books_filter;
    }
    

    protected $fillable = [
        'title',
        'author',
        'year',
        'publisher',
        'city',
        'quantity',
        'categorie_id',
        'bookshelf_id',
        'cover',
    ];
}
