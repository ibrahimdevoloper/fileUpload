<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class fileupload extends Controller
{
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpeg,png,jpg,gif,svg'
        ]); if ($validator->fails()) {
            return sendCustomResponse($validator->messages()->first(),  'error', 500);
        }
        $uploadFolder = 'users/images';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageResponse = array(
            "image_path" => $image_uploaded_path,
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
        );
        return response()->json(
            array(
                'message'=>'File Uploaded Successfully',
                'data'=>$uploadedImageResponse
            )
            );
        // return sendCustomResponse('File Uploaded Successfully', 'success',   200, $uploadedImageResponse);
    }
}
