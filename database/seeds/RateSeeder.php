<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rates')->insert([
            ['id' => 1, 'amount' => 50, 'beat_id' => 1, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 2, 'amount' => 50, 'beat_id' => 2, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 3, 'amount' => 50, 'beat_id' => 3, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 4, 'amount' => 50, 'beat_id' => 4, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 5, 'amount' => 50, 'beat_id' => 5, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 6, 'amount' => 50, 'beat_id' => 6, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 7, 'amount' => 50, 'beat_id' => 7, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 8, 'amount' => 50, 'beat_id' => 8, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 9, 'amount' => 50, 'beat_id' => 9, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 10, 'amount' => 50, 'beat_id' => 10, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['id' => 11, 'amount' => 50, 'beat_id' => 11, 'ip' => '192.168.5.5', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')]
        ]);

    }
}
