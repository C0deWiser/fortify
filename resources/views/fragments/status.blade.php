@php
    use Laravel\Fortify\Fortify;
@endphp

@if (session('status'))
    <div class="notice">
        @if(in_array(session('status'), [
            Fortify::PASSWORD_UPDATED,
            Fortify::PROFILE_INFORMATION_UPDATED,
            Fortify::RECOVERY_CODES_GENERATED,
            Fortify::TWO_FACTOR_AUTHENTICATION_CONFIRMED,
            Fortify::TWO_FACTOR_AUTHENTICATION_DISABLED,
            Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED,
            Fortify::VERIFICATION_LINK_SENT,
            'passkey-registered',
            'passkey-deleted'
        ]))
            @lang('fortify::messages.'.session('status'))
        @else
            {{ session('status') }}
        @endif
    </div>
@endif