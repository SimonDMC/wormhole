@extends('layout.page')

@section('page')
    <div class="transition swipe full-page">
        <h1>How It Works</h1>
        <div class="copy">
            <p>Open a Wormhole to transfer links, images, and files between devices with ease!</p>
            <p>Create a room on one device, then join it on all other devices using a room code.</p>
            <p>Whenever you transfer something, all other devices get a notification.</p>
            <p class="warn">Please download the files you transfer, as they will only stay on the server for an hour.</p>
            <p class="warn">If the website doesn't work on iOS, add it to your home screen first to allow notifications.</p>
            <p><a href="{{ route('landing') }}">Go Back</a></p>
        </div>
    </div>
@endsection