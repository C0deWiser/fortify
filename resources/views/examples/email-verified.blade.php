@extends('fortify::layouts.fortify')

@section('title', __('Email Verified'))

@section('content')

    <h1>@lang('Email Verified')</h1>

    {!! str(__('This page is protected with `:middleware` middleware.', [
        'middleware' => 'verified'
    ]))->markdown() !!}

@endsection
