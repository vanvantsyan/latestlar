<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\NewsCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::with('categories')->get();
        return view('admin.news.index', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = NewsCategories::all();
        return view('admin.news.news_form', [
            'categories' => $categories
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
        $data['image'] = Session::pull('upload_image');
        News::insert($data);
        return redirect('admin/news')
                ->with('message', 'Новость "'.$request->get('title').'"успешно добавлена');
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
        $item = News::find($id);
        $categories = NewsCategories::all();
        return view('admin.news.news_form', [
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
        unset($data['_token']);
        unset($data['_method']);
        unset($data['files']);
        News::where('id', $request->get('id'))->update($data);
        return redirect('admin/news')
            ->with('message', 'Новость "'.$request->get('title').'"успешно обновлена');
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

        News::where('id', $request->get('id'))->delete();
        return redirect('admin/news')
            ->with('message', 'Новость успешно удалена');

    }


    public function categories()
    {
        $categories = NewsCategories::all();
        return view('admin.news.categories', [
            'categories' => $categories
        ]);

    }


    public function createCategory(){

        return view('admin.news.category_form');

    }


    public function saveCategory(Request $request)
    {
        NewsCategories::create($request->all());
        return redirect('admin/news/categories')
            ->with('message', 'Категория "'.$request->get('title').'" успешно создана');
    }


    public function editCategory($id){

        $category = NewsCategories::find($id);
        return view('admin.news.category_form', [
            'category' => $category
        ]);

    }


    public function updateCategory(Request $request){

        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);
        unset($data['files']);
        NewsCategories::where('id', $request->get('id'))->update($data);
        return redirect('admin/news/categories')
            ->with('message', 'Категория "'.$request->get('title').'" успешно обновлена');

    }


    public function deleteCategory(Request $request){

        NewsCategories::where('id', $request->get('id'))->delete();
        return redirect('admin/news/categories')
            ->with('message', 'Категория успешно удалена');

    }


}
