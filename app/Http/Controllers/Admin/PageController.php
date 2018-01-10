<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Page;
use JavaScript;
class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('type', 'page')->orderBy('order', 'ASC')->get();
        $faqs = Page::where('type', 'faq')->avg('active');
        $faqs = number_format((float)$faqs);

        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);

        return view('admin.pages.index', compact('pages', 'faqs'));
    }
    public function create()
    {
        return view('admin.pages.create');
    }
    public function edit($id)
    {
        JavaScript::put(['message' => session('data')['message'], 'type' => session('data')['type']]);

        if($id == 'faq')
        {
            $pages = Page::where('type', 'faq')->orderBy('order', 'ASC')->get();

            return view('admin.pages.faq', compact('pages'));
        } elseif($id == 'producer'){
            $pages = Page::where('type', 'producer')->orderBy('order', 'ASC')->get();

            foreach ($pages as $page) {
                $json =  json_decode($page->description);
                $page->description = $json->description;
                $page->file_path = $json->file_path;


            }

            return view('admin.pages.producer', compact('pages'));
        } else {
            $page = Page::find($id);

            return view('admin.pages.edit', compact('page'));
        }
    }

    public function store(Request $request)
    {
        $page = new Page($request->all());
        $page->slug = str_slug($request->title, '-');
        $page->active = 1;

        try {
            $page->save();
        } catch (Exception $e) {
            return redirect('admin/pages/edit/'.$page->id)->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('admin/pages/edit/'.$page->id)->with('data', [ 'message'  => 'Successfully created page', 'type' => 'success']);
    }
    public function faqstore(Request $request)
    {
        $pages = [];
        for($i=0; $i<count($request->title); $i++){
            $pages[] = ['title' =>$request->title[$i],
                'description' => $request->description[$i],
                'order' => $request->order[$i],
                'slug' => str_slug($request->title[$i], '-'),
                'type' => $request->type,
                'active' => 1
            ];
        }
        try{
            Page::insert($pages);
        } catch (Exception $e) {
            return redirect('admin/pages')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('admin/pages/')->with('data', [ 'message'  => 'Successfully created faq', 'type' => 'success']);
    }

    public function faq_update(Request $request)
    {
        $pages = [];

        for($i=0; $i<count($request->id); $i++){

            if( $request->id[$i] != '' )
            {
                $faq = Page::find($request->id[$i]);

                $faq->title = $request->title[$i];
                $faq->slug = str_slug($request->title[$i]);
                $faq->order = $request->order[$i];
                $faq->description = $request->description[$i];
                $faq->type = 'faq';

                try{
                    $faq->save();
                } catch(Exception $ex){
                    return redirect('admin/pages/edit/faq')->with('data', [ 'message'  => $ex->getMessage(), 'type' => 'error']);
                }

            } else {

                $pages[] = ['title' =>$request->title[$i],
                    'description' => $request->description[$i],
                    'order' => $request->order[$i],
                    'slug' => str_slug($request->title[$i], '-'),
                    'type' => 'faq',
                ];

            }

        }
        try{
            Page::insert($pages);
        } catch (Exception $e) {
            return redirect('admin/pages/edit/faq')->with('data', [ 'message'  => $e->getMessage(), 'type' => 'error']);
        }

        return redirect('admin/pages/edit/faq')->with('data', [ 'message'  => 'Successfully updated faq', 'type' => 'success']);

    }

    public function faq_active(Request $request)
    {
        try{
            $page = Page::where('type', 'faq')->update(['active' => $request->active]);

            if( $page == 0 )
            {
                return response()->json(['message' => 'Empty FAQ, can\'t change state', 'type' => 'error']);
            }
        } catch(Exception $ex){
            return response()->json([ 'message'  => $ex->getMessage(), 'type' => 'error']);
        }

        return response()->json(['message' => 'Successfully updated all FAQ states', 'type' => 'success']);
    }
    public function update(Request $request)
    {
        $page = Page::find($request->id)->fill($request->all());
        $page->slug = str_slug($request->title, '-');
        $request->active == '1' ? $page->active = 1 : $page->active = 0 ;

        try {
            $page->save();
        } catch (Exception $e) {
            return redirect('admin/pages/edit/'.$page->id)->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }
        return redirect('admin/pages/edit/'.$page->id)->with('data', [ 'message'  => 'Successfully updated page', 'type' => 'success']);
    }
    public function delete($id, Request $request)
    {
        $page = Page::find($id);
        if($page->id == 1)
        {
            return redirect('admin/pages')->with('data', [ 'message'  => 'Can\'t delete this page', 'type' => 'error']);
        }

        try {
            $page->delete();
        } catch (Exception $e) {
            return redirect('admin/pages')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        if( $request->ajax() )
        {
            return response([ 'message'  => 'Successfully deleted page', 'type' => 'success']);
        } else {
            return redirect('admin/pages')->with('data', [ 'message'  => 'Successfully deleted page', 'type' => 'success']);
        }
    }
    public function image(Request $request)
    {
        $photo = $this->uploadPhoto('images/pages');

        return $photo;
    }
    public function active($id, Request $request)
    {
        $page = Page::find($id);

        $page->active = (int)$request->active;
        try{
            $page->save();
        } catch(Exception $ex){
            return response()->json([ 'message'  => $ex->getMessage(), 'type' => 'error']);
        }

        return response()->json([ 'message'  => 'Successfully updated page', 'type' => 'success', 'active' => $page->active]);
    }
    public function producer_update(Request $request)
    {
        $new_producers = [];

        for($i=0; $i<count($request->id); $i++){

            if( !empty( $request->file_path[$i] ) )
            {
                $file = $this->uploadPhoto($request->file_path[$i], 'images/producers', 360, 360);
            } else {
                $file = null;
            }

            if( $request->id[$i] != '' )
            {
                $producer = Page::find($request->id[$i]);

                $producer->title = $request->title[$i];
                $producer->slug = str_slug($request->title[$i], '-');
                $producer->order = $request->order[$i];

                if( $file == null )
                {
                    $json_data =  json_decode($producer->description);
                    $json_data->description = $request->description[$i];
                    $producer->description = json_encode($json_data);

                } else {
                    $producer->description = '{ "description" : "' . $request->description[$i] . '", "file_path" : "'. $file .'"}';
                }
                $producer->type = 'producer';

                try{
                    $producer->save();
                } catch(Exception $ex){
                    return redirect('admin/pages/edit/faq')->with('data', [ 'message'  => $ex->getMessage(), 'type' => 'error']);
                }

            } else {

                $new_producers[] = [
                                    'title' =>$request->title[$i],
                                    'description' => '{ "description" : "' . $request->description[$i] . '", "file_path" : "'. $file .'" }',
                                    'order' => $request->order[$i],
                                    'slug' => str_slug($request->title[$i], '-'),
                                    'type' => 'producer',
                                    'active' => 1
                                   ];

            }

        }

        try{
            Page::insert($new_producers);
        } catch (Exception $e) {
            return redirect('admin/pages/edit/producer')->with('data', [ 'message'  => $e->getMessage(), 'type' => 'error']);
        }

        return redirect('admin/pages/edit/producer')->with('data', [ 'message'  => 'Successfully updated producers', 'type' => 'success']);
    }
}
