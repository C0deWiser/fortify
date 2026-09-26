@extends('fortify::layouts.fortify')

@section('title', __('Password Confirmed'))

@section('content')

    <h1>@lang('Password Confirmed')</h1>

    {!! str(__('This page is protected with `:middleware` middleware.', [
        'middleware' => 'password.confirm'
    ]))->markdown() !!}

@endsection
