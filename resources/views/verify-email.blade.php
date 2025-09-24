<div>
    <!-- https://laravel.com/docs/12.x/fortify#email-verification -->

    <h1>{{ __('Email Verification') }}</h1>

    <p>
        {{ __('You have to verify your email before you may continue to the application.') }}
    </p>

    <p>
        {{ __('Your email: :email', ['email' => request()->user()->email]) }}
    </p>

    @if(\Illuminate\Support\Facades\Route::has('user-profile'))
        <p>
            {!! str(
                    __('You may change your email at [profile page](:href).', ['href' => route('user-profile')])
                )->markdown()
            !!}
        </p>
    @endif

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __(session('status')) }}
        </div>
    @else
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Press a button below and we will send you a new email verification link.') }}
        </div>
    @endif

    <form method="post" action="{{ route('verification.send') }}">
        @csrf

        <div>
            <button type="submit">{{ __('Send verification link') }}</button>
        </div>

    </form>

    <form method="post" action="{{ route('logout') }}">
        @csrf

        <div>
            <button type="submit">{{ __('Sign Out') }}</button>
        </div>
    </form>

    <div>
        <a href="/">{{ __('Home') }}</a>
    </div>

</div>
