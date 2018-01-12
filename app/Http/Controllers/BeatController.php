<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Page;
use DB;
use JavaScript;
use App\ShopOption;
use Symfony\Component\HttpFoundation\Request;

class BeatController extends Controller
{
    public $global_object = array(
        'beats' => array(),
        'filters' => array(),
        'paypal_email' => array()
    );


    public function human_time($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) {
                continue;
            }
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }

    }

    public function index()
    {
    //        $beats = DB::select(DB::raw('
//           SELECT
//             AVG(rates.amount)  AS rate,
//             GROUP_CONCAT(categories.id) AS category_list,
//
//             (
//
//                SELECT beats.bpm
//
//             ) AS bpm,
//
//             (
//
//                SELECT GROUP_CONCAT(categories.title) FROM `beat_categories`
//                INNER JOIN categories on categories.id = beat_categories.category_id
//                INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
//                INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
//                WHERE taxonomies.id = 3 AND beat_categories.beat_id = beats.id
//
//             ) AS producer,
//
//             (
//
//                SELECT GROUP_CONCAT(categories.id) FROM `beat_categories`
//                INNER JOIN categories on categories.id = beat_categories.category_id
//                INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
//                INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
//                WHERE taxonomies.id = 4 AND beat_categories.beat_id = beats.id
//
//              ) AS sounds_like,
//
//              (
//
//                SELECT GROUP_CONCAT(categories.id) FROM `beat_categories`
//                INNER JOIN categories on categories.id = beat_categories.category_id
//                INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
//                INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
//                WHERE taxonomies.id = 2 AND beat_categories.beat_id = beats.id
//
//             ) AS instruments,
//
//             (
//
//                SELECT GROUP_CONCAT(categories.id) FROM `beat_categories`
//                INNER JOIN categories on categories.id = beat_categories.category_id
//                INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
//                INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
//                WHERE taxonomies.id = 1 AND beat_categories.beat_id = beats.id
//
//             ) AS genre,
//
//
//             (beats.id) as beat_id,
//             (beats.title) as beat_title,
//             (beats.cover) as beat_cover,
//             (beats.mp3) as beat_mp3,
//             (beats.mp3_price) as beat_mp3_price,
//             (beats.wav) as beat_wav,
//             (beats.wav_price) as beat_wav_price,
//             (beats.tracked_out) as beat_tracked_out,
//             (beats.tracked_out_price) as beat_tracked_out_price,
//             (beats.exclusive_price) as beat_exclusive_price
//
//             FROM beats
//             LEFT JOIN rates ON
//                beats.id = rates.beat_id
//             INNER JOIN beat_categories ON
//                beats.id = beat_categories.beat_id
//             INNER JOIN categories ON
//                beat_categories.category_id = categories.id
//             INNER JOIN category_taxonomies ON
//                categories.id = category_taxonomies.category_id
//             INNER JOIN taxonomies ON
//                category_taxonomies.taxonomy_id = taxonomies.id
//
//             GROUP BY beats.id
//
//             ORDER BY beats.created_at DESC
//
//         '));
//
        $newest_beats = DB::select(DB::raw('SELECT
                    DISTINCT beats.title as beat_title,
                    beats.bpm AS bpm, producers.title AS producer,
                    (
                    SELECT GROUP_CONCAT(categories.title SEPARATOR ", ") FROM `beat_categories`
                                    INNER JOIN categories on categories.id = beat_categories.category_id
                                    INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
                                    INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
                                    WHERE taxonomies.id = 1 AND beat_categories.beat_id = beats.id
                    ) AS genre,
        
                    beats.id as beat_id,
                    beats.bpm as beat_bpm,
                    beats.created_at as beat_created_at
        
                     FROM `beats`
        
                    INNER JOIN beat_categories ON  beat_categories.beat_id = beats.id
        			INNER JOIN beat_producers ON  beat_producers.beat_id = beats.id
        			INNER JOIN producers ON  beat_producers.producer_id = producers.id
        			INNER JOIN beat_sound_likes ON  beats.id = beat_sound_likes.beat_id
        			INNER JOIN sound_likes ON  beat_sound_likes.sound_like_id = sound_likes.id
                    INNER JOIN categories ON  beat_categories.category_id = categories.id
                    INNER JOIN category_taxonomies ON  category_taxonomies.category_id = categories.id
                    INNER JOIN taxonomies ON  category_taxonomies.taxonomy_id = taxonomies .id
        
                    ORDER BY beats.created_at DESC LIMIT 6;
                '));

        $producer_pages = Page::where('type', 'producer')->orderBy('order', 'ASC')->get();
        $banners = Banner::where('file_path', '!=', null)->get();
        $shop_options = ShopOption::whereIn('meta_key', ['application_text', 'shop_text'])->get();
        foreach ($shop_options as $shop_option) {
            ${$shop_option['meta_key']} = $shop_option['meta_value'];
        }
        foreach ($newest_beats as $newest_beat) {
            $newest_beat->beat_created_at = $this->human_time(strtotime($newest_beat->beat_created_at));
        }
        foreach ($producer_pages as $producer_page) {
            $json = json_decode($producer_page->description);
            @$producer_page->description = $json->description;
            @$producer_page->file_path = $json->file_path;
        }

        if( file_exists('json_resources/data.json') )
        {
            JavaScript::put( ['data' =>  json_decode( file_get_contents(public_path() . '/json_resources/data.json')) ]);
        } else {
            JavaScript::put(['data' =>  json_decode( file_get_contents(public_path() .'/json_resources/empty-data.json')) ]);
        }

        return view('beats.index', compact('newest_beats', 'banners', 'producers'));
    }

}
