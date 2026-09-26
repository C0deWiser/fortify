<nav>
    <a href="/">@lang('Home')</a>

    @inject('menu', 'Codewiser\Fortify\NavStack')

    @foreach($menu->toArray() as $item)
        <x-fortify-link route="{{ $item['route'] }}">
            {!! $item['name'] !!}
        </x-fortify-link>
    @endforeach

    @auth
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <div>
                <button type="submit" class="button-link">@lang('Sign Out')</button>
            </div>
        </form>
    @endauth
</nav>
