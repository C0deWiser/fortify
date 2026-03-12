<div>
    <!-- https://laravel.com/docs/12.x/fortify#authentication -->

    <h1>@lang('Authentication')</h1>

    @include('auth.status')

    <form method="post" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" required autofocus autocomplete="email" value="{{ old('email') }}">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">@lang('Password')</label>
            <input type="password" name="password" required autocomplete="current-password">

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="remember">@lang('Remember me')</label>
            <input type="checkbox" name="remember">
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>

    </form>

    @if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::resetPasswords()))
    <div>
        <a href="{{ route('password.request') }}">@lang('Password reset')</a>
    </div>
    @endif

    @if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
    <div>
        <a href="{{ route('register') }}">@lang('Sign Up')</a>
    </div>
    @endif

</div>