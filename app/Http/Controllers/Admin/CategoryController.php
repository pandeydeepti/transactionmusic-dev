<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Taxonomy;
use App\ShopOption;
use JavaScript;
use DB;

class CategoryController extends Controller
{
    private function check_last_cat($tax_id)
    {
        $active = [];
        $taxonomy = Taxonomy::with('categories')->find($tax_id);

        foreach ($taxonomy->categories as $cat) {
            $cat->active ? array_push($active, $cat->title) : '';
        }
        if(count($active) == 1){
            return [
                'state' => 0,
                'taxonomy' => $taxonomy->name
            ];
        }
        return ['state' => 1 ];
    }
    public function active($id, Request $request)
    {
        $category = Category::with('taxonomies')->find($id);
        $category->active = (int)$request->active;

        if(!$category->active && $this->check_last_cat($category->taxonomies->first()['id'])['state'] == 0 ){
            return response()->json(['message'  => $category->title . ' is last active category in '. $category->taxonomies->first()['name'], 'type' => 'error']);
        }

        try{
            $category->save();
        } catch(Exception $ex){
            return response()->json([ 'message'  => $ex->getMessage(), 'type' => 'error']);
        }

        return response()->json([ 'message'  => 'Successfully updated category state', 'type' => 'success', 'active' => $category->active]);
    }
    public function index()
    {
        $categories = DB::table('categories')->select(DB::raw('(categories.title) AS Category, categories.id, categories.active, GROUP_CONCAT(taxonomies.name) AS Taxonomies'))
            ->join('category_taxonomies', 'categories.id', '=', 'category_taxonomies.category_id')
            ->join('taxonomies', 'category_taxonomies.taxonomy_id', '=', 'taxonomies.id')
            ->where('categories.title', '!=', 'uncategorized')
            ->groupBy('Category')->orderBy('categories.active', 'desc')->get();
        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);

        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return View('admin.categories.create', ['taxonomies' => Taxonomy::all()]);
    }
    public function edit($id)
    {
        $category = Category::with('taxonomies')->find($id);

        if($category->cover != null)
            $category->cover = 'background-image: url("'.$category->cover.'");';

        JavaScript::put(['message' => session('data')['message'] ,'type' => session('data')['type']]);


        return View('admin.categories.edit', ['taxonomies' => Taxonomy::all()->toArray(), 'category' => $category]);
    }

    public function store(Request $request)
    {
        $category = new Category($request->all());
        if($request->hasFile('cover')){
            $category->cover = $this->uploadPhoto($request->file()['cover'], 'images/categories', 200, 200);
        } else {
            $category->cover = ShopOption::where('meta_key', 'category_thumbnail_path')->first()['meta_value'];
        }
        $category->save();
        $taxonomy = Taxonomy::find($request->taxonomy_id);
        $category->taxonomies()->attach($taxonomy);
        if($request->ajax())
        {
            return response()->json(['code' => 200, 'status' => 'Success']);
        } else {
            return redirect('admin/categories/edit/'.$category->id)->with('data', [ 'message'  => 'Successfully created category', 'type' => 'success']);
        }
    }
    public function update(Request $request)
    {
        $category = Category::find($request->id)->fill($request->all());

        if( $category->active == 0 ){
            $check = $this->check_last_cat($request->taxonomy_id);

            if( $check['state'] == 0 )
                return redirect('admin/categories/edit/'.$category->id)->with('data', [ 'message'  => $category->title . ' is last active category in '. $check['taxonomy'], 'type' => 'error']);
        }
        if( $request->hasFile('cover') ){

            $category->cover = $this->uploadPhoto($request->file()['cover'], 'images/categories');
        } else {
            $category->cover = ShopOption::where('meta_key', 'category_thumbnail_path')->first()['meta_value'];
        }
        $taxonomy = [$request->taxonomy_id];
        $category->taxonomies()->sync($taxonomy);

        try {
            $category->save();
        }
        catch (Exception $e) {
            return redirect('/admin/categories/edit/'.$category->id.'')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('/admin/categories/edit/'.$category->id.'')->with('data', [ 'message'  => 'Successfully updated category', 'type' => 'success' ]);
    }

    public function delete($id)
    {
        $category = Category::with('taxonomies')->find($id);

        if($this->check_last_cat($category->taxonomies->first()['id'])['state'] == 0 ){
            return redirect('/admin/categories')->with('data', ['message'  => $category->title . ' is last active category in '. $category->taxonomies->first()['name'], 'type' => 'error']);
        }

        $category->taxonomies()->detach($id);
        try {
            $category->delete();
        } catch (Exception $e) {
            return redirect('/admin/categories')->with('data', [ 'message'  => 'Failed', 'type' => 'error']);
        }

        return redirect('/admin/categories')->with('data', [ 'message'  => 'Successfully deleted category', 'type' => 'success' ]);
    }
}
