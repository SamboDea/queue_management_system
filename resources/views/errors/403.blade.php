@extends('errors.layout')

@section('title', '403 — Forbidden')
@section('accent', '#f59e0b')
@section('accent-dim', 'rgba(245,158,11,0.10)')
@section('code', '403')
@section('badge-text', 'Access Forbidden')
@section('heading', 'You don\'t have permission here')
@section('description',
    'Your account doesn\'t have the required access to view this page. If you think this is a
    mistake, please contact your administrator.')

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
