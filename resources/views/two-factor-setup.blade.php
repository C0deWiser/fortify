@php
    use Laravel\Fortify\Fortify;
@endphp

@extends('fortify::layouts.fortify')

@section('title', __('Two-factor authentication'))

@section('content')

    <h1>@lang('Two-factor authentication')</h1>

    @include('fortify::fragments.status')

    @if (request()->user()->hasEnabledTwoFactorAuthentication())

        <!-- https://laravel.com/docs/12.x/fortify#displaying-the-recovery-codes -->

        <p class="notice">
            @lang('These recovery codes allow the user to authenticate if they lose access to their mobile device.')
        </p>
        <ul class="focus" style="list-style: none; padding: 0">
            @foreach (request()->user()->recoveryCodes() as $code)
                <li><code>{{ $code }}</code></li>
            @endforeach
        </ul>

        <form method="post" action="{{ route('two-factor.recovery-codes') }}">
            @csrf

            <div>
                <button type="submit">@lang('Refresh recovery codes')</button>
            </div>
        </form>

        <!-- https://laravel.com/docs/12.x/fortify#disabling-two-factor-authentication -->

        <form method="post" action="{{ route('two-factor.disable') }}">
            @csrf
            @method('delete')

            <div>
                <button type="submit">@lang('Disable 2FA')</button>
            </div>
        </form>

    @else

        <!-- https://laravel.com/docs/12.x/fortify#enabling-two-factor-authentication -->

        @error('code', 'confirmTwoFactorAuthentication')
        @php
            // If user passes wrong code, we should keep showing 'confirm' form
            session()->now('status', Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED)
        @endphp
        @enderror

        @if (session('status') == Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED)

            <p class="notice">
                @lang('Please finish configuring two factor authentication below.')
            </p>

            <p class="focus">
                <a href="{{ request()->user()->twoFactorQrCodeUrl() }}">
                    {!! request()->user()->twoFactorQrCodeSvg() !!}
                </a>
            </p>

            <form method="post" action="{{ route('two-factor.confirm') }}">
                @csrf

                <div>
                    <label for="code">@lang('Authentication code')</label>
                    <input type="text" name="code" required autocomplete="one-time-code">

                    @error('code', 'confirmTwoFactorAuthentication')
                    <div class="invalid">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <button type="submit">@lang('Confirm')</button>
                </div>
            </form>

        @else

            <p>
                @lang('Two-factor authentication (2FA) is an additional layer of security that ensures that only you can access your Account, even if your password is revealed to someone else.')
            </p>

            <p>
                @lang('Before using 2FA, you must install any TOTP application (e.g. Google Authenticator, Twilio Authy or other) on your trusted device (a phone usually) and connect it by scanning the QR-code that will appear here after enabling the function.')
            </p>

            <p>
                @lang('The first time you sign in on a new device or browser, you\'ll need to enter your password and the digital verification code that\'s automatically displayed on your trusted device in the TOTP app.')
            </p>

            <form method="post" action="{{ route('two-factor.enable') }}">
                @csrf

                <div>
                    <button type="submit">@lang('Enable 2FA')</button>
                </div>
            </form>

        @endif
    @endif

@endsection
