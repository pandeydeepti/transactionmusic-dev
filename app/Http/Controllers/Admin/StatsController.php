<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LfTransaction;
use App\ShopOption;
use Illuminate\Http\Request;
use JavaScript;
use DB;
class StatsController extends Controller
{
    protected function array_merge_numeric_values($arrays)
    {
        $merged = array();

        foreach ($arrays as $array) {

            foreach ($array as $key => $value) {
                if (!is_numeric($value)) {
                    continue;
                }
                if (!isset($merged[$key])) {
                    $merged[$key] = $value;
                } else {
                    $merged[$key] += $value;
                }
            }
        }

        return $merged;
    }

    protected function beat_type_func($beat_type, $beat_info)
    {
        $array = [];

        if( str_contains($beat_type, ', ') )
        {
            $beat_type = explode(', ', $beat_type);

            foreach ($beat_type as $single_type) {
                $array [$single_type] = $beat_info->{"beat_" .str_replace(' ', '_', strtolower($single_type) ) . "_price"};
            }

        } else {
            $array [$beat_type] = $beat_info->{"beat_" .str_replace(' ', '_', strtolower($beat_type) ) . "_price"};
        }

        return $array;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storage_stat = ShopOption::where('meta_key', 'instance_storage')->first()['meta_value'];
        $storage_stat = number_format((float)$storage_stat * (1/1024), 2, '.', '' );
        $storage_percentage = ( $storage_stat / 2 ) * 100;
        $storage_percentage = explode('.', $storage_percentage)[0];

        $stats = DB::select(DB::raw("
            SELECT (beats.id) AS bid,
            (beats.title) AS beat_title,
            (beats.mp3_price) AS beat_mp3_price,
            (beats.wav_price) AS beat_wav_price,
            (beats.tracked_out_price) AS beat_tracked_out_price,
            (beats.exclusive_price) AS beat_exclusive_price,
            (beats.bpm) AS bpm,
            GROUP_CONCAT( lf_transactions.updated_at ) AS tr_created_at,
            GROUP_CONCAT( beat_lf_transaction.buyed_types SEPARATOR ';' ) AS bought_types,
            ( SELECT COUNT(*) FROM beat_lf_transaction WHERE beat_lf_transaction.beat_id = bid) AS bought_times,
            ( SELECT GROUP_CONCAT(categories.title SEPARATOR ', ') FROM categories INNER JOIN beat_categories ON beat_categories.category_id = categories.id INNER JOIN beats ON beats.id = beat_categories.beat_id WHERE beat_categories.beat_id = bid) AS categories
            FROM beats
            INNER JOIN beat_lf_transaction ON beat_lf_transaction.beat_id = beats.id
            INNER JOIN lf_transactions ON beat_lf_transaction.lf_transaction_id = lf_transactions.id
            WHERE lf_transactions.payment_state = 'success'
            GROUP BY beat_id;
        "));

        $today_date = date('Y-m-d');
        $today_stats = [];

        foreach ($stats as &$stat) {

            $stat->tr_created_at = explode(",", $stat->tr_created_at);
            $stat->created_at = str_replace("-", "/", $stat->tr_created_at[0]);
            $stat->created_at = explode(" ", $stat->created_at)[0];

            $beat_type = [];
            $beat_bought = 0;
            $beat_today_type = [];
            /**
             * For thought each single bought beat
             */
            $beat_types = explode(';', $stat->bought_types);

            for($i=0; $i<count($stat->tr_created_at); $i++){

                if(explode(" ", $stat->tr_created_at[$i])[0] == $today_date )
                {
                    if( empty($this->search($today_stats, 'beat_title', $stat->beat_title) ) )
                    {
                        $today_stats [] =
                        [
                            'id' => (int)$stat->bid,
                            'beat_title' => $stat->beat_title,
                            'bpm' => $stat->bpm,
                            'created_at' => '',
                            'categories' => $stat->categories,
                            'bought_times' => '',
                            'types' => '',
                            'price' => ''
                        ];
                    }


                    $beat_today_type[] =  $this->beat_type_func($beat_types[$i], $stat) ;
                    $beat_bought = $beat_bought + 1;
                }

                if( ($i == count($stat->tr_created_at) - 1) && !empty($today_stats) )
                {
                    $array_key =  $this->get_key_twodim_array($today_stats, 'beat_title', $stat->beat_title);
                    $today_stats[$array_key]['types'] = $this->array_merge_numeric_values($beat_today_type);
                    $today_stats[$array_key]['price'] = array_sum(array_values($today_stats[$array_key]['types']));
                    $today_stats[$array_key]['types'] = http_build_query( $today_stats[$array_key]['types'], ' ', '</br>');
                    $today_stats[$array_key]['types'] = str_replace("+"," ", $today_stats[$array_key]['types']);

                    $today_stats[$array_key]['created_at'] = $stat->tr_created_at[$i][0];
                    $today_stats[$array_key]['bought_times'] = $beat_bought;
                    $beat_bought = 0;
                    $beat_today_type = [];
                }

                $beat_type [] = $this->beat_type_func($beat_types[$i], $stat);
            }

            $stat->types = $this->array_merge_numeric_values($beat_type);
            $stat->price = array_sum( array_values($stat->types) );
            $stat->types = http_build_query( $stat->types, ' ', '</br>');
            $stat->types = str_replace("+"," ", $stat->types);

            unset($stat->beat_mp3_price);
            unset($stat->beat_wav_price);
            unset($stat->beat_tracked_out_price);
            unset($stat->beat_exclusive_price);
            unset($stat->bought_types);
            unset($stat->tr_created_at);
        }

        JavaScript::put(['stats' => $stats, 'today_stats' => $today_stats]);

        return view('admin.stats.index', compact('storage_stat', 'storage_percentage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
