<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/ckeditor/upload', function (Request $request) {
    if ($request->hasFile('upload')) {

        $validator = Validator::make($request->all(), [
            'upload' => 'image|max:1024',
        ], $messages = [
            'upload.image' => 'Uploaded file format is not allowed!',
            'upload.max' => 'Image must be less than 1MB!',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            // CK Editor's required error format
            // See more: https://ckeditor.com/docs/ckeditor5/latest/features/image-upload/simple-upload-adapter.html#error-handling
            return [
                'error' => [
                    'message' => $errors->first('upload'),
                ],
            ];
        }

        $path = $request->file('upload')->store('ckeditor', 'public');

        return ['url' => Storage::url($path)];
    }
})->name('ckeditor.upload');
