<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper;

class ImageController extends Controller
{

    public function uploadImages(Request $request){
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $image_name = md5(time()."-".$file->getClientOriginalName()) . '.' . $ext;
        $file->move('uploads/tmp', $image_name);
        $image = Image::make(sprintf('uploads/tmp/%s', $image_name))->save();

        return json_encode([
            'success' => 200,
            'filename' => $image_name
        ]);
    }

}
