<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Blog extends Model
{


    protected $table = 'posts';
    protected $fillable = ['category_id', 'title', 'description', 'text', 'h1_title', 'seo_title', 'seo_desc', 'seo_keys', 'slug', 'preview', 'tags', 'user_id'];

    public function categories()
    {
        return $this->hasOne(BlogCategory::class, 'category_id','id');
    }

    public function saveCategory($data){

        unset($data['_token']);
        unset($data['files']);
        $data['private'] = isset($data['private']) && $data['private'] == 'on' ? 1: 0;
        return DB::table('posts_categories')->insert($data);

    }


    public function getCategories(){

        return DB::table('posts_categories')->get();

    }


    public function getCategory($id){

        return DB::table('posts_categories')->where('id', $id)->first();

    }


    public function updateCategory($data, $id){

        unset($data['_token']);
        unset($data['files']);
        $data['private'] = isset($data['private']) && $data['private'] == 'on' ? 1: 0;
        return DB::table('posts_categories')->where('id', $id)->update($data);

    }



    public function deleteCategory($id){

        return DB::table('posts_categories')->where('id', $id)->delete();

    }


    public function getPosts(){

        return DB::table('posts')
                    ->leftJoin('posts_categories as cat', 'posts.category_id', '=', 'cat.id')
                    ->select('posts.id', 'posts.title', 'cat.title as cat_title', 'cat.slug as cat_slug')
                    ->orderBy('id', 'ASC')
                    ->get();

    }


    public function updatePost($data, $id){

        $data = $this->fill($data)->toArray();
        return $this->where('id', $id)->update($data);

    }

    public function deletePost($id){

        return DB::table('posts')->where('id', $id)->delete();

    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // TODO
    public function getAuthorAttribute()
    {
        return 'Иван Иванов';
    }

    // TODO
    public function getImageAttribute()
    {
        return '/img/blog_wr.jpg';
    }


    public static function relationPosts($id)
    {
        return self::where('posts.id', '!=', $id)
            ->limit(3)
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->select('users.name', 'posts.*')
            ->get();
    }


}
