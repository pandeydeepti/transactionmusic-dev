<?php

namespace App\Http\Controllers;

use App\Rate;
use Illuminate\Http\Request;
use DB;

class RateController extends Controller
{
    public function store(Request $request)
    {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Content-Type: text/html; charset=utf-8");

        $rate = Rate::where('beat_id', $request->beat_id)->where('ip', $request->ip())->first();
        $avg = json_encode($this->average($request->beat_id));

        if ($rate === null || ( $rate->ip != $request->ip() ) && ( !empty( $request->beat_id ) ) && ( !empty( $request->beat_id ) ) && ( !empty( $request->amount ) ) ) {
            if (isset( $request->beat_id ) && isset( $request->amount ) ) {
                $rate = new Rate(($request->all()));
                $rate->ip = $request->ip();
                try {
                    $rate->save();
                } catch (Exception $e) {
                    return response()->json(['code' => 400, 'value' => intval($avg), 'result' => 'Error' ]);
                }
                $avg = json_encode($this->average($rate->beat_id));

                return response()->json(['code' => 200, 'value' => $avg, 'result' => 'Success']);
            } else {
                return response()->json(['code' => 401, 'value' => intval($avg), 'result' => 'Bad Request']);
            }
        }  else {
            return response()->json(['code' => 500, 'value' => intval($avg), 'result' => 'Already rated']);
        }
    }
}
