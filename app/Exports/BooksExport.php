<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromArray;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array{
        return Book::getDataBooks();
    }

    // public function array(): array{
    //     return Book::getDataBooks();
    // }

    public function headings(): array{
        return[
            'no',
            'Judul',
            'Penulis',
            'Tahun',
            'Penerbit',
            'Kota',
            'quantity',
            'cover',
            'Categorie id',
            'Bookshelf id',
        ];
    }

    // public function collection()
    // {
    //     return Book::select('title', 'author', 'year', 'publisher', 'city', 'cover', 'quantity', 'categorie_id', 'bookshelf_id')->get();
    // }
}
