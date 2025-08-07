@extends('layout.page')

@section('page')
    <div class="copy">
        <p>Notifications are not supported.</p>
        <p>If you're on iOS, add this website to your home screen first.</p>
    </div>
    <script>
        if('PushManager' in window){
            window.location.href = "{{ route('landing') }}"
        }
    </script>
@endsection