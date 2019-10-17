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
        @include('car.list')
    @endisset

@endsection

@section('sidebar.car')
    <ul>
        {{--        <li>--}}
        {{--            <a class="text-decoration-none text-capitalize"--}}
        {{--               href="{{ route('cars.create') }}">--}}
        {{--                {{ __('car.new') }}--}}
        {{--            </a>--}}
        {{--        </li>--}}
    </ul>
@endsection
