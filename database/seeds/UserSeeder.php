<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Duka',
            'api_token' => str_random(60),
            'email' => 'dusan@librafire.com',
            'password' => Hash::make('dusan123')
        ]);
        DB::table('users')->insert([
            'name' => 'Lawren',
            'email' => 'lawrengreene@gmail.com',
            'password' => Hash::make('waterman'),
            'api_token' => 'piDIHsO36SnAaG0tKShrGzUC1ekGuUrQJAHxn2R4tgvJ2VE7yE3stwhX3LZi'
        ]);
    }
}
