@extends('layout.page')

@section('page')
    <button id="subscribe-btn">Enable Notifications</button>
    <div id="name-wrap" class="hidden">
        <input id="name" type="text" placeholder="Name this device">
        <div id="name-arrow" class="arrow-btn">
            <x-icons.arrow/>
        </div>
    </div>
    <div id="cant-join" class="error-txt hidden">
        Something went wrong.
    </div>
@endsection