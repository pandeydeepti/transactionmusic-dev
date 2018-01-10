<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 'active
 => 1,     */
    public function run()
    {

        DB::table('beats')->insert([
            [
                'id' => 1,
                'active' => 1,
                'title' => 'Star Alliance - PVC (Eric Prydz Remix)',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'active' => 1,
                'title' => 'M Factor - Come Together ',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'active' => 1,
                'title' => "Par-T-One - I'm So Crazy",
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 4,
                'active' => 1,
                'title' => 'Eric Prydz - Slammin',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 5,
                'active' => 1,
                'title' => 'Mutiny ft. Lorraine Cato - Holding On',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 12,
                'active' => 1,
                'title' => 'Alter Ego - Rocker (Eric Prydz Remix)',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 6,
                'active' => 1,
                'title' => 'Felix Da Housecat - Thee Anthem ',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 7,
                'active' => 1,
                'title' => 'Audrey N - Banana Soda Es Muy Loca',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 8,
                'active' => 1,
                'title' => 'Depeche Mode - Personal Jesus',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 9,
                'active' => 1,
                'title' => 'Dizzee Rascal & Armand Helden - Bonkers',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 10,
                'active' => 1,
                'title' => 'New Order - Blue Monday',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 11,
                'active' => 1,
                'title' => 'The Junkies & Carlo Lio - Last Days',
                'cover' => '../../../images/beats/thumbnail-default.jpg',
                'bpm' => 66,
                'mp3' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'wav' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'exclusive_active' => 1,
                'tracked_out' => 'http://transaction.dev/beats/2016/12/novi_test_beat/mp3/Bonkers - Dizzee Rascal vs Armand van Helden HD Sound.mp3',
                'mp3_price' => '10.15',
                'wav_price' => '9.86',
                'exclusive_price' => '3.44',
                'tracked_out_price' => '25.7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);


    }
}
