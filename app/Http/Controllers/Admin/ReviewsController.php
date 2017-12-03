<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reviews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Reviews::all();
        return view('admin.reviews.index', [
            'reviews' => $reviews
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reviews.review_form');
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
        $data['created_at'] = date('Y-m-d', strtotime($data['date_pub']));
        unset($data['date_pub']);
        $data['moderation'] = isset($data['moderation']) && $data['moderation'] == 'on' ? 1 : 0;
        Reviews::firstOrCreate($data);
        return redirect('admin/reviews')
                ->with('message', 'Отзыв успешно добавлен');
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
        $review = Reviews::find($id);
        return view('admin.reviews.review_form', [
            'review' => $review
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
        $data['created_at'] = date('Y-m-d', strtotime($data['date_pub']));
        unset($data['date_pub']);
        $data['moderation'] = isset($data['moderation']) && $data['moderation'] == 'on' ? 1 : 0;
        Reviews::where('id', $id)->update($data);
        return redirect('admin/reviews')
            ->with('message', 'Отзыв успешно обновлен');
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

        Reviews::where('id', $request->get('id'))->delete();
        return redirect('admin/reviews')
            ->with('message', 'Отзыв успешно удален');

    }

}
