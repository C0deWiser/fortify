<div>
    <!-- https://laravel.com/docs/12.x/fortify#password-confirmation -->

    <h1>{{ __('Password Confirmation') }}</h1>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __(session('status')) }}
        </div>
    @endif

    <form method="post" action="{{ route('password.confirm.store') }}">
        @csrf

        <div>
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" required>

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Submit') }}</button>
        </div>
    </form>

    <div>
        <a href="/">{{ __('Home') }}</a>
    </div>
</div>
