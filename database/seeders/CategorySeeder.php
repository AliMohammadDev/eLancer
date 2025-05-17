<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('categories')->insert([
      [
        'name' => 'Web / Software Dev',
        'slug'=> 'web-software-dev',
        'art_file'=>'art_file/web-software.jpg',
      ],
      [
        'name' => 'Data Science / Analitycs',
        'slug'=> 'data-science-analitycs',
        'art_file'=>'art_file/data-sinces.png',
      ],
      [
        'name' => 'Accounting / Consulting',
        'slug'=> 'accounting-consulting',
        'art_file'=>'art_file/accountend-manementjpg.jpg',
      ],
      [
        'name' => 'Writing & Translations',
        'slug'=> 'writing-translations',
        'art_file'=>'art_file/writelining-translation.jpeg',
      ],
      [
        'name' => 'Sales & Marketing',
        'slug'=>'sales-marketing',
        'art_file'=>'art_file/Sales-and-Marekting.webp',
      ],
      [
        'name' => 'Graphics & Design',
        'slug'=>'graphics-design',
        'art_file'=>'art_file/graphic-design-1280x720.jpg',
      ],
      [
        'name' => 'Digital Marketing',
        'slug'=>'digital-marketing',
        'art_file'=>'art_file/digital-markting.jpeg',
      ],
      [
        'name' => 'Education & Training',
        'slug'=>'education-training',
        'art_file'=>'art_file/eduaction-trainign.jpeg',
      ],
    ]);
  }
}
