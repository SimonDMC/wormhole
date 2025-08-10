self.addEventListener("install", (event) => {
    self.skipWaiting();
});

self.addEventListener("push", (event) => {
    const notif = event.data.json();
    // only show notif if less than 1 min old
    if (notif.timestamp > Date.now() - 60 * 1000) {
        event.waitUntil(
            self.registration.showNotification(notif.title, {
                body: notif.text,
                icon: notif.icon,
                data: notif,
                timestamp: notif.timestamp,
            })
        );
    } else {
        console.log("received old notification");
    }
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
