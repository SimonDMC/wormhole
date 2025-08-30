@extends('layout.page')

@section('page')
    <h1>Wormhole</h1>
    <div class="box-row">
        <a href="{{ route('room.create') }}" class="box">
            <x-icons.room-create/>
            Create
        </a>
        <a id="join-btn" class="box">
            <x-icons.room-join/>
            Join
        </a>
    </div>
    <div id="join" class="hidden">
        <input id="join-code" type="text" placeholder="Room Code" maxlength="9">
        <div id="join-arrow" class="arrow-btn">
            <x-icons.arrow/>
        </div>
    </div>
    <div id="invalid-code" class="error-txt hidden">
        Invalid room code.
    </div>
    <a id="how-link" href="{{ route('how-it-works') }}">
        ?
    </a>
@endsection