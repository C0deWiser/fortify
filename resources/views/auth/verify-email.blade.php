<div>
    <!-- https://laravel.com/docs/12.x/fortify#email-verification -->

    <h1>@lang('Email Verification')</h1>

    <p>
        @lang('You have to verify your email before you may continue to the application.')
        <br>
        {!! str(
            __('Your email is `:email`', ['email' => request()->user()->email])
        )->markdown() !!}
    </p>

    @if(\Illuminate\Support\Facades\Route::has('user-profile-information.show'))
        <p>
            {!! str(
                __('You may change your email at [profile page](:href).', [
                    'href' => route('user-profile-information.show')
                ])
            )->markdown() !!}
        </p>
    @endif

    @if (session('status') == \Laravel\Fortify\Fortify::VERIFICATION_LINK_SENT)
        @include('auth.status')
    @else
        <div class="mb-4 font-medium text-sm text-green-600">
            @lang('Press a button below and we will send you a new email verification link.')
        </div>
    @endif

    <form method="post" action="{{ route('verification.send') }}">
        @csrf

        <div>
            <button type="submit">@lang('Send verification link')</button>
        </div>

    </form>

    <form method="post" action="{{ route('logout') }}">
        @csrf

        <div>
            <button type="submit">@lang('Sign Out')</button>
        </div>
    </form>

    <div>
        <a href="/">@lang('Home')</a>
    </div>

</div>
