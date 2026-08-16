@extends('fortify::layouts.fortify')

@section('title', __('Profile information'))

@section('content')

    <h1>@lang('Profile information')</h1>

    @include('fortify::fragments.status')

    <form method="post" action="{{ route('user-profile-information.update') }}">
        @csrf
        @method('PUT')

        <div>
            <label for="name">@lang('Name')</label>
            <input type="text" name="name" required autofocus autocomplete="name"
                   value="{{ request()->user()->name }}">

            @error('name', 'updateProfileInformation')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">@lang('Email')</label>
            <input type="email" name="email" required autocomplete="email" value="{{ request()->user()->email }}">

            @error('email', 'updateProfileInformation')
            <div class="invalid">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>

    </form>

@endsection