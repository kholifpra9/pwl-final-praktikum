<?php

namespace Database\Seeders;

use App\Models\Bookshelf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookshelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Bookshelf::insert([
            [
                'id' => '1',
                'code' => '620',
                'name' => 'Engginering'
            ],
            [
                'id' => '2',
                'code' => '621',
                'name' => 'Mechanical'
            ],
            [
                'id' => '3',
                'code' => '622',
                'name' => 'Topographical'
            ],
        ]);
    }
}
