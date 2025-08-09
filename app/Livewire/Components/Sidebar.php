<?php

namespace App\Livewire\Components;

use App\Events\RoomDevicesChanged;
use App\Models\Device;
use App\Models\Room;
use Livewire\Attributes\On;
use Livewire\Component;

class Sidebar extends Component
{
    public $currentDevice;
    public $room;

    public function mount() {
        $this->currentDevice = Device::findOrFail(session('device_id'));
        $this->room = Room::findOrFail($this->currentDevice->room_id);
    }

    public function render()
    {
        return view('livewire.components.sidebar');
    }

    public function rename($name) {
        $this->currentDevice->name = $name;
        $this->currentDevice->save();
    }

    public function leave() {
        $this->currentDevice->delete();
        session(['device_id' => null]);
        RoomDevicesChanged::dispatch($this->room);
        
        return redirect(route('dashboard'));
    }

    #[On('echo:rooms.{room.id},RoomDevicesChanged')]
    public function refreshDevices($event) {
        $this->room->refresh();
    }
}
