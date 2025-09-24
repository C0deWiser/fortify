<div>
    <!-- https://laravel.com/docs/12.x/fortify#requesting-a-password-reset-link -->

    <h1>{{ __('Requesting a Password Reset Link') }}</h1>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __(session('status')) }}
        </div>
    @endif

    <form method="post" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" required value="{{ old('email') }}">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Submit') }}</button>
        </div>

    </form>

    <div>
        <a href="{{ route('login') }}">{{ __('Sign In') }}</a>
    </div>

</div>
