<div>

    <h1>{{ __('Profile information') }}</h1>

    @include('auth.status')

    <form method="post" action="{{ route('user-profile-information.update') }}">
        @csrf
        @method('PUT')

        <div>
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" required value="{{ request()->user()->name }}">

            @error('name', 'updateProfileInformation')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" required value="{{ request()->user()->email }}">

            @error('email', 'updateProfileInformation')
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

</div>