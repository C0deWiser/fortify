<div>
    <!-- https://laravel.com/docs/12.x/fortify#requesting-a-password-reset-link -->

    <h1>@lang('Requesting a Password Reset Link')</h1>

    @include('auth.status')

    <form method="post" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" required value="{{ old('email') }}">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>

    </form>

    <div>
        <a href="{{ route('login') }}">@lang('Sign In')</a>
    </div>

</div>
