import "./bootstrap";
import "../css/app.css";

navigator.serviceWorker.register("/sw.js");

const csrfToken = (
    document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement
).content;

// joining room //

document.getElementById("join-btn")?.addEventListener("click", () => {
    document.getElementById("join")?.classList.toggle("hidden");
    document.getElementById("join-code")?.focus();
});

document
    .getElementById("join-code")
    ?.addEventListener("keydown", (e: KeyboardEvent) => {
        document.getElementById("invalid-code")?.classList.add("hidden");
        if (e.key == "Enter") document.getElementById("join-arrow")?.click();
    });

document.getElementById("join-arrow")?.addEventListener("click", async () => {
    const input = document.getElementById("join-code") as HTMLInputElement;
    const res = await fetch(`/check/${input.value}`);
    if (res.ok) window.location.href = `/join/${input.value}`;
    else document.getElementById("invalid-code")?.classList.remove("hidden");
});

// setting up //

const base64UrlToUint8Array = (base64UrlData: string) => {
    const padding = "=".repeat((4 - (base64UrlData.length % 4)) % 4);
    const base64 = (base64UrlData + padding)
        .replace(/-/g, "+")
        .replace(/_/g, "/");

    const rawData = atob(base64);
    const buffer = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        buffer[i] = rawData.charCodeAt(i);
    }

    return buffer;
};

document
    .getElementById("subscribe-btn")
    ?.addEventListener("click", async () => {
        let registration = await navigator.serviceWorker.ready;
        let pushSubscription = await registration.pushManager.getSubscription();

        if (!pushSubscription) {
            try {
                pushSubscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: base64UrlToUint8Array(
                        (
                            document.querySelector(
                                'meta[name="vapid-public-key"]'
                            ) as HTMLMetaElement
                        ).content
                    ),
                });
            } catch (e) {
                console.error(e);
                return false;
            }
        }

        document.getElementById("name-wrap")?.classList.remove("hidden");
        document.getElementById("name")?.focus();
    });

document
    .getElementById("name")
    ?.addEventListener("keydown", (e: KeyboardEvent) => {
        if (e.key == "Enter") document.getElementById("name-arrow")?.click();
    });

// dashboard //

document.getElementById("link-btn")?.addEventListener("click", () => {
    document.getElementById("link-wrap")?.classList.toggle("hidden");
    document.getElementById("link")?.focus();
});

const roomCode = document.getElementById("room-code");
let copyUnclickable = false;
roomCode?.addEventListener("click", () => {
    if (copyUnclickable) return;

    const code = roomCode.innerHTML;
    navigator.clipboard.writeText(code.trim());
    roomCode.innerHTML = "&nbsp;Copied!&nbsp;";
    copyUnclickable = true;

    roomCode.onmouseleave = () => {
        setTimeout(() => {
            roomCode.innerHTML = code;
            copyUnclickable = false;
        }, 300);
    };
});
