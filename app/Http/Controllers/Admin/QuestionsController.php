<?php

namespace App\Http\Controllers\Admin;

use App\Models\Questions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Questions::all();
        return view('admin.questions.index', [
            'questions' => $questions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.questions.question_form');
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
        $data['show'] = isset($data['show']) ? 1 : 0;

        Questions::firstOrCreate($data);

        return redirect('admin/questions')
            ->with('message', 'Вопрос "'.$request->get('question').'" успешно создан');
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
        $question = Questions::find($id);
        return view('admin.questions.question_form', [
            'question' => $question
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
        unset($data['files']);
        unset($data['_method']);
        $data['show'] = isset($data['show']) ? 1 : 0;

        Questions::where('id', $id)->update($data);

        return redirect('admin/questions')
            ->with('message', 'Вопрос "'.$request->get('question').'" успешно обновлен');
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

        Questions::where('id', $request->get('id'))->delete();

        return redirect('admin/questions')
            ->with('message', 'Вопрос успешно удален');

    }

}
