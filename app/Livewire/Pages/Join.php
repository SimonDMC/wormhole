<?php

namespace App\Livewire\Pages;

use App\Events\RoomDevicesChanged;
use App\Models\Device;
use App\Models\Room;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Join extends Component
{
    public string $code;

    #[Validate('required|string')]
    public string $name;

    public function mount($code) {
        $this->code = $code;
    }

    public function render()
    {
        return view('livewire.pages.join');
    }

    public function register($pushData) {
        $this->validate();

        $room = Room::where(['code' => $this->code])->firstOrFail();
        $device = Device::create([
            'room_id' => $room->id,
            'name' => $this->name,
            'endpoint' => $pushData['endpoint'],
            'p256dh' => $pushData['keys']['p256dh'],
            'auth' => $pushData['keys']['auth'],
            'is_mobile' => preg_match('/(iPhone|iPad|Android)/', request()->userAgent()),
        ]);

        session(['device_id' => $device->id]);
        
        RoomDevicesChanged::dispatch($room);

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

        return redirect(route('dashboard'));
    }
}
