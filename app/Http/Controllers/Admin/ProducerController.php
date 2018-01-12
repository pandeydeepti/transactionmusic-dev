<?php

namespace App\Http\Controllers\Admin;

use App\Producer;
use App\Beat;
use App\Http\Controllers\Controller;
use App\Subinstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\ShopOption;

use App\Http\Requests;
use App\Taxonomy;
use JavaScript;
use DB;
use GuzzleHttp\Client;

class ProducerController extends Controller
{

    public function active($id, Request $request)
    {
        $producer = Producer::find($id);
        $producer->active = (int)$request->active;

        try{
            $producer->save();
        } catch(Exception $ex){
            return response()->json([ 'message'  => $ex->getMessage(), 'type' => 'error']);
        }

        return response()->json([ 'message'  => 'Successfully updated producer state', 'type' => 'success', 'active' => $producer->active]);
    }
    public function index()
    {
        $producers = DB::table('producers')->select(DB::raw('(producers.title) AS Producers, producers.id, producers.active'))
                    ->orderBy('producers.active', 'desc')->get();
        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);

        return view('admin.producers.index', ['producers' => $producers]);
    }
    public function create()
    {
        return View('admin.producers.create');
    }
    public function edit($id)
    {
        $producer = Producer::find($id);

        if($producer->cover != null)
            $producer->cover = 'background-image: url("'.$producer->cover.'");';

        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);

        return View('admin.producers.edit', ['producer' => $producer]);
    }
    public function store(Request $request)
    {
        $producer = new Producer($request->all());
        if($request->hasFile('cover')){
            $producer->cover = $this->uploadPhoto($request->file()['cover'], 'images/producers', 200, 200);
        } else {
            $producer->cover = ShopOption::where('meta_key', 'producer_thumbnail_path')->first()['meta_value'];
        }

        if (Producer::where('title', '=', Input::get('title'))->exists()) 
        {
            return redirect('/admin/producers/')->with('data', [ 'message'  => 'Producer already exists', 'type' => 'error']);
        }else{
            $producer->save();
        }
        
        if($producer->save())
        {
            return redirect('/admin/producers/edit/'.$producer->id.'')->with('data', [ 'message'  => 'Successfully created producer', 'type' => 'success']);
        } else {
            return redirect('/admin/producers/edit/'.$producer->id.'')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }
    }
    public function update(Request $request)
    {
        
        $producer = Producer::find($request->id)->fill($request->all());

        if( $request->hasFile('cover') ){

            $producer->cover = $this->uploadPhoto($request->file()['cover'], 'images/producers');
        } else {
            $producer->cover = ShopOption::where('meta_key', 'producer_thumbnail_path')->first()['meta_value'];
        }
        
       
        try {
                $producer->save();
        }
        catch (Exception $e) {
            return redirect('/admin/producers/edit/'.$producer->id.'')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('/admin/producers/edit/'.$producer->id.'')->with('data', [ 'message'  => 'Successfully updated producer', 'type' => 'success' ]);
    }
    
    public function delete($id)
    {
        $producer = Producer::with('beat_producers')->find($id);

        $producer->beat_producers()->detach();

        try {
            $producer->delete();
        } catch (Exception $e) {
            return redirect('/admin/producers')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('/admin/producers')->with('data', [ 'message'  => 'Successfully deleted producer', 'type' => 'success' ]);
    }
}
