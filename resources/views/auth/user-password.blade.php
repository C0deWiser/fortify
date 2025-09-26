<div>

    <h1>{{ __('Password') }}</h1>

    @include('auth.status')

    <form method="post" action="{{ route('user-password.update') }}">
        @csrf
        @method('PUT')

        <div>
            <label for="current_password">{{ __('Current password') }}</label>
            <input type="password" name="current_password" required>

            @error('current_password', 'updatePassword')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">{{ __('New password') }}</label>
            <input type="password" name="password" required>

            @error('password', 'updatePassword')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">{{ __('Password confirmation') }}</label>
            <input type="password" name="password_confirmation" required>

            @error('password_confirmation', 'updatePassword')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Submit') }}</button>
        </div>

    </form>

</div>