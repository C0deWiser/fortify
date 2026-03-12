<div>
    <!-- https://laravel.com/docs/12.x/fortify#authenticating-with-two-factor-authentication -->

    <h1>@lang('Login to the application')</h1>

    @include('auth.status')

    <form method="post" action="{{ route('two-factor.login.store') }}">
        @csrf

        <div>
            <label for="code">@lang('Confirmation code')</label>
            <input type="text" name="code" required autofocus autocomplete="one-time-code">

            @error('code')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">@lang('Confirm')</button>
        </div>

    </form>

</div>
