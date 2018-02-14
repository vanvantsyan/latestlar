<?php

namespace App\Http\Controllers;

use App\Models\Ways;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Helpers\ImageHelper;
use App\Helpers\BladeHelper;

class ImageController extends Controller
{

    public function uploadImages(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $image_name = md5(time() . "-" . $file->getClientOriginalName()) . '.' . $ext;
        $file->move('uploads/tmp', $image_name);
        $image = Image::make(sprintf('uploads/tmp/%s', $image_name))->save();

        return json_encode([
            'success' => 200,
            'filename' => $image_name
        ]);
    }

    public function saveFor(Request $request)
    {

        $image = $request->file('file');
        $imgObj = Image::make($image);
        $imageName = time() . '.jpg';

        $essence = $request->ess;

        $modelName = "App\Models\\" . $essence;
        $unit = $modelName::find($request->id);

        $folderFullPath = public_path('img\\' . strtolower($essence) . '\full');

        if (!File::exists($folderFullPath)) {
            File::makeDirectory($folderFullPath, $mode = 0777, true, true);
        }

        if ($imgObj->width() > 600) {

            $imgObj->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save($folderFullPath . '/' . $imageName, 100);

        $folderThumbPath = public_path('img\\' . strtolower($essence) . '\thumbs');

        if (!File::exists($folderThumbPath)) {
            File::makeDirectory($folderThumbPath, $mode = 0777, true, true);
        }

        if ($imgObj->height() > 235) {

            $imgObj->resize(null, 235, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save($folderThumbPath . '/' . $imageName, 75);

        $images = json_decode($unit->images);
        $imagesList = count($images) ? get_object_vars($images) : [];
        $imagesList[] = $imageName;

        $unit->images = json_encode($imagesList);

        if ($unit->save()) {
            return response()->json(['success' => $imageName]);
        } else {
            return response()->json(['error' => 'images not saved', 'success' => 0]);
        }
    }

    public function removeImage(Request $request)
    {

        $essence = $request->ess;

        $modelName = "App\Models\\" . $essence;
        $unit = $modelName::find($request->id);

        $imList = json_decode($unit->images);

        $images = count($imList) ? $imList : [];

        foreach ($images as $key => $value) {
            if ($value == $request->name) unset($images[$key]);
        }

        $unit->images = json_encode($images);

        if ($unit->save()) {
            File::delete(public_path('/img/' . strtolower($essence) . '/full/' . $request->name));
            File::delete(public_path('/img/' . strtolower($essence) . 'thumbs/' . $request->name));
        }
    }

    public function getImages(Request $request)
    {
        $essence = $request->ess;

        $modelName = "App\Models\\" . $essence;
        $unit = $modelName::find($request->id);

        $dropzone = [];
        $images = json_decode($unit->images);
        if (count($images)) {
            foreach ($images as $image) {

                $filePath = public_path('/img/' . strtolower($essence) . '/full/' . $image);

                if (File::exists($filePath)) {

                    $obj = [];

                    $obj['name'] = $image;
                    $obj['size'] = File::size($filePath);
                    $obj['thumb'] = '/img/' . strtolower($essence) . '/full/' . $image;

                    $dropzone[] = $obj;
                }

            }
        }
        return json_encode($dropzone);
    }


}
