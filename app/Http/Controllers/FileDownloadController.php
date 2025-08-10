<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function download($uid, $filename) {
        $filePath = $uid . '/' . $filename;

        if (Storage::disk('files')->exists($filePath)) {
            return response()->file(Storage::disk('files')->path($filePath));
        }

        abort(404);
    }
}
