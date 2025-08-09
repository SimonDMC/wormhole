@extends('layout.page')

@section('page')
    <h1>Wormhole</h1>
    <div class="box-row">
        <a id="link-btn" class="box">
            <x-icons.link/>
            Link
        </a>
        <a id="file-btn" class="box">
            <x-icons.file/>
            File
        </a>
        <a id="image-btn" class="box">
            <x-icons.image/>
            Image
        </a>
    </div>
    <div id="link-wrap" class="hidden">
        <input id="link" type="text" placeholder="URL">
        <div id="name-arrow" class="arrow-btn">
            <x-icons.arrow/>
        </div>
    </div>
    <div id="progress-wrap" class="hidden">
        <div id="progress-inner"></div>
    </div>

    <div id="bar"></div>
    <livewire:components.sidebar/>
@endsection