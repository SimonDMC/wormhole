<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function create(Request $request) {
        $code = Str::random(9);

        Room::create(['code' => $code]);

        return redirect(route('room.join', $code));
    }

    public function check(Request $request) {
        $code = $request->route('code');

        if (Room::where(['code' => $code])->exists())
            return response('OK');
        
        abort(404);
    }
}
