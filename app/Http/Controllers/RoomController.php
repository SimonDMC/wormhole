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

    public function register(Request $request) {
        $json = $request->json()->all();

        $device = Device::create([
            'room_id' => Room::where(['code' => $json['code']])->firstOrFail()->id,
            'name' => $json['name'],
            'endpoint' => $json['endpoint'],
            'p256dh' => $json['keys']['p256dh'],
            'auth' => $json['keys']['auth'],
            'is_mobile' => preg_match('/(iPhone|iPad|Android)/', $request->userAgent()),
        ]);

        session(['device_id' => $device->id]);

        /* $subscription = Subscription::create([
              "endpoint" => $device->endpoint,
              "keys" => [
                  'p256dh' => $device->p256dh,
                  'auth' => $device->auth,
              ],
        ]);

        $webPush = new WebPush(['VAPID' => [
            'subject' => env('VAPID_CONTACT'),
            'publicKey' => env('VAPID_PUBLIC_KEY'),
            'privateKey' => env('VAPID_PRIVATE_KEY'),
        ]]);
        $webPush->sendOneNotification($subscription, json_encode([
            'title' => 'Hello!',
            'text' => 'Encrypted body content',
            'url' => 'https://example.com',
        ])); */

        return response('OK', 200);
    }
}
