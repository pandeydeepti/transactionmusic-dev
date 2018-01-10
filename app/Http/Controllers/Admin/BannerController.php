<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\View;
use JavaScript;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        foreach ($banners as $banner) {
            if(!empty($banner->file_path)){
                $banner->file_path = 'background-image: url("'.$banner->file_path.'");';
            }
        }
        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);
        return View('admin.banners.index', ['banners' => $banners]);
    }

    public function update(Request $request)
    {
        $banners = [];

        for ($i = 0; $i < count($request->name); $i++) {

            $banner = Banner::where('name', $request->name[$i])->first();
            $banner_file_path = !empty( $request->banner[$i] ) ? $this->uploadPhoto($request->banner[$i], 'images/banners') : null;

            if( $banner == null )
            {
                $banners[] = [
                    'name' => $request->name[$i],
                    'file_path' => $banner_file_path,
                    'url' => !empty( $request->url[$i] ) ? $request->url[$i] : null
                ];
            } else {
                $banner->name = $request->name[$i];
                !empty( $request->url[$i] ) ? $banner->url = $request->url[$i] : '';
                !empty( $request->banner[$i] ) ? $banner->file_path = $banner_file_path : '';

                try{
                    $banner->save();
                } catch(Exception $ex){
                    return redirect('/admin/banners')->with('data', [ 'message'  => $ex->getMessage(), 'type' => 'error']);
                }
            }
        }

        if( !empty($banners) )
        {
            try{
                Banner::insert($banners);
            } catch(Exception $ex){
                return redirect('/admin/banners')->with('data', [ 'message'  => $ex->getMessage(), 'type' => 'error']);
            }
        }

        return redirect('/admin/banners')->with('data', [ 'message'  => 'Successfully updated banners', 'type' => 'success']);


    }

    public function delete($id)
    {
        $banner = Banner::find($id);
        $banner->url = null;
        $banner->file_path = null;
        try{
            $banner->save();
        } catch(Exception $ex){
            $ex->getMessage();
            return response()->json([ 'status' => 'error', 'message' => $ex->getMessage() ]);
        }

        return response()->json([ 'status' => 'success', 'message' => 'Successfully deleted '. $banner->name .' banner' ]);
    }
}
