<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UsersTableSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(ShopOptionSeeder::class);
         $this->call(TaxonomySeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(CategoryTaxonomySeeder::class);
//         $this->call(BeatSeeder::class);
//         $this->call(BeatCategorySeeder::class);
         $this->call(PageSeeder::class);
//         $this->call(RateSeeder::class);
    }
}
