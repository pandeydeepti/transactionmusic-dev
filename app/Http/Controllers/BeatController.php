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

        $producer_pages = Page::where('type', 'producer')->orderBy('order', 'ASC')->get();
        $banners = Banner::where('file_path', '!=', null)->get();
        $shop_options = ShopOption::whereIn('meta_key', ['application_text', 'shop_text'])->get();
        foreach ($shop_options as $shop_option) {
            ${$shop_option['meta_key']} = $shop_option['meta_value'];
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

        if( file_exists('json_resources/new_data.json') )
        {
             $newjson = file_get_contents('json_resources/new_data.json');
             JavaScript::put([ 'newdata' =>  json_decode( $newjson ) ]);
            
        } else {
            JavaScript::put(['newdata' =>  json_decode( file_get_contents(public_path() .'/json_resources/empty-data.json')) ]);
        }

        return view('beats.index', compact('banners', 'shop_text', 'application_text', 'producer_pages'));
    }

}
