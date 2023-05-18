@extends:.src/:assets/app;

@yield:main;
    <h1 class="text-3xl">{{ $code }} - {{ $title }}</h1>
    <p>{{ $message }}</p>
    @if(_env('APP_DEV')):
        <p>Render time: {{ getrtime() }}s,<br/>Debug: <b>{{ $trace['file'] }}:{{ $trace['line'] }}</b></p>
    @endif
@endyield:main;