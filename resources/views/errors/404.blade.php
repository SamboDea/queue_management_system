@extends('errors.layout')

@section('title', '404 — Page Not Found')
@section('accent', '#6c63ff')
@section('accent-dim', 'rgba(108,99,255,0.12)')
@section('code', '404')
@section('badge-text', 'Page Not Found')
@section('heading', 'Looks like you\'re lost in space')
@section('description',
    'The page you\'re looking for doesn\'t exist, was moved, or never existed in the first place.
    Double-check the URL or head back home.')

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary">
        <svg class="icon" viewBox="0 0 24 24">
            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        Back to Home
    </a>
    <a href="javascript:history.back()" class="btn btn-ghost">
        <svg class="icon" viewBox="0 0 24 24">
            <polyline points="15 18 9 12 15 6" />
        </svg>
        Go Back
    </a>
@endsection
