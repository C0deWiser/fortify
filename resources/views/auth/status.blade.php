@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">

        @switch (session('status'))
            @case(\Laravel\Fortify\Fortify::PASSWORD_UPDATED)
                @lang('Your password has been updated.')
                @break
            @case(\Laravel\Fortify\Fortify::PROFILE_INFORMATION_UPDATED)
                @lang('Your profile information has been updated.')
                @break
            @case(\Laravel\Fortify\Fortify::RECOVERY_CODES_GENERATED)
                @lang('Recovery codes have been generated.')
                @break
            @case(\Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_CONFIRMED)
                @lang('Two factor authentication confirmed.')
                @break
            @case(\Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_DISABLED)
                @lang('Two factor authentication disabled.')
                @break
            @case(\Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED)
                @lang('Two factor authentication enabled.')
                @break
            @case(\Laravel\Fortify\Fortify::VERIFICATION_LINK_SENT)
                @lang('A new email verification link has been emailed to you!')
                @break
            @default
                {{ session('status') }}
        @endswitch
    </div>
@endif