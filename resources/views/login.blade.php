@php
    use Laravel\Fortify\Features;
@endphp

@extends('fortify::layouts.fortify')

@section('title', __('Authentication'))

@section('content')

    <!-- https://laravel.com/docs/12.x/fortify#authentication -->

    <h1>@lang('Authentication')</h1>

    @include('fortify::fragments.status')

    <form method="post" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" id="email" required autofocus autocomplete="email webauthn" value="{{ old('email') }}">

            <div class="invalid">@error('email'){{ $message }}@enderror</div>
        </div>

        <div>
            <label for="password">@lang('Password')</label>
            <input type="password" name="password" id="password" required autocomplete="current-password">

            @error('password')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">@lang('Remember me')</label>
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>

    </form>

    @if(Features::canManagePasskeys())

        <div id="passkeyLogin"
             data-options-url="{{ route('passkey.login-options') }}"
             data-login-url="{{ route('passkey.login') }}"
             hidden></div>

        @push('scripts')
            <script src="/vendor/fortify/passkeys.js" defer></script>
            <script src="/vendor/fortify/login.js" defer></script>
        @endpush

    @endif

@endsection