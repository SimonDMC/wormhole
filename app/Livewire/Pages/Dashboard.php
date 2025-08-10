<?php

namespace App\Livewire\Pages;

use App\Events\RoomDevicesChanged;
use App\Models\Device;
use App\Models\File;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class Dashboard extends Component
{
    use WithFileUploads;

    public $currentDevice;
    public $room;

    public string $url;
    public $file;

    public function mount() {
        $this->currentDevice = Device::find(session('device_id'));
        // not authed to be here
        if ($this->currentDevice == null) {
            session(['device_id' => null]);
            return redirect(route('landing'));
        }

        $this->room = Room::find($this->currentDevice->room_id);
    }

    public function render()
    {
        return view('livewire.pages.dashboard');
    }

    public function rename($name) {
        if (!$name) return;
        $this->currentDevice->name = $name;
        $this->currentDevice->save();
        RoomDevicesChanged::dispatch($this->room);
    }

    public function leave() {
        $this->currentDevice->delete();
        session(['device_id' => null]);
        RoomDevicesChanged::dispatch($this->room);
        
        return redirect(route('dashboard'));
    }

    public function remove($id) {
        $device = Device::findOrFail($id);
        if ($device->room_id == $this->room->id) {
            $device->delete();
            RoomDevicesChanged::dispatch($this->room);
        }
    }

    #[On('echo:rooms.{room.code},RoomDevicesChanged')]
    public function refreshDevices($event) {
        $this->room->refresh();
    }

    private function broadcast($payload) {
        $webPush = new WebPush(['VAPID' => [
            'subject' => env('VAPID_CONTACT'),
            'publicKey' => env('VAPID_PUBLIC_KEY'),
            'privateKey' => env('VAPID_PRIVATE_KEY'),
        ]]);

        foreach ($this->room->devices as $roomDevice) {
            if ($roomDevice->id != $this->currentDevice->id) {
                $webPush->sendOneNotification(Subscription::create([
                    "endpoint" => $roomDevice->endpoint,
                    "keys" => [
                        'p256dh' => $roomDevice->p256dh,
                        'auth' => $roomDevice->auth,
                    ],
                ]), json_encode($payload));
            }
        }
    }

    public function broadcastLink() {
        $url = parse_url($this->url);
        $icon = null;
        if (isset($url['host'])) {
            $icon = 'https://www.google.com/s2/favicons?domain=' . $url['host'] . '&sz=256';
        }

        $this->broadcast([
            'title' => 'Wormhole Link',
            'text' => 'Click to open ' . $this->url . '!',
            'url' => $this->url,
            'icon' => $icon,
            'timestamp' => floor(microtime(true) * 1000),
        ]);
        
        session()->flash('sent-link');
        $this->url = "";
    }

    #[On('file-uploaded')]
    public function broadcastFile() {
        $isImage = in_array($this->file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif']);

        $filename = $this->file->getClientOriginalName();
        $uid = Str::random(10);

        Storage::disk('files')->putFileAs($uid, $this->file, $filename);
        File::create(['uid' => $uid]);

        $icon = null;
        if ($isImage) {
            $icon = route('file.download', [$uid, $filename]);
        }

        $this->broadcast([
            'title' => $isImage ? 'Wormhole Image' : 'Wormhole File',
            'text' => 'Click to open ' . $filename . '!',
            'url' => route('file.download', [$uid, $filename]),
            'icon' => $icon,
            'timestamp' => floor(microtime(true) * 1000),
        ]);
        
        session()->flash('sent-file');
    }
}
