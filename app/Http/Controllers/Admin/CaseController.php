<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CaseController extends Controller
{

    public function getData()
    {
        $file = public_path("/uploads/morpher.json");

        if (file_exists($file)) {
            $current = file_get_contents($file);
            $data = json_decode($current, true);

        } else {
            $data = [];
        }

        return $data;
    }

    public function list()
    {
        $data = $this->getData();

        return view('admin.case.list', [
            'data' => $data
        ]);

    }

    public function edit($id)
    {

        $data = $this->getData();

        if ($id && count($data)) {

            $i = 1;
            foreach($data as $key => $word) {
                if($i == $id) {
                    return view('admin.case.form', [
                        'word' => $word,
                        'id' => $id,
                        'key' => $key
                    ]);
                }
                $i++;
            }
        }
    }

    public function store(Request $request){

        $post = $request->all();

        $id = $post['id'];
        $wordKey = $post['word'];

        unset($post['id']);
        unset($post['_token']);
        unset($post['word']);

        $data = $this->getData();

        if ($id && count($data)) {

            $i = 1;
            foreach($data as $key => $word) {
                if($i == $id) {

                    foreach($post as $key => $value) {
                        $data[$wordKey][$key] = $value;
                    }
                }
                $i++;
            }

            if(file_put_contents(public_path("/uploads/morpher.json"), json_encode($data))){
                return redirect('admin/cases')->with('message', 'Успешно заменено');
            }
        }

        return redirect('admin/cases')->with('message', 'Что-то не так');
    }
}