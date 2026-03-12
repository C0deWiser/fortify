<div>

    <h1>@lang('Password')</h1>

    @include('auth.status')

    <form method="post" action="{{ route('user-password.update') }}">
        @csrf
        @method('PUT')

        <div>
            <label for="current_password">@lang('Current password')</label>
            <input type="password" name="current_password" required autofocus autocomplete="current-password">

            @error('current_password', 'updatePassword')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">@lang('New password')</label>
            <input type="password" name="password" required autocomplete="new-password">

            @error('password', 'updatePassword')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">@lang('Password confirmation')</label>
            <input type="password" name="password_confirmation" required>

            @error('password_confirmation', 'updatePassword')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>

    </form>

</div>