@php
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Laravel\Fortify\Contracts\PasskeyUser;
    use Laravel\Fortify\Features;
@endphp

<nav>
    @auth
        <a href="/">@lang('Home')</a>
        @if(Features::canUpdateProfileInformation())
            <a href="{{ route('user-profile-information.show') }}">
                @lang('Profile information')
            </a>
        @endif
        @if(Features::enabled(Features::updatePasswords()))
            <a href="{{ route('user-password.show') }}">
                @lang('Password')
            </a>
        @endif
        @if (Features::canManageTwoFactorAuthentication())
            <a href="{{ route('two-factor.show') }}">
                @lang('Two-factor authentication')
            </a>
        @endif
        @if(auth()->user() instanceof PasskeyUser && Features::canManagePasskeys())
            <a href="{{ route('passkey.index') }}">
                @lang('Passkeys')
            </a>
        @endif
        @if(auth()->user() instanceof MustVerifyEmail && ! request()->user()->hasVerifiedEmail())
            <a href="{{ route('verification.notice') }}">
                @lang('Email Verification')
            </a>
        @endif
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <div>
                <button type="submit" class="button-link">@lang('Sign Out')</button>
            </div>
        </form>
    @endauth

    @guest
        <a href="{{ route('login') }}">@lang('Sign In')</a>
        @if(Features::enabled(Features::registration()))
            <a href="{{ route('register') }}">@lang('Sign Up')</a>
        @endif
        @if(Features::enabled(Features::resetPasswords()))
            <a href="{{ route('password.request') }}">@lang('Password reset')</a>
        @endif
    @endguest
</nav>
