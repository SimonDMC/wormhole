<div align="center">
    <img src="public/icon.png" height="128" alt="Wormhole Logo">
    <h1 align="center">Wormhole</h1>
</div>

<div align="center">

<em>A simple web app for transferring files and links between devices.</em>

Built with [Laravel](https://laravel.com) and [Vite](https://vite.dev/)!

</div>

## How To Use

A public instance is available at https://wormhole.simondmc.com.

Instructions can be found at https://wormhole.simondmc.com/how-it-works.

## Self-Hosting

These are not exact instructions for how to self-host, but some general tips for getting it work.
I might write a proper guide on how to do so eventually, but it's unlikely.

-   Install [PHP, NodeJS, Laravel and Composer](https://laravel.com/docs/12.x/installation#installing-php)
-   Copy `.env.example` to `.env`
-   Download dependencies by running `composer install`
-   Generate [Laravel Reverb](https://laravel.com/docs/12.x/broadcasting#reverb-manual-installation)
    credentials for sending device join/leave/rename updates via WebSockets
-   Generate [VAPID keys](https://web.dev/articles/push-notifications-web-push-protocol),
    e.g. using the included [web-push-php](https://github.com/web-push-libs/web-push-php) library
    -   `echo "use Minishlink\WebPush\VAPID;VAPID::createVapidKeys()" | php artisan tinker`
-   Fill the VAPID credentials, including a contact URL/email, into `.env`
-   You might have to install [OpenSSL](https://openssl-library.org/) for Web Push to work
-   (Optional) Set up a Discord API compatible webhook URL to receive notifications whenever storage
    fills up
-   Configure a web server to serve the website, including the
    [Laravel Reverb](https://laravel.com/docs/12.x/broadcasting#reverb-manual-installation)
    server. A queue listener is not necessary. I used [nginx](https://nginx.org/), but I'm sure it
    would work with Apache as well. Or run `composer run dev` to start a dev server.

## Motivation

The self-hosting setup may seem daunting, which is partially because I chose to embrace a lot
of technologies for the purposes of learning. The initial reason I started building Wormhole
was because I wanted to get a notification on the other device whenever I transfer something,
and no solution I've used offers that, but it turned more into an educational project.

While building it, I learned a bunch about:

-   Laravel (first personal project using it)
-   Web Push
-   nginx, and generally, system administration
-   [CSS View Transitions](https://developer.mozilla.org/en-US/docs/Web/API/View_Transition_API)
    (especially MPA ones)
-   GitHub actions (first time using those for deployment!)
-   [Pusher](https://pusher.com) / WebSockets

So even though this project may seem a bit pointless and/or overengineered, it was an awesome
learning experience! Also I'm quite proud of the design :)

## Planned Features

Looking ahead, eventually I'd like to add:

-   An in-app UI for receiving files and URLs on mobile, as (at least on iOS) they open in the app
    which is somewhat awkward. Works awesome on desktop though.
-   An ability to transfer multiple files/images at once
-   A way to transfer text
