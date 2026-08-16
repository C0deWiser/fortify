@extends('fortify::layouts.fortify')

@section('title', __('Login to the application'))

@section('content')

    <!-- https://laravel.com/docs/12.x/fortify#authenticating-with-two-factor-authentication -->

    <h1>@lang('Login to the application')</h1>

    @include('fortify::fragments.status')

    <form method="post" action="{{ route('two-factor.login.store') }}">
        @csrf

        <div>
            <label for="code">@lang('Confirmation code')</label>
            <input type="text" name="code" required autofocus autocomplete="one-time-code">

            @error('code')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">@lang('Confirm')</button>
        </div>

    </form>

@endsection
