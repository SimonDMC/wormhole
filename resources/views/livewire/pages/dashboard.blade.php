<div class="wrap full-page">
    <div class="transition swipe full-page grid">
        <h1>Wormhole</h1>
        <div class="box-row">
            <a id="link-btn" class="box">
                <x-icons.link/>
                Link
            </a>
            <label>
                <a id="file-btn" class="box">
                    <x-icons.file/>
                    File
                </a>
                <input type="file" id="fileUpload" hidden>
            </label>
            <label>
                <a id="image-btn" class="box">
                    <x-icons.image/>
                    Image
                </a>
                <input type="file" accept="image/*" id="imageUpload" hidden>
            </label>
        </div>

        <div id="link-wrap" class="hidden">
            <input wire:model="url" id="link" type="text" placeholder="URL">
            <div wire:click="broadcastLink" id="link-arrow" class="arrow-btn">
                <x-icons.arrow/>
            </div>
        </div>

        <div id="progress-wrap" class="hidden" wire:ignore>
            <div id="progress-inner"></div>
        </div>

        <div id="error-msg" @class(["hidden" => !session()->has('error'), "error-txt"])>
            {{ session('error') }}
        </div>
    </div>

    <div id="bar"></div>
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
                        <span class="device-name" title="{{ e($device->name) }}">
                            {{ e($device->name) }}
                        </span>
                        @if ($device->id == $currentDevice->id)
                            <a wire:click="rename(prompt('Enter a new name'))">
                                <x-icons.edit />
                            </a>
                            <a wire:click="leave">
                                <x-icons.exit />
                            </a>
                        @else
                            <a wire:click="remove({{ $device->id }})">
                                <x-icons.remove />
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @script
    <script>
        addUploadListener(document.getElementById("fileUpload"));
        addUploadListener(document.getElementById("imageUpload"));

        function addUploadListener(input) {
            input.addEventListener("change", () => {
                // limit upload size
                const MAX_MB = {{ config('app.max_single_size_mb') }};
                if(input.files[0].size > MAX_MB * 1024 * 1024) {
                    alert(`Maximum upload size is ${MAX_MB} MB.`);
                    input.value = "";
                    return;
                }

                if (input.files[0]) {
                    document.getElementById("link-wrap")?.classList.add("hidden");
                    document.getElementById("progress-wrap")?.classList.remove("hidden");
                    document.getElementById("progress-inner").style.width = 0;

                    $wire.upload('file', input.files[0], (uploadedFilename) => {
                        Livewire.dispatch('file-uploaded');
                        input.files[0] = null;
                        document.getElementById("progress-wrap")?.classList.add("hidden");
                        // clear only after fully hiding
                        setTimeout(() => {
                            document.getElementById("progress-inner").style.width = 0;
                        }, 300);
                    }, () => {
                        // error
                    }, (event) => {
                        document.getElementById("progress-inner").style.width = `${event.detail.progress}%`;
                    }, () => {
                        // cancelled
                    })
                }
            })
        }
    </script>
    @endscript
</div>