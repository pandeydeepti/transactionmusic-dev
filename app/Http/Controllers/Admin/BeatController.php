<?php

namespace App\Http\Controllers\Admin;

use App\Rate;
use App\Http\Controllers\Controller;
use App\Beat;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use JavaScript;
use File;
use App\ShopOption;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Common\Event;
class BeatController extends Controller
{
    private $global_paypal = '';
    private $global_country_code = '';
    public $global_object = array(
        'beats' => array(),
        'filters' => array()
    );


    public function index()
    {
        /**
         * Run SQL query
         *
         * @return All Beats with Producers
         */
        $beats = DB::table('beats')->select(DB::raw('(beats.title) AS Beat, beats.active, beats.exclusive_active, beats.id, GROUP_CONCAT(categories.title) AS Producers'))
            ->join('beat_categories', 'beats.id', '=', 'beat_categories.beat_id')
            ->join('categories', 'beat_categories.category_id', '=', 'categories.id')
            ->join('category_taxonomies', 'category_taxonomies.category_id', '=', 'categories.id')
            ->join('taxonomies', 'category_taxonomies.taxonomy_id', '=', 'taxonomies.id')
            ->where('taxonomies.id', 3)
            ->groupBy('beats.id', 'Beat')->orderBy('beats.active', 'DESC')->get();

        JavaScript::put(['message' => session('data')['message'],'type' => session('data')['type']]);

        return View('admin.beats.index',  compact('beats') );
    }
    public function active($id, Request $request)
    {
        $beat = Beat::find($id);

        $beat->active = (int)$request->active;
        try{
            $beat->save();
            $this->generate_beat_JSON();
        } catch(Exception $ex){
            return response()->json([ 'message'  => $ex->getMessage(), 'type' => 'error']);
        }

        return response()->json([ 'message'  => 'Successfully updated beat', 'type' => 'success', 'active' => $beat->active]);
    }
    public function create($id = null)
    {
        if(isset($id)){
            $beat = DB::table('beats')->select(DB::raw('beats.*, GROUP_CONCAT(categories.id) AS cat_id, GROUP_CONCAT(categories.active) as cat_active'))
                ->join('beat_categories', 'beats.id', '=', 'beat_categories.beat_id')
                ->join('categories', 'beat_categories.category_id', '=', 'categories.id')
                ->join('category_taxonomies', 'categories.id', '=', 'category_taxonomies.category_id')
                ->join('taxonomies', 'taxonomies.id', '=', 'category_taxonomies.taxonomy_id')->where('beats.id', '=', $id)->groupBy('beats.id')
                ->first();
            $beat->rate = $this->average($beat->id);

            if(!empty($beat->cover)) {
                JavaScript::put(['beat_cover' => $beat->cover]);
                $beat->cover = 'background-image: url("' . $beat->cover . '");';
            }

            $beat->cat_id = explode(",",$beat->cat_id);
            JavaScript::put([
                'message' => session('data')['message'] ,
                'type' => session('data')['type'],
                'mp3_choose' => urldecode(explode('/', $beat->mp3)[count(explode('/', $beat->mp3)) - 1]),
                'wav_choose' => urldecode(explode('/', $beat->wav)[count(explode('/', $beat->wav)) - 1]),
                'tracked_out_choose' => urldecode(explode('/', $beat->tracked_out)[count(explode('/', $beat->tracked_out)) - 1])
            ]);
        }

        JavaScript::put(['message' => session('data')['message'] , 'type' => session('data')['type']]);

        $categories = DB::table('categories')->select(DB::raw('(categories.title) AS category, (categories.active) as cat_active, (taxonomies.id) AS tax_id, categories.id, taxonomies.name'))
            ->join('category_taxonomies', 'categories.id', '=', 'category_taxonomies.category_id')
            ->join('taxonomies', 'taxonomies.id', '=', 'category_taxonomies.taxonomy_id')->where('title', '!=', 'uncategorized')->where('categories.active', 1)->groupBy('tax_id', 'category', 'categories.id', 'taxonomies.name')
            ->get()->toArray();

        $grouped = $this->array_group_by($categories, 'name');

        if(isset($id)) {
            return View('admin.beats.create', ['categories' => $grouped, 'beat' => $beat]);
        } else {
            if((float)ShopOption::where('meta_key', 'instance_storage')->first()['meta_value'] < 2048.00)
            {
                return View('admin.beats.create', ['categories' => $grouped]);
            } else {
                return redirect()->back()->with('data', [ 'message'  => 'You are exceed 2 GB limit, can\'t upload new beats', 'type' => 'error']);
            }
        }
    }
    function array_group_by($arr, $key)
    {
        // Load the new array, splitting by the target key
        $grouped = [];
        foreach ($arr as $value) {
            $value = (array)$value;
            $grouped[$value[$key]][] = $value;
        }

        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2) {
            $args = func_get_args();

            foreach ($grouped as $key => $value) {
                $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $parms);
            }
        }

        return $grouped;
    }
    public function store(Request $request)
    {
        $beat = new Beat($request->all());

        if($request->hasFile('cover')){
            $beat->cover = $this->uploadPhoto($request->file()['cover'], 'images/beats', 165, 165);
        } else {
            $beat->cover = ShopOption::where('meta_key', 'beat_thumbnail_path')->first()['meta_value'];
        }

        $beat->save();

        if(isset($request->all()['categories']) ){
            $categories = $request->all()['categories'];
            $beat->categories()->attach($categories);
        }
        if($request->rate != '')
            Rate::insert(['beat_id' => $beat->id, 'amount' => $request->rate, 'ip' => $request->ip()]);

        if($beat->save()) {
            $this->generate_beat_JSON();
            ShopOption::where('meta_key', 'instance_storage')->update(['meta_value' => $this->get_directory_size(public_path('/beats'))]);
        } else {
            return redirect('/admin/beats/create/'.$beat->id.'')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('/admin/beats/create/'.$beat->id.'')->with('data', [ 'message'  => 'Successfully created beat', 'type' => 'success']);
    }
    public function update(Request $request)
    {
        $beat = Beat::find($request->id);
        $beat->title = trim($request->title);
        $beat->bpm = $request->bpm;
        $beat->mp3_price = $request->mp3_price;
        $beat->wav_price = $request->wav_price;
        $beat->exclusive_price = $request->exclusive_price;
        $beat->tracked_out_price = $request->tracked_out_price;
        $beat->exclusive_active = $request->exclusive_active;
        $beat->active = $request->active;

        if($request->hasFile('cover')){
            $beat->cover = $this->uploadPhoto($request->file()['cover'], 'images/beats', 165, 165);
        } else if (empty($beat->cover)){
            $beat->cover = ShopOption::where('meta_key', 'beat_thumbnail_path')->first()['meta_value'];
        }
        if($request->mp3 != ''){
            $this->delete_beat_file($beat->mp3);
            $beat->mp3 = $request->mp3;
        }
        if($request->wav != ''){
            $this->delete_beat_file($beat->wav);
            $beat->wav = $request->wav;
        }
        if($request->tracked_out != ''){
            $this->delete_beat_file($beat->tracked_out);
            $beat->tracked_out = $request->tracked_out;
        }

        $categories = $request->all()['categories'];
        $beat->categories()->sync($categories);

        if($request->rate != ''){
            try{
                DB::table('rates')->where('beat_id', $beat->id)->delete();
                Rate::insert(['beat_id' => $beat->id, 'amount' => $request->rate, 'ip' => $request->ip()]);
            } catch(Exception $ex){
                $ex->getMessage();
            }
        }

        try {
            $beat->save();
            $this->generate_beat_JSON();
            ShopOption::where('meta_key', 'instance_storage')->update(['meta_value' => $this->get_directory_size(public_path('/beats'))]);
        }
        catch (Exception $e) {
            return redirect('/admin/beats/create/'.$beat->id.'')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }
        return redirect('/admin/beats/create/'.$beat->id.'')->with('data', [ 'message'  => 'Successfully updated beat', 'type' => 'success']);
    }
    public function clean($string) {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '_', $string); // Removes special chars.
    }
    public function audio()
    {
        $year = date("Y");
        $month = date("m");
        $output_dir = "beats/";
        if (isset($_FILES["beat"])) {
            $ret = array();

            $error = $_FILES["beat"]["error"];
            //You need to handle  both cases
            //If Any browser does not support serializing of multiple files using FormData()
            if (!is_array($_FILES["beat"]["name"])) //single file
            {
                //check if year folder exists and make folder with name of current year if not exist

                if(!file_exists($output_dir.$year)){

                    File::makeDirectory($output_dir.$year, 0775, true, true);
                }
                //check if month folder exists and make folder with name of current month if not exist
                if(!file_exists($output_dir.$year.'/'.$month)) {
                    File::makeDirectory($output_dir.$year.'/'.$month, 0775, true, true);
                }

                $beatName = $_SERVER['HTTP_BEATTITLE'];
                $beatExtension = $_SERVER['HTTP_FIELD'];

                $folderName = $this->clean($beatName);

                $temp_path = $output_dir . $year . '/' . $month . '/' . $folderName;
                //check if beat name folder exists and make folder with name of current beat if not exist
                if(!file_exists($temp_path)) {
                    File::makeDirectory($temp_path, 0775, true, true);
                }
                if(!file_exists($temp_path. '/'. $beatExtension)) {
                    File::makeDirectory($temp_path. '/'. $beatExtension , 0775, true, true);
                }

                $fileName = urlencode ($_FILES["beat"]["name"]);
                if(!file_exists($temp_path. '/'. $beatExtension. '/' . $fileName)) {
                    move_uploaded_file($_FILES["beat"]["tmp_name"],
                        $temp_path . '/' . $beatExtension . '/' . $fileName);
                }
                $fileName = '' . url($temp_path . '/' . $beatExtension . '/' . $fileName) . '';
                $ret[] = $fileName;
            }

            echo json_encode($ret);
        }

    }
    public function delete($id)
    {
        $beat = Beat::find($id);
        $beat_path = [$beat->mp3, $beat->wav, $beat->tracked_out];
        $this->delete_beat_dirs($beat_path);

        try {
            $beat->categories()->detach($id);
            $beat->delete();
            $this->generate_beat_JSON();
            ShopOption::where('meta_key',
                'instance_storage')->update(['meta_value' => $this->get_directory_size(public_path('/beats'))]);
        } catch (Exception $e) {
            return redirect()->back()->with('data', ['message' => 'Failed', 'type' => 'error']);
        }

        return redirect()->back()->with('data', ['message' => 'Successfully deleted beat', 'type' => 'success']);

    }
    public function organize_single_cat_JSON($single_cat){

        $categories_id_arr = explode(',', $single_cat->categories_id);
        $categories_title_arr = explode(',', $single_cat->categories_title );
        $categories_cover_arr = explode(',', $single_cat->categories_cover );

        $this->global_object['filters'][strtolower($single_cat->name)]['categories'] = array();

        foreach( $categories_id_arr as $index => $single_cat_ref ){
            array_push( $this->global_object['filters'][strtolower($single_cat->name)]['categories'],

                array(
                    'title'     => $categories_title_arr[ $index ],
                    'id'        => $single_cat_ref,
                    'cover'     => $categories_cover_arr[ $index ]
                ) );
        }
        $this->global_object['filters'][strtolower($single_cat->name)]['cover'] = $single_cat->taxonomy_cover;

    }
    public function organize_JSON( $beats ){
        $beats->category_list = explode(',', $beats->category_list );
        $beats->sounds_like = explode(',', $beats->sounds_like );
        $beats->instruments = explode(',', $beats->instruments );
        $beats->genre = explode(',', $beats->genre );
        $beats->producer = explode(',', $beats->producer );
        $beats->instance = array(
            'name'  => Config::get('app.name'),
            'url'  => url("/")
        );
        $beats->country_code = $this->global_country_code;
        $beats->paypal_email = $this->global_paypal;
        $beats->beat_files = array(
            'mp3'   => array(
                'file_type' => 'mp3',
                'file_path' => $beats->beat_mp3,
                'file_price' => $beats->beat_mp3_price,
            ),
            'wav'   => array(
                'file_type' => 'wav',
                'file_path' => $beats->beat_wav,
                'file_price' => $beats->beat_wav_price,
            ),
            'tracked_out'   => array(
                'file_type' => 'tracked out',
                'file_path' => $beats->beat_tracked_out,
                'file_price' => $beats->beat_tracked_out_price,
            ),
            'exclusive'   => array(
                'file_type' => 'exclusive',
                'file_price' => $beats->beat_exclusive_price,
            ),
        );

        /* Unset the data */
        unset( $beats->active );
        unset( $beats->beat_mp3 );
        unset( $beats->beat_mp3_price );
        unset( $beats->beat_wav );
        unset( $beats->beat_wav_price );
        unset( $beats->beat_tracked_out );
        unset( $beats->beat_tracked_out_price );
        unset( $beats->beat_exclusive_price );

        array_push($this->global_object['beats'], $beats);

    }
    public function organize_cat_JSON($filter)
    {
        array_map(array($this, "organize_single_cat_JSON"), $filter);
    }

    public function generate_beat_JSON()
    {
        $this->global_country_code = strtolower(ShopOption::where('meta_key', 'country')->first()['meta_value']);
        $this->global_paypal = ShopOption::where('meta_key', 'paypal_email')->first()['meta_value'];

        $beats = DB::select(DB::raw('
           SELECT
             AVG(rates.amount)  AS rate,
             GROUP_CONCAT(categories.title) AS category_list,

             (

                SELECT beats.bpm

             ) AS bpm,

             (

                SELECT GROUP_CONCAT(categories.title) FROM `beat_categories`
                INNER JOIN categories on categories.id = beat_categories.category_id
                INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
                INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
                WHERE taxonomies.id = 3 AND beat_categories.beat_id = beats.id

             ) AS producer,

             (

                SELECT GROUP_CONCAT(categories.title) FROM `beat_categories`
                INNER JOIN categories on categories.id = beat_categories.category_id
                INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
                INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
                WHERE taxonomies.id = 4 AND beat_categories.beat_id = beats.id

              ) AS sounds_like,

              (

                SELECT GROUP_CONCAT(categories.title) FROM `beat_categories`
                INNER JOIN categories on categories.id = beat_categories.category_id
                INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
                INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
                WHERE taxonomies.id = 2 AND beat_categories.beat_id = beats.id

             ) AS instruments,

             (

                SELECT GROUP_CONCAT(categories.title) FROM `beat_categories`
                INNER JOIN categories on categories.id = beat_categories.category_id
                INNER join category_taxonomies ON category_taxonomies.category_id = categories.id
                INNER JOIN taxonomies ON category_taxonomies.taxonomy_id = taxonomies.id
                WHERE taxonomies.id = 1 AND beat_categories.beat_id = beats.id

             ) AS genre,


             (beats.id) as beat_id,
             (beats.active),
             (beats.title) as beat_title,
             (beats.cover) as beat_cover,
             (beats.mp3) as beat_mp3,
             (beats.mp3_price) as beat_mp3_price,
             (beats.wav) as beat_wav,
             (beats.wav_price) as beat_wav_price,
             (beats.tracked_out) as beat_tracked_out,
             (beats.tracked_out_price) as beat_tracked_out_price,
             (beats.exclusive_price) as beat_exclusive_price,
             (beats.created_at) as beat_created_at

             FROM beats
             LEFT JOIN rates ON
                beats.id = rates.beat_id
             INNER JOIN beat_categories ON
                beats.id = beat_categories.beat_id
             INNER JOIN categories ON
                beat_categories.category_id = categories.id
             INNER JOIN category_taxonomies ON
                categories.id = category_taxonomies.category_id
             INNER JOIN taxonomies ON
                category_taxonomies.taxonomy_id = taxonomies.id

             WHERE beats.active = 1

             GROUP BY beats.id

             ORDER BY beats.created_at DESC

         '));

        if (!empty($beats)) {
            array_map(array($this, "organize_JSON"), (array)$beats);

            $filters = DB::table('taxonomies')->select(DB::raw('taxonomies.name, GROUP_CONCAT(categories.id) AS categories_id, GROUP_CONCAT(categories.title) AS categories_title, GROUP_CONCAT(categories.cover) AS categories_cover, (taxonomies.cover) AS taxonomy_cover'))
                ->join('category_taxonomies', 'taxonomies.id', 'category_taxonomies.taxonomy_id')
                ->join('categories', 'category_taxonomies.category_id', 'categories.id')
                ->where('categories.active', 1)
                ->groupBy('taxonomies.name')->get();

            $filters = (array)$filters;
            array_map(array($this, "organize_cat_JSON"), $filters);


            file_put_contents(public_path() . '/json_resources/data.json', json_encode(array(
                'beats' => $this->global_object['beats'],
                'filters' => $this->global_object['filters']
            )));
        } else {
            file_put_contents(public_path() . '/json_resources/data.json',
                file_get_contents(public_path() . '/json_resources/empty_beat_data.json'));
        }

        $client = new Client([
            'base_uri' => env('APP_TM_URL', 'transactionmusic.com') . '/api/',
            'verify' => false
        ]);

        $client->request('get', 'subinstances/sync');
    }

    public function api_beats_json()
    {

        if( file_exists('json_resources/data.json') )
        {
            return response()->json(json_decode(file_get_contents('json_resources/data.json')));
        } else {
            return response(null);
        }
    }


}
