@php
    $passkeys = request()->user()->passkeys()->paginate();
@endphp
<div>
    <h1 class="h">@lang('Passkeys')</h1>

    @include('auth.status')

    @dump($passkeys)
</div>
