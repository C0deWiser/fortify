<div>
    <!-- https://laravel.com/docs/12.x/fortify#authentication -->

    <h1>{{ __('Authentication') }}</h1>

    @include('auth.status')

    <form method="post" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" required value="{{ old('email') }}">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" required>

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="remember">{{ __('Remember me') }}</label>
            <input type="checkbox" name="remember">
        </div>

        <div>
            <button type="submit">{{ __('Submit') }}</button>
        </div>

    </form>

    @if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::resetPasswords()))
    <div>
        <a href="{{ route('password.request') }}">{{ __('Password reset') }}</a>
    </div>
    @endif

    @if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
    <div>
        <a href="{{ route('register') }}">{{ __('Sign Up') }}</a>
    </div>
    @endif

</div>