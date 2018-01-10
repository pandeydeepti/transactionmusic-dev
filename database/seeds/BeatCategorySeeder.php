<?php

use Illuminate\Database\Seeder;

class BeatCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('beat_categories')->insert([
            ['beat_id' => 1, 'category_id' => 20],
            ['beat_id' => 1, 'category_id' => 19],
            ['beat_id' => 2, 'category_id' => 19],
            ['beat_id' => 3, 'category_id' => 19],
            ['beat_id' => 4, 'category_id' => 19],
            ['beat_id' => 5, 'category_id' => 19],
            ['beat_id' => 6, 'category_id' => 19],
            ['beat_id' => 7, 'category_id' => 19],
            ['beat_id' => 8, 'category_id' => 19],
            ['beat_id' => 9, 'category_id' => 19],
            ['beat_id' => 10, 'category_id' => 19],
            ['beat_id' => 11, 'category_id' => 19],
            ['beat_id' => 12, 'category_id' => 19],
            ['beat_id' => 1, 'category_id' => 15],
            ['beat_id' => 2, 'category_id' => 15],
            ['beat_id' => 3, 'category_id' => 15],
            ['beat_id' => 4, 'category_id' => 15],
            ['beat_id' => 5, 'category_id' => 15],
            ['beat_id' => 6, 'category_id' => 15],
            ['beat_id' => 7, 'category_id' => 15],
            ['beat_id' => 8, 'category_id' => 15],
            ['beat_id' => 9, 'category_id' => 15],
            ['beat_id' => 10, 'category_id' => 15],
            ['beat_id' => 11, 'category_id' => 15],
            ['beat_id' => 12, 'category_id' => 15],
            ['beat_id' => 1, 'category_id' => 33],
            ['beat_id' => 2, 'category_id' => 33],
            ['beat_id' => 3, 'category_id' => 33],
            ['beat_id' => 4, 'category_id' => 33],
            ['beat_id' => 5, 'category_id' => 33],
            ['beat_id' => 6, 'category_id' => 33],
            ['beat_id' => 7, 'category_id' => 33],
            ['beat_id' => 8, 'category_id' => 33],
            ['beat_id' => 9, 'category_id' => 33],
            ['beat_id' => 10, 'category_id' => 33],
            ['beat_id' => 11, 'category_id' => 33],
            ['beat_id' => 12, 'category_id' => 33],
            ['beat_id' => 2, 'category_id' => 26],
            ['beat_id' => 3, 'category_id' => 22],
            ['beat_id' => 4, 'category_id' => 23],
            ['beat_id' => 5, 'category_id' => 24],
            ['beat_id' => 6, 'category_id' => 24],
            ['beat_id' => 7, 'category_id' => 24],
            ['beat_id' => 8, 'category_id' => 24],
            ['beat_id' => 9, 'category_id' => 24],
            ['beat_id' => 10, 'category_id' => 24],
            ['beat_id' => 11, 'category_id' => 24],
            ['beat_id' => 12, 'category_id' => 20]
        ]);


    }
}
