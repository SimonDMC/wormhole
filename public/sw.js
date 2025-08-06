self.addEventListener("install", (event) => {
    self.skipWaiting();
});

self.addEventListener("push", (event) => {
    const obj = event.data.json();
    event.waitUntil(
        self.registration.showNotification(obj.title, {
            body: obj.text,
            data: obj,
        })
    );
});

self.addEventListener(
    "notificationclick",
    (event) => {
        event.notification.close();
        if (event.notification.data.url)
            clients.openWindow(event.notification.data.url);
    },
    false
);
