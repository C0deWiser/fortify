<div>

    <h1>{{ __('User Account') }}</h1>

    <h2>{{ __('Profile information') }}</h2>

    <form method="post" action="{{ route('user-profile') }}">
        @csrf
        @method('PUT')

        @if (session('status') == 'profile-information-updated')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __(session('status')) }}
            </div>
        @endif

        <div>
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" required value="{{ request()->user()->name }}">

            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" required value="{{ request()->user()->email }}">

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @if(request()->user()->email_verified_at)
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Email is verified') }}
            </div>
        @else
            <div>
                <a href="{{ route('verification.notice') }}">
                    {{ __('Verify email now') }}
                </a>
            </div>
        @endif

        <div>
            <button type="submit">{{ __('Submit') }}</button>
        </div>

    </form>

    <h2>{{ __('Password') }}</h2>

    <form method="post" action="{{ route('user-password.update') }}">
        @csrf
        @method('PUT')

        @if (session('status') == 'password-updated')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __(session('status')) }}
            </div>
        @endif

        <div>
            <label for="current_password">{{ __('Current password') }}</label>
            <input type="password" name="current_password" required>

            @error('current_password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">{{ __('New password') }}</label>
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

</div>