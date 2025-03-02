<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ImageUploadTrait {


    // upload new image
    public function uploadImage(Request $request ,$input ,$path) {

        $image_obj = (object)[];
        if($request->hasFile($input)) {

            $image = $request->$input;
            $image_id = uniqid();
            $image_name = $image_id . '.' . $image->extension();
            $image->move(public_path($path) ,$image_name);

            $image_obj->id = $image_id;
            $image_obj->path = $path .''.$image_name;

            return json_encode($image_obj);
        }
    }

    // update image
    public function updateImage(Request $request ,$input ,$path ,$oldPath) {

        if(File::exists(public_path($oldPath))) {

            File::delete(public_path($oldPath));
        }

        $new_path = '';
        if($request->hasFile($input)) {

            $image = $request->$input;
            $image_id = uniqid();
            $image_name = $image_id . '.' . $image->extension();
            $image->move(public_path($path) ,$image_name);

            $new_path = $path .''.$image_name;
        }

        return $new_path;
    }

    //delete image
    public function deleteImage($path) {

        if (File::exists(public_path($path))) {

            File::delete(public_path($path));
        }
    }

}
