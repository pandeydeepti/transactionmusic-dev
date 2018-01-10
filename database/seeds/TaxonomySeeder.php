<?php

use Illuminate\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxonomies')->insert([
            ['name' => 'GENRE', 'id' => 1, 'cover' => 'https://dev.transactionmusic.com/images/taxonomies/Genre.jpg'],
            ['name' => 'INSTRUMENTS', 'id' => 2, 'cover' => 'https://dev.transactionmusic.com/images/taxonomies/Instruments.jpg'],
            ['name' => 'PRODUCER', 'id' => 3, 'cover' => 'https://dev.transactionmusic.com/images/taxonomies/Producer.jpg'],
            ['name' => 'SOUNDS LIKE', 'id' => 4, 'cover' => 'https://dev.transactionmusic.com/images/taxonomies/Sounds_Like.jpg']
        ]);
    }
}
