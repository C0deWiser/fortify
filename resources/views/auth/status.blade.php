@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">

        @switch (session('status'))
            @case(\Laravel\Fortify\Fortify::PASSWORD_UPDATED)
                {{ __('Your password has been updated.') }}
                @break
            @case(\Laravel\Fortify\Fortify::PROFILE_INFORMATION_UPDATED)
                {{ __('Your profile information has been updated.') }}
                @break
            @case(\Laravel\Fortify\Fortify::RECOVERY_CODES_GENERATED)
                {{ __('Recovery codes have been generated.') }}
                @break
            @case(\Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_CONFIRMED)
                {{ __('Two factor authentication confirmed.') }}
                @break
            @case(\Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_DISABLED)
                {{ __('Two factor authentication disabled.') }}
                @break
            @case(\Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED)
                {{ __('Two factor authentication enabled.') }}
                @break
            @case(\Laravel\Fortify\Fortify::VERIFICATION_LINK_SENT)
                {{ __('A new email verification link has been emailed to you!') }}
                @break
            @default
                {{ session('status') }}
        @endswitch
    </div>
@endif