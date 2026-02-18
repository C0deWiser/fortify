<div>
    <!-- https://laravel.com/docs/12.x/fortify#registration -->

    <h1>@lang('Registration')</h1>

    @include('auth.status')

    <form method="post" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">@lang('Name')</label>
            <input type="text" name="name" required value="{{ old('name') }}">

            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" required value="{{ old('email') }}">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">@lang('Password')</label>
            <input type="password" name="password" required>

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
