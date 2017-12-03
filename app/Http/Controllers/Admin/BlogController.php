<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\BlogFacade as Blog;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Blog::getPosts();
        return view('admin.blog.index', [
            'posts' => json_encode($posts)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Blog::getCategories();
        return view('admin.blog.create', [
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

        $content = [];
        $i=0;
        foreach ($data['step'] as $key=>$step){
            $imgs = isset($data['images_'.($i+1)]) ? $this->moveImages($data['images_'.($i+1)]) : '' ;
            $content[$i] = [
                'title' => $step,
                'text' => $data['text'][$key],
                'images' => $imgs
            ];
            $i++;
        }

        $data['preview'] = isset($data['preview']) ? $this->moveImages($data['preview']) : '' ;
        $data['user_id'] = Auth::user()->id;

        $data['text'] = json_encode($content);
        //$data = Blog::fill($data);

        Blog::create($data);
        return redirect('admin/blog')
                ->with('message', 'Пост "'.$request->get('title').'"успешно создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(!is_numeric($id)){
            $action = camel_case($id);
            if(method_exists($this, $action)){
                return $this->$action($request);
            }
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Blog::find($id);
        $categories = Blog::getCategories();
        return view('admin.blog.create', [
            'categories' => $categories,
            'post' => $post
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

        $content = [];
        $i=0;
        foreach ($data['step'] as $key=>$step){
            $imgs = isset($data['images_'.($i+1)]) ? $this->moveImages($data['images_'.($i+1)]) : '' ;
            $content[$i] = [
                'title' => $step,
                'text' => $data['text'][$key],
                'images' => $imgs
            ];
            $i++;
        }

        $data['preview'] = isset($data['preview']) ? $this->moveImages($data['preview']) : '' ;
        $data['user_id'] = Auth::user()->id;

        $data['text'] = json_encode($content);

        Blog::updatePost($data, $id);
        return redirect('admin/blog')
                ->with('message', 'Пост "'.$request->get('title').'" успешно обновлен');
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


    public function categories(){

        $categories = Blog::getCategories();
        return view('admin.blog.category_list', [
            'categories' => json_encode($categories)
        ]);

    }


    public function categoriesCreate(){

        return view('admin.blog.category_form', [

        ]);

    }


    public function saveCategory(Request $request){

        Blog::saveCategory($request->all());
        return redirect('admin/blog/categories')
                ->with('message', 'Категория "'.$request->get('title').'"успешно создана');

    }

    public function editCategory($id){

        $category = Blog::getCategory($id);
        return view('admin.blog.category_form', [
            'category' => $category
        ]);

    }


    public function updateCategory(Request $request, $id){

        Blog::updateCategory($request->all(), $id);
        return redirect('admin/blog/categories')
            ->with('message', 'Категория "'.$request->get('title').'"успешно обновлена');

    }

    public function deleteCategory(Request $request, $id){

        Blog::deleteCategory($id);
        return redirect('admin/blog/categories')
            ->with('message', 'Категория "'.$request->get('title').'"успешно удалена');

    }


    public function delete($request){

        Blog::deletePost($request->get('id'));

        return redirect('admin/blog')
            ->with('message', 'Пост успешно удален');
    }


    public function moveImages($images){

        if(is_array($images)) {
            foreach ($images as $image) {
                if(strpos($image, '/uploads/blog/') === false) {
                    $img[] = ImageHelper::moveTempFile('/uploads/tmp/' . $image, 'blog', config('images.blog'));
                }else{
                    $img[] = $image;
                }
            }
        }else{
            if(strpos($images, '/uploads/blog/') === false) {
                $img = ImageHelper::moveTempFile('/uploads/tmp/' . $images, 'blog', config('images.blog'));
            }else{
                $img = $images;
            }
        }

        return isset($img) ? $img : [];

    }

}
