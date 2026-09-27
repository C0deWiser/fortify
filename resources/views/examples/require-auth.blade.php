@extends('fortify::layouts.fortify')

@section('title', __('Authenticated'))

@section('content')

    <h1>@lang('Authenticated')</h1>

    {!! str(__('This page is protected with `:middleware` middleware.', [
        'middleware' => 'auth'
    ]))->markdown() !!}

@endsection
