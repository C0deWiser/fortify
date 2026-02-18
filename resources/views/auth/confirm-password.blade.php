<div>
    <!-- https://laravel.com/docs/12.x/fortify#password-confirmation -->

    <h1>@lang('Password Confirmation')</h1>

    @include('auth.status')

    <form method="post" action="{{ route('password.confirm.store') }}">
        @csrf

        <div>
            <label for="password">@lang('Password')</label>
            <input type="password" name="password" required>

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>
    </form>

    <div>
        <a href="/">@lang('Home')</a>
    </div>
</div>
