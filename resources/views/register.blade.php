<div>
    <!-- https://laravel.com/docs/12.x/fortify#registration -->

    <h1>{{ __('Registration') }}</h1>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __(session('status')) }}
        </div>
    @endif

    <form method="post" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" required value="{{ old('name') }}">

            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

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
            <label for="password_confirmation">{{ __('Password confirmation') }}</label>
            <input type="password" name="password_confirmation" required>

            @error('password_confirmation')
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
