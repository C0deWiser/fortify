<div>
    <!-- https://laravel.com/docs/12.x/fortify#resetting-the-password -->

    <h1>@lang('Resetting the Password')</h1>

    @include('auth.status')

    <form method="post" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" required autofocus autocomplete="email" value="{{ request()->input('email') }}">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">@lang('New password')</label>
            <input type="password" name="password" required autocomplete="new-password">

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">@lang('Password confirmation')</label>
            <input type="password" name="password_confirmation" required>

            @error('password_confirmation')
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