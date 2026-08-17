@php
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Support\Facades\Route;
    use Laravel\Fortify\Features;
@endphp

<nav>
    @auth
        <a href="/">@lang('Home')</a>

        <x-fortify-link route="user-profile-information.show" :when="Features::canUpdateProfileInformation()">
            @lang('Profile information')
        </x-fortify-link>

        <x-fortify-link route="user-password.show" :when="Features::canUpdatePasswords()">
            @lang('Password')
        </x-fortify-link>

        <x-fortify-link route="two-factor.show" :when="Features::canManageTwoFactorAuthentication()">
            @lang('Two-factor authentication')
        </x-fortify-link>

        <x-fortify-link route="user-passkey.index" :when="Features::canManagePasskeys()">
            @lang('Passkeys')
        </x-fortify-link>

        <x-fortify-link route="verification.notice" :when="
                auth()->user() instanceof MustVerifyEmail &&
                ! request()->user()->hasVerifiedEmail()">
            @lang('Email Verification')
        </x-fortify-link>

        <form method="post" action="{{ route('logout') }}">
            @csrf
            <div>
                <button type="submit" class="button-link">@lang('Sign Out')</button>
            </div>
        </form>
    @endauth

    @guest
        <x-fortify-link route="login">
            @lang('Sign In')
        </x-fortify-link>

        <x-fortify-link route="register" :when="Features::enabled(Features::registration())">
            @lang('Sign Up')
        </x-fortify-link>

        <x-fortify-link route="password.request" :when="Features::enabled(Features::resetPasswords())">
            @lang('Password reset')
        </x-fortify-link>
    @endguest
</nav>
