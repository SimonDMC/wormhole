<div id="side">
    <div id="room-code-text">Room code: <code id="room-code">
        {{ $room->code }}
    </code></div>
    <div id="devices">
        <div id="devices-head">Devices</div>
        <div id="devices-body">
            @foreach ( $room->devices as $device)
                <div class="device">
                    @if ($device->is_mobile)
                        <x-icons.mobile />
                    @else
                        <x-icons.desktop />
                    @endif
                    <span class="device-name">{{ e($device->name) }}</span>
                    @if ($device->id == $currentDevice->id)
                        <a id="edit-name" wire:click="rename(prompt('Enter a new name'))">
                            <x-icons.edit />
                        </a>
                        <div id="leave-room" wire:click="leave">
                            <x-icons.exit />
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>