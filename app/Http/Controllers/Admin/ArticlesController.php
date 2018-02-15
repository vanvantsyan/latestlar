<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TourHelper;
use App\Models\Articles;
use App\Models\ArticlesCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Articles::select('id','title','slug')->get();

        return view('admin.articles.index', [
            'units' => $units
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ArticlesCategories::all();
        $lastId = Articles::orderBy('id', 'desc')->first();
        return view('admin.articles.form', [
            'categories' => $categories,
            'lastId' => $lastId['id'] ?? 0,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['files']);
//        $data['image'] = Session::pull('upload_image');

        // Set url by title if slug not exist
        if(empty($data['slug'])) {
            $data['slug'] = TourHelper::all2url($data['title']);
        }

        $data['description'] = trim($data['description']);
        $data['text'] = trim($data['text']);

        $id = Articles::insertGetId($data);
        return redirect('admin/articles/' . $id . '/edit')
                ->with('message', 'Статья "'.$request->get('title').'"успешно добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $action = camel_case($id);
        if(method_exists($this, $action)){
            return $this->$action($request);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Articles::find($id);
        $categories = ArticlesCategories::all();
        return view('admin.articles.form', [
            'categories' => $categories,
            'item' => $item
        ]);
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
        $data = $request->all();
        $data['description'] = trim($data['description']);
        $data['text'] = trim($data['text']);

        unset($data['_token']);
        unset($data['_method']);
        unset($data['files']);

        Articles::where('id', $id)->update($data);
        return redirect('admin/articles')
            ->with('message', 'Статья "' . $request->get('title') . '"успешно обновлена');
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


    public function delete($request){

        Articles::where('id', $request->get('id'))->delete();
        return redirect('admin/Articles')
            ->with('message', 'Новость успешно удалена');

    }


    public function categories()
    {
        $categories = ArticlesCategories::all();
        return view('admin.Articles.categories', [
            'categories' => $categories
        ]);

    }


    public function createCategory(){

        return view('admin.Articles.category_form');

    }


    public function saveCategory(Request $request)
    {
        ArticlesCategories::create($request->all());
        return redirect('admin/Articles/categories')
            ->with('message', 'Категория "'.$request->get('title').'" успешно создана');
    }


    public function editCategory($id){

        $category = ArticlesCategories::find($id);
        return view('admin.Articles.category_form', [
            'category' => $category
        ]);

    }


    public function updateCategory(Request $request){

        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);
        unset($data['files']);
        ArticlesCategories::where('id', $request->get('id'))->update($data);
        return redirect('admin/Articles/categories')
            ->with('message', 'Категория "'.$request->get('title').'" успешно обновлена');

    }


    public function deleteCategory(Request $request){

        ArticlesCategories::where('id', $request->get('id'))->delete();
        return redirect('admin/Articles/categories')
            ->with('message', 'Категория успешно удалена');

    }


}
