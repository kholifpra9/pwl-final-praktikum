<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Categorie::insert([
            [
                'id' => '1',
                'category' => 'Drama',
                
            ],
            [
                'id' => '2',
                'category' => 'Comedy',
                
            ],
            [
                'id' => '3',
                'category' => 'Pengetahuan',
                
            ],
        ]);
    }
}
