<?php

namespace App\Http\Controllers\Admin;

use App\SoundLike;
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

class SoundLikeController extends Controller
{

    public function active($id, Request $request)
    {
        $soundlike = SoundLike::find($id);
        $soundlike->active = (int)$request->active;

        try{
            $soundlike->save();
        } catch(Exception $ex){
            return response()->json([ 'message'  => $ex->getMessage(), 'type' => 'error']);
        }

        return response()->json([ 'message'  => 'Successfully updated sounds like state', 'type' => 'success', 'active' => $soundlike->active]);
    }
    public function index()
    {
        $soundlikes = DB::table('sound_likes')->select(DB::raw('(sound_likes.title) AS Soundlike, sound_likes.id, sound_likes.active'))
                    ->orderBy('sound_likes.active', 'desc')->get();
        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);

        return view('admin.soundLikes.index', ['soundlikes' => $soundlikes]);
    }
    public function create()
    {
        return View('admin.soundLikes.create');
    }
    public function edit($id)
    {
        $soundlike = SoundLike::find($id);

        if($soundlike->cover != null)
            $soundlike->cover = 'background-image: url("'.$soundlike->cover.'");';

        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);

        return View('admin.soundLikes.edit', ['soundlike' => $soundlike]);
    }
    public function store(Request $request)
    {
        $soundlike = new SoundLike($request->all());
        if($request->hasFile('cover')){
            $soundlike->cover = $this->uploadPhoto($request->file()['cover'], 'images/sound_likes', 200, 200);
        } else {
            $soundlike->cover = ShopOption::where('meta_key', 'producer_thumbnail_path')->first()['meta_value'];
        }

        if (SoundLike::where('title', '=', Input::get('title'))->exists()) 
        {
            return redirect('/admin/sounds_like/')->with('data', [ 'message'  => 'Sounds like already exists', 'type' => 'error']);
        }else{
            $soundlike->save();
        }
        
        if($soundlike->save())
        {
            return redirect('/admin/sounds_like/edit/'.$soundlike->id.'')->with('data', [ 'message'  => 'Successfully created sounds like', 'type' => 'success']);
        } else {
            return redirect('/admin/sounds_like/edit/'.$soundlike->id.'')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }
    }
    public function update(Request $request)
    {
        
        $soundlike = SoundLike::find($request->id)->fill($request->all());

        if( $request->hasFile('cover') ){

            $soundlike->cover = $this->uploadPhoto($request->file()['cover'], 'images/sound_likes');
        } else {
            $soundlike->cover = ShopOption::where('meta_key', 'producer_thumbnail_path')->first()['meta_value'];
        }
        
       
        try {
                $soundlike->save();
        }
        catch (Exception $e) {
            return redirect('/admin/sounds_like/edit/'.$soundlike->id.'')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('/admin/sounds_like/edit/'.$soundlike->id.'')->with('data', [ 'message'  => 'Successfully updated sounds like', 'type' => 'success' ]);
    }
}
