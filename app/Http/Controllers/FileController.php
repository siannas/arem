<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request, $id_user, $id_form, $id_pertanyaan)
    {
        $validator = Validator::make($request->all(), [
            'file'  =>  'required|file|mimetypes:image/jpeg,image/png,application/pdf|max:512'
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $mime = $request->file('file')->getMimeType();
        $pattern = '/[a-zA-Z]+$/' ;
        preg_match($pattern, $mime, $matches);
        $mime = $matches[0];

        $filename = implode("_", [$id_user, $id_form, $id_pertanyaan]).'.'.$mime;
        $path = Storage::putFileAs(
            'public/'.$id_user,
            $request->file('file'),
            $filename
        );
        return response( url('storage/'.$id_user.'/'.$filename) );
    }
}
