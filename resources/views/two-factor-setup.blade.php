<div>

    <h1>{{ __('Two-factor authentication') }}</h1>

    <p>
        {{ __('Two-factor authentication (2FA) is an additional layer of security that ensures that only you can access your Account, even if your password is revealed to someone else.') }}
    </p>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __(session('status')) }}
        </div>
    @endif

    @if (request()->user()->hasEnabledTwoFactorAuthentication())

        <!-- https://laravel.com/docs/12.x/fortify#displaying-the-recovery-codes -->

        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('These recovery codes allow the user to authenticate if they lose access to their mobile device.') }}
        </div>
        <ul>
            @foreach (request()->user()->recoveryCodes() as $code)
                <li><code>{{ $code }}</code></li>
            @endforeach
        </ul>

        <form method="post" action="{{ route('two-factor.recovery-codes') }}">
            @csrf

            <div>
                <button type="submit">{{ __('Refresh recovery codes') }}</button>
            </div>
        </form>

        <!-- https://laravel.com/docs/12.x/fortify#disabling-two-factor-authentication -->

        <form method="post" action="{{ route('two-factor.disable') }}">
            @csrf
            @method('delete')

            <div>
                <button type="submit">{{ __('Disable 2FA') }}</button>
            </div>
        </form>

    @else

        <!-- https://laravel.com/docs/12.x/fortify#enabling-two-factor-authentication -->

        @if (session('status') == \Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED)
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Please finish configuring two factor authentication below.') }}
            </div>

            <a href="{{ request()->user()->twoFactorQrCodeUrl() }}">
                {!! request()->user()->twoFactorQrCodeSvg() !!}
            </a>

            <form method="post" action="{{ route('two-factor.confirm') }}">
                @csrf

                <div>
                    <label for="code">{{ __('Confirmation code') }}</label>
                    <input type="text" name="code" required>

                    @error('code')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <button type="submit">{{ __('Confirm') }}</button>
                </div>
            </form>

        @else

            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Before using 2FA, you must install any TOTP application (e.g. Google Authenticator, Twilio Authy or other) on your trusted device (a phone usually) and connect it by scanning the QR-code that will appear here after enabling the function.') }}
            </div>

            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __("The first time you sign in on a new device or browser, you'll need to enter your password and the digital verification code that's automatically displayed on your trusted device in the TOTP app.") }}
            </div>

            <form method="post" action="{{ route('two-factor.enable') }}">
                @csrf

                <div>
                    <button type="submit">{{ __('Enable 2FA') }}</button>
                </div>
            </form>

        @endif
    @endif

    <form method="post" action="{{ route('logout') }}">
        @csrf

        <div>
            <button type="submit">{{ __('Sign Out') }}</button>
        </div>
    </form>

</div>
