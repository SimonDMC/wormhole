@extends('layout.page')

@section('page')
    <div class="transition swipe full-page">
        <h1>Privacy Policy</h1>
        <div class="copy">
            <p>All file uploads are stored temporarily for a maximum duration of 2 hours, and get 
                permanently deleted afterwards.</p>
            <p>Text/URLs shared via Wormhole are not stored at all.</p>
            <p>No data about your device is stored and no telemetry is collected.</p>
            <p>To delete all traces of your app usage from the Wormhole server, including device name, 
                leave your current room using the <x-icons.exit/> icon.</p>
            <p>All cookies used are strictly necessary for the app to function.</p>
            <p><a href="{{ route('landing') }}">Go Back</a></p>
        </div>
    </div>
@endsection