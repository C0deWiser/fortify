<div>

    <h1>@lang('Profile information')</h1>

    @include('auth.status')

    <form method="post" action="{{ route('user-profile-information.update') }}">
        @csrf
        @method('PUT')

        <div>
            <label for="name">@lang('Name')</label>
            <input type="text" name="name" required value="{{ request()->user()->name }}">

            @error('name', 'updateProfileInformation')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" required value="{{ request()->user()->email }}">

            @error('email', 'updateProfileInformation')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @if(request()->user()->email_verified_at)
            <div class="mb-4 font-medium text-sm text-green-600">
                @lang('Email is verified')
            </div>
        @else
            <div>
                <a href="{{ route('verification.notice') }}">
                    @lang('Verify email now')
                </a>
            </div>
        @endif

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>

    </form>

</div>