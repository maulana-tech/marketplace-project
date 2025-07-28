<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('categories')->insert([
         [
            'name' => 'Reebok',
            'slug' => 'reebok',
            'icon' => 'images/ic_ebook.svg',
            'created_at' => Carbon ::now(),
            'updated_at' => Carbon ::now(),
         ],
         [
            'name' => 'Nike',
            'slug' => 'nike',
            'icon' => 'images/ic_course.svg',
            'created_at' => Carbon ::now(),
            'updated_at' => Carbon ::now(),
         ],
         [
            'name' => 'Adidas',
            'slug' => 'adidas',
            'icon' => 'images/ic_template.svg',
            'created_at' => Carbon ::now(),
            'updated_at' => Carbon ::now(),
         ],
         [
            'name' => 'New Balance',
            'slug' => 'new-balance',
            'icon' => 'images/ic_font.svg',
            'created_at' => Carbon ::now(),
            'updated_at' => Carbon ::now(),
         ],
        ]);
    }
}
