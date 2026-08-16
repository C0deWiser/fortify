@extends('fortify::layouts.fortify')

@section('title', __('Requesting a Password Reset Link'))

@section('content')

    <!-- https://laravel.com/docs/12.x/fortify#requesting-a-password-reset-link -->

    <h1>@lang('Requesting a Password Reset Link')</h1>

    @include('fortify::fragments.status')

    <form method="post" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" required autofocus autocomplete="email" value="{{ old('email') }}">

            @error('email')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>

    </form>

@endsection
