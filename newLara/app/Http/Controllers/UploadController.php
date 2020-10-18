<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request) {
        $file = $request->file('file_to_upload');
        $errs = $file->getError();
        if (!isset($errs) || is_array($errs)) {
            return response("Invalid upload");
        }

        switch ($errs) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return response('No file has been sent');
                break;
            case UPLOAD_ERR_INI_SIZE:
                return response('Maximum file size exceeded');
                break;
            case UPLOAD_ERR_FORM_SIZE:
                return response('Maximum form file size exceeded');
                break;
            default:
                return response('Unknown error');
                break;
        }

        if ($file->getSize() > 4000000) {
            return response('Maximum file size exceeded');
        }

        $imageFileType = $file->extension();

        //$imageFileType = strtolower(pathinfo(FILE_PATH . basename($_FILES['file_to_upload']['name']),PATHINFO_EXTENSION));

        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif' && $imageFileType != 'jpeg') {
            return response('Invalid format');
        }

        if(!$file->storeAs('/', basename($file->getClientOriginalName()), 'public')) {
            return response('Upload failure');
        }
        return response('success');
    }
}
