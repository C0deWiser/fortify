@php
    use Laravel\Passkeys\Passkey;
    /** @var Passkey $passkey */

    $passkeys = request()->user()->passkeys()->paginate();

    $date_formatter = fn(
        int $dateType = \IntlDateFormatter::SHORT,
        int $timeType = \IntlDateFormatter::SHORT,
        \IntlCalendar|int|null $calendar = \IntlDateFormatter::GREGORIAN) => datefmt_create(
            config('app.locale'),
            $dateType,
            $timeType,
            config('app.timezone'),
            $calendar
        );

@endphp

@extends('fortify::layouts.fortify')

@section('title', __('Passkeys'))

@section('content')

    <!-- https://laravel.com/docs/13.x/fortify#passkeys -->

    <h1>@lang('Passkeys')</h1>

    @include('fortify::fragments.status')

    <p>@lang('Passkeys allow users to authenticate without passwords using platform authenticators such as Face ID, Touch ID, Windows Hello, or hardware security keys.')</p>

    <p class="alert" id="passkeyUnsupported" style="display: none">
        @lang('Your device does not support passkeys.')
    </p>

    @if($passkeys->isNotEmpty())

        <h2>@lang('Stored Passkeys')</h2>

        @foreach($passkeys as $passkey)
            <div class="row">
                <h3>{{ $passkey->name }}</h3>

                @if($passkey->created_at)
                    <p title="{{ $date_formatter()->format($passkey->created_at) }}">
                        @lang('Created at :date', [
                            'date' => $date_formatter(timeType: -1)->format($passkey->created_at)
                        ])</p>
                @endif

                @if($passkey->last_used_at)
                    <p title="{{ $date_formatter()->format($passkey->last_used_at) }}">
                        @lang('Last used :age ago', [
                            'age' => now()
                                ->diffAsCarbonInterval($passkey->last_used_at)
                                ->forHumans(['short' => false, 'parts' => 1])
                            ])
                    </p>
                @endif

                <form method="post" action="{{ route('passkey.destroy', $passkey->id) }}">
                    @csrf
                    @method('DELETE')
                    <div>
                        <button type="submit">@lang('Delete')</button>
                    </div>
                </form>
            </div>
        @endforeach

        {{ $passkeys->links() }}

    @endif

    <form method="get" action="{{ route('passkey.registration-options') }}"
          id="passkeyRegister"
          data-store-url="{{ route('passkey.store') }}"
          style="display: none">
        @csrf

        <h2>@lang('Add Passkey')</h2>

        <div>
            <label for="name">@lang('Passkey name')</label>
            <input type="text" name="name" required value="{{ old('name') }}" placeholder="@lang('e.g. My Phone')">

            <div class="invalid">@error('name'){{ $message }}@enderror</div>
        </div>

        <div>
            <button type="submit">@lang('Submit')</button>
        </div>
    </form>

    @push('scripts')
        <script src="/vendor/fortify/passkeys.js" defer></script>
        <script src="/vendor/fortify/user-passkeys.js" defer></script>
    @endpush

@endsection
