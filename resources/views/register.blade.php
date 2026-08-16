@extends('fortify::layouts.fortify')

@section('title', __('Registration'))

@section('content')

    <!-- https://laravel.com/docs/12.x/fortify#registration -->

    <h1>@lang('Registration')</h1>

    @include('fortify::fragments.status')

    <form method="post" action="{{ route('register') }}" id="registerForm">
        @csrf

        <div>
            <label for="name">@lang('Name')</label>
            <input type="text" name="name" required autofocus autocomplete="name" value="{{ old('name') }}">

            @error('name')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" required autocomplete="email" value="{{ old('email') }}">

            @error('email')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">@lang('Password')</label>
            <input type="password" name="password" required autocomplete="new-password">

            @error('password')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">@lang('Password confirmation')</label>
            <input type="password" name="password_confirmation" required>

            @error('password_confirmation')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>

    </form>

@endsection
