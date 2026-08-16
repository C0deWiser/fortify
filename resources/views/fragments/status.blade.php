@php
    use Laravel\Fortify\Fortify;
@endphp

@if (session('status'))
    <div class="notice">
        @switch (session('status'))
            @case(Fortify::PASSWORD_UPDATED)
                @lang('Your password has been updated.')
                @break
            @case(Fortify::PROFILE_INFORMATION_UPDATED)
                @lang('Your profile information has been updated.')
                @break
            @case(Fortify::RECOVERY_CODES_GENERATED)
                @lang('Recovery codes have been generated.')
                @break
            @case(Fortify::TWO_FACTOR_AUTHENTICATION_CONFIRMED)
                @lang('Two factor authentication confirmed.')
                @break
            @case(Fortify::TWO_FACTOR_AUTHENTICATION_DISABLED)
                @lang('Two factor authentication disabled.')
                @break
            @case(Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED)
                @lang('Two factor authentication enabled.')
                @break
            @case(Fortify::VERIFICATION_LINK_SENT)
                @lang('A new email verification link has been emailed to you!')
                @break
            @case('passkey-registered')
                @lang('A passkey has been stored.')
                @break
            @case('passkey-deleted')
                @lang('A passkey has been deleted.')
                @break
            @default
                {{ session('status') }}
        @endswitch
    </div>
@endif