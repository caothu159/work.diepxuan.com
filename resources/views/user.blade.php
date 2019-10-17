<?php ?>
@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @isset($template)
        @include($template)
    @else
        @include('user.list')
    @endisset

@endsection

@section('sidebar.user')
    <ul>
        <li>
            <a class="text-decoration-none text-capitalize"
               href="{{ route('users.create') }}">
                {{ __('user.new') }}
            </a>
        </li>
    </ul>
@endsection
