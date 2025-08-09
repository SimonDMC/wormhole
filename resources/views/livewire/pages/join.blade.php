<div class="wrap">
    <button id="subscribe-btn">Enable Notifications</button>
    <div id="name-wrap" class="hidden" wire:ignore>
        <input wire:model="name" id="name" type="text" placeholder="Name this device">
        <div id="name-arrow" class="arrow-btn">
            <x-icons.arrow/>
        </div>
    </div>
    <div id="cant-join" class="error-txt hidden">
        Something went wrong.
    </div>

    <script>
        document.getElementById("name-arrow")?.addEventListener("click", async () => {
            let registration = await navigator.serviceWorker.ready;
            let pushSubscription = await registration.pushManager.getSubscription();

            if (!pushSubscription) {
                document.getElementById("cant-join")?.classList.remove("hidden");
                return;
            }

            @this.call('register', pushSubscription.toJSON());
        });
    </script>
</div>
