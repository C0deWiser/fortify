<div>
    <!-- https://laravel.com/docs/12.x/fortify#authenticating-with-two-factor-authentication -->

    <h1>{{ __("Login to the application") }}</h1>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __(session('status')) }}
        </div>
    @endif

    <form method="post" action="{{ route('two-factor.login.store') }}">
        @csrf

        <div>
            <label for="code">{{ __('Confirmation code') }}</label>
            <input type="text" name="code" required>

            @error('code')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Confirm') }}</button>
        </div>

    </form>

</div>
