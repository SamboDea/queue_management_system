@extends('errors.layout')

@section('title', '500 — Server Error')
@section('accent', '#ef4444')
@section('accent-dim', 'rgba(239,68,68,0.10)')
@section('code', '500')
@section('badge-text', 'Server Error')
@section('heading', 'Internal Server Error')
@section('description',
    'Our server hit an unexpected error. We\'ve been notified and are working on a fix. Please try
    again in a few moments.')

@section('actions')
    <a href="javascript:location.reload()" class="btn btn-primary">
        <svg class="icon" viewBox="0 0 24 24">
            <polyline points="23 4 23 10 17 10" />
            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
        </svg>
        Try Again
    </a>
    <a href="{{ url('/') }}" class="btn btn-ghost">
        <svg class="icon" viewBox="0 0 24 24">
            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        Back to Home
    </a>
@endsection
