<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('categories')->insert([
            //Genres
            ['title' => 'Pop', 'active' => 0, 'description' => $faker->text, 'id' => 1, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Rock', 'active' => 0, 'description' => $faker->text, 'id' => 2, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Rnb', 'active' => 0, 'description' => $faker->text, 'id' => 3, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Chill', 'active' => 1, 'description' => $faker->text, 'id' => 4, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Sould', 'active' => 1, 'description' => $faker->text, 'id' => 5, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Hip Hop', 'active' => 1, 'description' => $faker->text, 'id' => 6, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Smooth', 'active' => 0, 'description' => $faker->text, 'id' => 7, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'West Coast', 'active' => 1, 'description' => $faker->text, 'id' => 29, 'cover' => url('images/taxonomies/Chill1.jpg')],
            //Instruments
            ['title' => 'Guitar', 'active' => 0, 'description' => $faker->text, 'id' => 8, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Violin', 'active' => 0, 'description' => $faker->text, 'id' => 9, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Piano', 'active' => 0, 'description' => $faker->text, 'id' => 10, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Chello', 'active' => 1, 'description' => $faker->text, 'id' => 11, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Trumpet', 'active' => 1, 'description' => $faker->text, 'id' => 12, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Drums', 'active' => 1, 'description' => $faker->text, 'id' => 13, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Flute', 'active' => 0, 'description' => $faker->text, 'id' => 14, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Bass', 'active' => 1, 'description' => $faker->text, 'id' => 15, 'cover' => url('images/taxonomies/Chill1.jpg')],
            //Sounds Like
            ['title' => 'Predatory', 'active' => 0, 'description' => $faker->text, 'id' => 16, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Icey', 'active' => 0, 'description' => $faker->text, 'id' => 17, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Lone Survivor', 'active' => 1, 'description' => $faker->text, 'id' => 18, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Gums are Toys', 'active' =>1, 'description' => $faker->text, 'id' => 19, 'cover' => url('images/taxonomies/Chill1.jpg')],
            //Producers
            ['title' => 'Elizabeth Morris', 'active' => 1, 'description' => $faker->text, 'id' => 20, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Eileen Blankenship', 'active' => 1, 'description' => $faker->text, 'id' => 22, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Howard Cameron', 'active' => 1, 'description' => $faker->text, 'id' => 23, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Ibrahim Small', 'active' => 1, 'description' => $faker->text, 'id' => 24, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Charles Cervantes', 'active' => 0, 'description' => $faker->text, 'id' => 25, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Simeon Peters', 'active' => 1, 'description' => $faker->text, 'id' => 26, 'cover' => url('images/taxonomies/Chill1.jpg')],
            ['title' => 'Kaeden Rocha', 'active' => 0, 'description' => $faker->text, 'id' => 27, 'cover' => url('images/taxonomies/Chill1.jpg')],

        ]);
    }
}
