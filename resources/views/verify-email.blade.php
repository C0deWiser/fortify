@php
    use Illuminate\Support\Facades\Route;
    use Laravel\Fortify\Fortify;
@endphp

@extends('fortify::layouts.fortify')

@section('title', __('Email Verification'))

@section('content')

    <!-- https://laravel.com/docs/12.x/fortify#email-verification -->

    <h1>@lang('Email Verification')</h1>

    <p class="alert">
        @lang('You have to verify your email before you may continue to the application.')
        <br>
        {!! str(
            __('Your email is `:email`', ['email' => request()->user()->email])
        )->markdown() !!}
    </p>

    @if(Route::has('user-profile-information.show'))
        <p>
            {!! str(
                __('You may change your email at [profile page](:href).', [
                    'href' => route('user-profile-information.show')
                ])
            )->markdown() !!}
        </p>
    @endif

    @if (session('status') == Fortify::VERIFICATION_LINK_SENT)
        @include('fortify::fragments.status')
    @else
        <p>
            @lang('Press a button below and we will send you a new email verification link.')
        </p>
    @endif

    <form method="post" action="{{ route('verification.send') }}">
        @csrf

        <div>
            <button type="submit">@lang('Send verification link')</button>
        </div>

    </form>

@endsection
