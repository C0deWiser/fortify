@php
    use Illuminate\Support\Facades\Route;
@endphp
@if(! isset($when) || $when)
    <a href="{{ route($route) }}" @if(Route::is($route)) class="active" @endif>{{ $slot }}</a>
@endif