@php
    use Laravel\Fortify\Features;
    use Laravel\Passkeys\Contracts\PasskeyUser;

    $passkeyUser = auth(config('fortify.guard', 'web'))->user();

    $canConfirmWithPasskey = Features::canManagePasskeys()
        && $passkeyUser instanceof PasskeyUser
        && $passkeyUser->passkeys()->exists();
@endphp

@extends('fortify::layouts.fortify')

@section('title', __('Password Confirmation'))

@section('content')

    <!-- https://laravel.com/docs/12.x/fortify#password-confirmation -->

    <h1>@lang('Password Confirmation')</h1>

    <p class="alert">
        @lang('Action require the user to confirm their password before the action is performed.')
    </p>

    @include('fortify::fragments.status')

    <form method="post" action="{{ route('password.confirm.store') }}">
        @csrf

        <div>
            <label for="password">@lang('Password')</label>
            <input type="password" name="password" id="password" required autofocus autocomplete="current-password">

            <!-- js publishes passkey response errors to here -->
            <div class="invalid">@error('password'){{ $message }}@enderror</div>
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>
    </form>

    @if($canConfirmWithPasskey)

        <div id="passkeyConfirm"
             data-options-url="{{ route('passkey.confirm-options') }}"
             data-confirm-url="{{ route('passkey.confirm') }}"
             hidden></div>

        @push('scripts')
            <script src="/vendor/fortify/passkeys.js" defer></script>
            <script src="/vendor/fortify/confirm-password.js" defer></script>
        @endpush

    @endif

@endsection
