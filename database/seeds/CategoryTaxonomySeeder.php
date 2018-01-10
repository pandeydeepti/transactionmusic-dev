<?php

use Illuminate\Database\Seeder;

class CategoryTaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_taxonomies')->insert([
            //Genres
            [ 'category_id' => 5, 'taxonomy_id' => 1],
            [ 'category_id' => 6, 'taxonomy_id' => 1],
            [ 'category_id' => 7, 'taxonomy_id' => 1],
            [ 'category_id' => 29, 'taxonomy_id' => 1],
            [ 'category_id' => 1, 'taxonomy_id' => 1],
            [ 'category_id' => 2, 'taxonomy_id' => 1],
            [ 'category_id' => 3, 'taxonomy_id' => 1],
            [ 'category_id' => 4, 'taxonomy_id' => 1],
            //Instruments
            ['category_id' => 8, 'taxonomy_id' => 2],
            ['category_id' => 9, 'taxonomy_id' => 2],
            ['category_id' => 10, 'taxonomy_id' => 2],
            ['category_id' => 11, 'taxonomy_id' => 2],
            ['category_id' => 12, 'taxonomy_id' => 2],
            ['category_id' => 13, 'taxonomy_id' => 2],
            ['category_id' => 14, 'taxonomy_id' => 2],
            ['category_id' => 15, 'taxonomy_id' => 2],
            //Sounds Like
            ['category_id' => 16, 'taxonomy_id' => 4],
            ['category_id' => 17, 'taxonomy_id' => 4],
            ['category_id' => 18, 'taxonomy_id' => 4],
            ['category_id' => 19, 'taxonomy_id' => 4],

            //Producers
            ['category_id' => 20, 'taxonomy_id' => 3],
            ['category_id' => 21, 'taxonomy_id' => 3],
            ['category_id' => 22, 'taxonomy_id' => 3],
            ['category_id' => 23, 'taxonomy_id' => 3],
            ['category_id' => 24, 'taxonomy_id' => 3],
            ['category_id' => 25, 'taxonomy_id' => 3],
            ['category_id' => 26, 'taxonomy_id' => 3],
            ['category_id' => 27, 'taxonomy_id' => 3]
        ]);
    }

}
